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

class PartitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $partitions = Partition::where('trash', '=', false)->with('subject')->get();
      return $partitions;

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
        'subject_id' => 'required',
        'class' => 'required'
      ]);

      if ($validator->fails()) {
        return ['error' => $validator->errors()];
      }

      $input = $request->all();

      Partition::create($input);
      
      return response()->json([
        'success' => 'Разделът беше успешно добавен!',
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
      $partition = Partition::find($id);
      $subjects = Subject::where('class', '=', $partition->class)->get();

      return ['partition' => $partition, 'subjects' => $subjects];

    }

    public function update(Request $request, $id)
    {
      $partition = Partition::findOrFail($id);

      $validator = \Validator::make($request->all(), [
        'name' => 'required|min:5',
        'subject_id' => 'required',
        'class' => 'required'
      ]);

      if ($validator->fails()) {
        return ['error' => $validator->errors()];
      }

      $input = $request->all();

      $partition->fill($input)->save();

      return response()->json([
        'success' => 'Разделът беше успешно редактиран!',
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
      $partition = Partition::findOrFail($id);

      $questions = Question::where('partition_id', '=', $partition->id);

      foreach ($questions->get() as $value) {
        $answers = Answer::where('question_id', '=', $value->id);

        $answers->update(['trash' => true]);
      }

      $questions->update(['trash' => true]);

      $partition->update(['trash' => true]);

      \Session::flash('flash_message', 'Разделът беше успешно преместен в кошчето!');

      return redirect()->route('admin.partition.index');
    }
}
