<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subject;
use App\Partition;
use App\Question;
use App\Answer;
use View;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data = Subject::where('trash', '=', false)->get();
      return $data;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validator = \Validator::make($request->all(), [
         'name' => 'required|min:5',
         'class' => 'required'
       ]);

       if ($validator->fails()) {
         return ['error' => $validator->errors()];
       }

       $input = $request->all();

       Subject::create($input);

       return response()->json([
         'success' => 'Предметът беше успешно добавен!',
       ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $data = Subject::find($id);
      return $data;
    }

    public function update(Request $request, $id)
    {
      $subject = Subject::findOrFail($id);

      $validator = \Validator::make($request->all(), [
        'name' => 'required|min:5',
        'class' => 'required'
      ]);

      if ($validator->fails()) {
        return ['error' => $validator->errors()];
      }

      $input = $request->all();

      $subject->fill($input)->save();

      return response()->json([
        'success' => 'Предметът беше успешно редактиран!',
      ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $subject = Subject::findOrFail($id);

      $partitions = Partition::where('subject_id', '=', $id);

      foreach ($partitions->get() as $value) {

        $questions = Question::where('subject_id', '=', $id)->where('partition_id', '=', $value->id);

        foreach ($questions->get() as $value) {
          $answers = Answer::where('question_id', '=', $value->id);

          $answers->update(['trash' => true]);
        }

        $questions->update(['trash' => true]);
      }

      $partitions->update(['trash' => true]);

      $subject->update(['trash' => true]);

      return response()->json([
        'success' => 'Предметът беше успешно преместено в кошчето!',
      ]);
    }
}
