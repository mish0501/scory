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

    public function checkTest(Request $request)
    {
      $this->validate($request, [
       'questions' => 'required'
      ]);

      $questions = $request->get('questions');

      foreach ($questions as $k => $question) {
        if(array_key_exists($question["id"], $request->get('answers'))){
          $answers = $request->get('answers')[$question['id']];

          if(is_array($answers)){
            $check = 0;

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
      }

      if($request->get('testroom') && $request->get('code') !== NULL){
        $code = $request->get('code');
        $user = $request->get('user');

        $correctAnswers = 0;
        $userAnswers = json_encode($request->get('answers'));

        foreach ($questions as $key => $value) {
          if(array_key_exists('correct', $value) && $value['correct']== true){
            $correctAnswers ++;
          }
        }

        return app('App\Http\Controllers\TestRoomController')->finishTest($correctAnswers, $userAnswers, $code, $user);
      }

      return response()->json([
        $questions
      ]);
    }

    public function endTest()
    {
      return redirect(url('/'));
    }
}
