<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lesson;

class LessonController extends Controller
{
  public function index()
  {
    return Lesson::where('trash', false)->with('subject', 'partition', 'user')->get();
  }

  public function store(Request $request)
  {
    $validator = \Validator::make($request->all(), [
      'name' => 'required|min:5',
      'class' => 'required',
      'subject_id' => 'required',
      'partition_id' => 'required',

    ]);

    if ($validator->fails()) {
      return ['error' => $validator->errors()];
    }

    $files = $request->get('files');
    $files_ids = [];

    for ($i=0; $i < count($files); $i++) {
      $files_ids[$i] = $files[$i]['id'];
    }

    $input = $request->all();

    $input['user_id'] = \Auth::user()->id;

    $lesson = Lesson::create($input);

    $lesson->files()->sync($files_ids);

    return response()->json([
      'success' => 'Урокът беше успешно добавен!',
    ]);
  }

  public function update(Request $request, $id)
  {
    $validator = \Validator::make($request->all(), [
      'name' => 'required|min:5',
      'class' => 'required',
      'subject_id' => 'required',
      'partition_id' => 'required',

    ]);

    if ($validator->fails()) {
      return ['error' => $validator->errors()];
    }

    $files = $request->get('files');
    $files_ids = [];

    for ($i=0; $i < count($files); $i++) {
      $files_ids[$i] = $files[$i]['id'];
    }

    $input = $request->all();

    $lesson = Lesson::find($id);

    $lesson->fill($input)->save();
    $lesson->files()->sync($files_ids);

    return response()->json([
      'success' => 'Урокът беше успешно редактиран!',
    ]);
  }

  public function edit($id)
  {
    $lesson = Lesson::where('id', $id)->with('files')->get()[0];
    $subjects = \App\Subject::where('class', '=', $lesson['class'])->get();
    $partitions = \App\Partition::where('subject_id', '=', $lesson['subject_id'])->get();

    return ['lesson' => $lesson, 'subjects' => $subjects, 'partitions' => $partitions];
  }

  public function selectLessons(Request $request)
  {
    $lessons = Lesson::where('class', $request->get('class'))
                      ->where('subject_id', $request->get('subject_id'))
                      ->where('partition_id', $request->get('partition_id'))
                      ->orderBy('created_at', "asc")
                      ->get();
    return $lessons;
  }

  public function show($id)
  {
    $lesson = Lesson::where('id', $id)->with('files')->first();

    return $lesson;
  }
}
