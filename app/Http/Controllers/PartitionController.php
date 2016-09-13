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
      return view('admin.partition.index', ['partitions' => $partitions]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      for ($i=5; $i < 13; $i++) {
        $subjects = Subject::where('class', '=', $i)->get();

        foreach ($subjects as $key => $value) {
          $subjectsData[$i.' Клас'][$value->id] = $value->name;
        }
      }

      return view('admin.partition.create', ['subjects' => $subjectsData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
         'name' => 'required|min:5',
         'subject_id' => 'required',
         'class' => 'required'
      ]);

      $subject = Subject::findOrFail($request->get('subject_id'));

      $input = $request->all();

      Partition::create($input);

      \Session::flash('flash_message', 'Разделът беше успешно добавен!');

      return redirect()->route('admin.partition.index');
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

      return view('admin.partition.edit', ['partition' => $partition, 'subjects' => $subjects]);

    }

    public function update(Request $request, $id)
    {
      $partition = Partition::findOrFail($id);

      $this->validate($request, [
         'name' => 'required|min:5',
         'subject_id' => 'required'
      ]);

      $input = $request->all();

      $partition->fill($input)->save();

      \Session::flash('flash_message', 'Разделът беше успешно редактиран!');

       return redirect()->route('admin.partition.index');
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
