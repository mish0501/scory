<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TestController;
use App\Partition;
use App\Subject;
use App\Question;
use App\Answer;
use App\TestRoom;
use Session;
use View;

class TestController extends Controller
{
    public function index()
    {
      return view('test.choose', ['class' => true]);
    }
    public function selectSubject(Request $request)
    {
      $subjects = Subject::where('class', '=', $request->get('class'))->get(['id', 'name']);
      return $subjects;
    }

    public function selectPartition(Request $request)
    {

      $this->validate($request, [
         'subject_id' => 'required',
         'class' => 'required'
      ]);

      $input['class'] = $request->class;
      $input['subject_id'] = $request->subject_id;

      $partitions = Partition::where($input)->get(['id', 'name']);
      return $partitions;
    }

    public function selectQuestions(Request $request)
    {
      $this->validate($request, [
         'subject_id' => 'required',
         'partition_id' => 'required',
         'class' => 'required',
         'questionCount' => 'required'
      ]);

      $class = $request->class;
      $partition = $request->partition_id;
      $subject = $request->subject_id;
      $questionCount = $request->questionCount;

      if($questionCount < 3){
        $questionCount = 3;
      }

      $questions = Question::where('class', '=', $class)
                            ->where('partition_id', '=', $partition)
                            ->where('subject_id', '=', $subject)
                            ->with('answers')
                            ->orderByRaw("RAND()")
                            ->limit($questionCount)
                            ->get();

      return $questions;
    }

    public function nextQuestion(Request $request)
    {
      $this->validate($request, [
       'key' => 'required',
       'correct' => 'required'
      ]);

      $key = $request->key;
      $correct = $request->correct;
      $newKey = $key + 1;


      if($request->get('code') !== NULL){
        $code = $request->get('code');
      }else{
        $code = '';
      }

      $questions = Session::get('questions');
      $answers = Session::get('answers');

      $request->session()->put('checked.'.$key, $correct);

      if(isset($questions[$newKey])){
        return view('test.test', ['question' => $questions[$newKey], 'answers' => $answers[$newKey], 'type' => $questions[$newKey]->type, 'key' => $newKey, 'testroomcode' => $code]);
      }
      else{
        if($code !== ''){
          return $this->checkTest(true, $code);
        }
        return $this->checkTest(false);
      }
    }

    public function checkTest(Request $request)
    {
      $this->validate($request, [
       'questions' => 'required',
       'answers' => 'required'
      ]);

      $checked = [];

      $questions = $request->get('questions');

      $userAnswers = '';

      foreach ($questions as $k => $question) {
        $answers = $request->get('answers')[$question['id']];

        if(is_array($answers)){
          $check = 0;
          $userAnswers[$question["id"]] = $answers;

          foreach ($answers as $key => $v) {

            foreach ($question["answers"] as $answerKey => $answer) {
              if($answer->id == $v){
                $questions[$k]["answers"][$answerKey]["checked"] = true;

                if($answer->correct == true){
                  $check ++;
                }else{
                  $check --;
                }
              }
            }

            if($check >= 1){
              $questions[$k]["correct"] = true;
            }elseif($check < 0){
              $questions[$k]["correct"] = false;
            }
          }
        }else{
          $userAnswers[$question["id"]] = $answers;

          foreach ($question["answers"] as $answerKey => $answer) {
            if($answer["id"] == $answers){
              $questions[$k]["answers"][$answerKey]["checked"] = true;

              if($answer["correct"] == true){
                $questions[$k]["correct"] = true;
              }else{
                $questions[$k]["correct"] = false;
              }
            }
          }
        }
      }

      // if($testroom && $code !== NULL){
      //   $correctAnswers = '';
      //   $userAnswers = json_encode($userAnswers);
      //
      //   foreach ($questions as $key => $value) {
      //     if($value->correct == 1){
      //       $correctAnswers ++;
      //     }
      //   }
      //
      //   $name = Session::get('name');
      //   $lastname = Session::get('lastname');
      //
      //   return app('App\Http\Controllers\TestRoomController')->finishTest($correctAnswers, $userAnswers, $code, $name, $lastname);
      // }

      // return view('test.check', ['questions' => $questions, 'answers' => $answers, 'checked' => $checked]);

      return response()->json([
        $questions
      ]);
    }

    public function endTest()
    {
      Session::forget('questions');
      Session::forget('answers');
      Session::forget('checked');

      return redirect(url('/'));
    }

    public function startTestRoomTest($code)
    {
      $testroom = TestRoom::where('code', '=', $code)->get()[0];

      $questions_id = explode(', ', $testroom->questions_id);

      foreach ($questions_id as $key => $value) {
        $questions[$key] = Question::find($value);
      }

      shuffle($questions);

      Session::put('questions', $questions);

      foreach ($questions as $key => $value) {
        $answers[$key] = Answer::where('question_id', '=', $value->id)->orderByRaw("RAND()")->get();
      }

      Session::put('answers', $answers);

      return view('test.test', ['question' => $questions['0'], 'answers' => $answers['0'], 'type' => $questions[0]->type, 'key' => '0', 'testroomcode' => $code]);
    }
}
