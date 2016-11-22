<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Partition;
use App\Subject;
use App\Question;
use App\Answer;
use View;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $questions = Question::where('trash', '=', false)->with('subject', 'partition', 'user')->get();

      return $questions;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $rules = [
         'name' => 'required|min:5',
         'class' => 'required',
         'subject_id' => 'required',
         'partition_id' => 'required',
         'type' => 'required'
       ];


       $attrName = [
         0 => 'с първият отговор',
         1 => 'с вторият отговор',
         2 => 'с третият отговор',
         3 => 'с четвъртият отговор',
         4 => 'с петият отговор',
         5 => 'с шестият отговор',
         6 => 'с седмият отговор',
         7 => 'с осмият отговор',
       ];

       foreach ($request->get('answers') as $key => $value) {
        $rules['answers.'.$key.'.name'] = 'required|min:5';
        $messages['answers.'.$key.'.name.required'] = 'Полето '.$attrName[$key].' е задължително.';
        $messages['answers.'.$key.'.name.min'] = 'Полето '.$attrName[$key].' трябва да бъде минимум :min знака.';
       }

       $validator = \Validator::make($request->all(), $rules, $messages);

       if($validator->fails()){
         return ['error' => $validator->errors()];
       }

       $user_id = \Auth::user()->id;

       $input = $request->all();
       $input['user_id'] = $user_id;

       $question = Question::create($input);

       foreach ($request->get('answers') as $key => $value) {
         Answer::create([
           'name' => $value['name'],
           'question_id' => $question->id,
           'correct' => $value['correct']
         ]);
       }

       return [
         'success' => 'Въпросът беше успешно добавен!'
       ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $question = Question::where('id', $id)->with('answers')->get()->toArray()[0];
      $subjects = Subject::where('class', '=', $question['class'])->get();
      $partitions = Partition::where('subject_id', '=', $question['subject_id'])->get();

      return ['question' => $question, 'subjects' => $subjects, 'partitions' => $partitions];

    }

    public function update(Request $request, $id)
    {
      $question = Question::findOrFail($id);

      $rules = [
         'name' => 'required|min:5',
         'class' => 'required',
         'subject_id' => 'required',
         'partition_id' => 'required',
         'answers' => 'required',
         'type' => 'required',
         'removedIds' => 'required'
      ];

      $attrName = [
        0 => 'с първият отговор',
        1 => 'с вторият отговор',
        2 => 'с третият отговор',
        3 => 'с четвъртият отговор',
        4 => 'с петият отговор',
        5 => 'с шестият отговор',
        6 => 'с седмият отговор',
        7 => 'с осмият отговор',
      ];

      foreach ($request->get('answers') as $key => $value) {
        if($key < 4){
          $rules['answers.'.$key.'.id'] = 'required';
        }

        $rules['answers.'.$key.'.name'] = 'required|min:5';

        $messages['answers.'.$key.'.name.required'] = 'Полето '.$attrName[$key].' е задължително.';
        $messages['answers.'.$key.'.name.min'] = 'Полето '.$attrName[$key].' трябва да бъде минимум :min знака.';
      }

      $validator = \Validator::make($request->all(), $rules, $messages);

      if($validator->fails()){
        return ['error' => $validator->errors()];
      }

      $input['name'] = $request->get('name');
      $input['class'] = $request->get('class');
      $input['subject_id'] = $request->get('subject_id');
      $input['partition_id'] = $request->get('partition_id');
      $input['type'] = $request->get('type');

      $question->fill($input)->save();

      foreach ($request->get('answers') as $key => $value) {
        if(array_key_exists('id', $value)){
          // Updating answers
          $answer = Answer::findOrFail($value['id']);

          $input['name'] = $value['name'];
          $input['question_id'] = $id;
          $input['correct'] = $value['correct'];

          $answer->fill($input)->save();
        }else{
          // Creating answers if they don't exists
          $input['name'] = $value['name'];
          $input['question_id'] = $id;
          $input['correct'] = $value['correct'];

          $answer->create($input);
        }
      }

      // Deleting answers
      $removedIds = $request->get('removedIds');

      foreach ($removedIds as $key => $value) {
        $remove_answer[$key] = Answer::where('id', '=', $value)->where('question_id', '=', $id)->delete();
      }

      \Session::flash('flash_message', 'Въпросът беше успешно редактиран!');

      return [
        'success' => 'Въпросът беше успешно редактиран!'
      ];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $question = Question::findOrFail($id);

      $answers = Answer::where('question_id', '=', $id);

      $answers->update(['trash' => true]);

      $question->update(['trash' => true]);

      \Session::flash('flash_message', 'Въпросът беше успешно изтрит!');

      return redirect()->route('admin.question.index');
    }
}
