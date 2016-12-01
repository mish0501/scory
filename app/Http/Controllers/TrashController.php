<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subject;
use App\Partition;
use App\Question;
use App\Answer;
use App\TestRoom;
use App\TestRoomStudents;
use App\MailStore;

class TrashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $questions = Question::where('trash', '=', true)->with('subject', 'partition')->get();
      $subjects = Subject::where('trash', '=', true)->get();
      $partitions = Partition::where('trash', '=', true)->with('subject')->get();

      $testrooms = TestRoom::where('trash', '=', true)->where('teacher_id', '=', \Auth::user()->id)->get();

      $mail = MailStore::where('trash', '=', true)->get();


      return ['subjects' => $subjects, 'partitions' => $partitions, 'questions' => $questions, 'testrooms' => $testrooms, 'mail' => $mail];
    }

    public function renewSubject(Request $request)
    {
      $subject = Subject::where('id', '=', $request->id)->where('trash', '=', true)->update(['trash' => false]);
      $partitions = Partition::where('subject_id', '=', $request->id)->where('trash', '=', true)->update(['trash' => false]);
      $questions = Question::where('subject_id', '=', $request->id)->where('trash', '=', true);

      foreach ($questions->get() as $value) {
        $answers = Answer::where('question_id', '=', $value->id)->where('trash', '=', true)->update(['trash' => false]);
      }

      $questions->update(['trash' => false]);

      return response()->json(['done' => true]);
    }

    public function renewPartition(Request $request)
    {
      $subject = Partition::where('id', '=', $request->id)->where('trash', '=', true)->update(['trash' => false]);
      $questions = Question::where('partition_id', '=', $request->id)->where('trash', '=', true);

      foreach ($questions->get() as $value) {
        $answers = Answer::where('question_id', '=', $value->id)->where('trash', '=', true)->update(['trash' => false]);
      }

      $questions->update(['trash' => false]);

      return response()->json(['done' => true]);
    }

    public function renewQuestion(Request $request)
    {
      $question = Question::where('id', '=', $request->id)->where('trash', '=', true)->update(['trash' => false]);

      $answers = Answer::where('id', '=', $request->id)->where('trash', '=', true)->update(['trash' => false]);

      return response()->json(['done' => true]);
    }

    public function renewTestRoom(Request $request)
    {
      $testroom = TestRoom::where('code', '=', $request->code)->where('trash', '=', true)->update(['trash' => false]);

      $testroom_students = TestRoomStudents::where('code', '=', $request->code)->where('trash', '=', true)->update(['trash' => false]);

      return response()->json(['done' => true]);
    }

    public function renewMail(Request $request)
    {
      $mail = MailStore::where('id', '=', $request->id)->where('trash', '=', true)->update(['trash' => false]);

      return response()->json(['done' => true]);
    }

    public function deleteSubject($id)
    {
      $subject = Subject::where('id', '=', $id)->where('trash', '=', true)->delete();
      $partitions = Partition::where('subject_id', '=', $id)->where('trash', '=', true)->delete();
      $questions = Question::where('subject_id', '=', $id)->where('trash', '=', true);

      foreach ($questions->get() as $value) {
        $answers = Answer::where('question_id', '=', $value->id)->where('trash', '=', true)->delete();
      }

      $questions->delete();

      return response()->json(['done' => true]);
    }

    public function deletePartition($id)
    {
      $partitions = Partition::where('id', '=', $id)->where('trash', '=', true)->delete();
      $questions = Question::where('partition_id', '=', $id)->where('trash', '=', true);

      foreach ($questions->get() as $value) {
        $answers = Answer::where('question_id', '=', $value->id)->where('trash', '=', true)->delete();
      }

      $questions->delete();

      return response()->json(['done' => true]);
    }

    public function deleteQuestion($id)
    {
      $questions = Question::where('id', '=', $id)->where('trash', '=', true)->delete();
      $answers = Answer::where('question_id', '=', $id)->where('trash', '=', true)->delete();

      return response()->json(['done' => true]);
    }

    public function deleteTestRoom($code)
    {
      $testroom = TestRoom::where('code', '=', $code)->where('trash', '=', true)->delete();
      $testroom_students = TestRoomStudents::where('code', '=', $code)->where('trash', '=', true)->delete();

      return response()->json(['done' => true]);
    }

    public function deleteMail($id)
    {
      $mail = MailStore::where('id', '=', $id)->where('trash', '=', true)->delete();

      return response()->json(['done' => true]);
    }
}
