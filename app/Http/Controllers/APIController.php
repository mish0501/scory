<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Partition;
use App\Subject;
use App\Question;
use App\TestRoom;
use App\TestRoomStudents;
use App\Answer;
use App\MailStore;
use App\Invite;
use App\User;

class APIController extends Controller
{
  public function Partitions(Request $request){
    $this->validate($request, [
       'subject' => 'required'
    ]);
    $subject = $request->get('subject');
    $partitions = Partition::where('subject_id', '=', $subject)->where('trash', '=', false)->get();

    $partitions[0]['token'] = $request->get("_token");

    $partitions->toJSON();

    return $partitions;
  }

  public function Subjects(Request $request){
    $this->validate($request, [
       'class' => 'required',
    ]);
    $class = $request->get('class');
    $subjects = Subject::where('class', '=', $class)->where('trash', '=', false)->get();

    $subjects[0]['token'] = $request->get("_token");

    $subjects->toJSON();

    return $subjects;
  }

  public function CodeGenerate(Request $request){
    $code = app('App\Http\Controllers\TestRoomController')->generateCode();


    return $code;
  }

  public function QuestionGenerate(Request $request){

    $class = $request->get('class');
    $subject = $request->get('subject');
    $partition = $request->get('partition');

    $questions = Question::where('class', '=', $class)
                  ->where('subject_id', '=', $subject)
                  ->where('partition_id', '=', $partition)
                  ->where('trash', false)
                  ->get();

    return $questions;
  }

  public function getAllMessages(Request $request)
  {
    \Carbon\Carbon::setLocale('bg');

    $allMessages = MailStore::orderBy('created_at', 'desc')->where('trash', '=', false)->limit(5)->get();
    $unreadMessagesCount = MailStore::where('read', '=', false)->where('trash', '=', false)->count();

    $messages = [];

    foreach ($allMessages as $key => $message) {
      $messages[$key]['id'] = $message->id;
      $messages[$key]['name'] = $message->name;
      $messages[$key]['time'] = $message->created_at->diffForHumans();
      $messages[$key]['url'] = '/admin/mail/'.$message->id;
    }

    return ['messages' => $messages, 'count' => $unreadMessagesCount];
  }

  public function getMessage(Request $request)
  {
    \Carbon\Carbon::setLocale('bg');

    $message = MailStore::orderBy('created_at', 'desc')->where('trash', '=', false)->first();

    $message->message = str_limit($message->message, 55);
    $message->time = $message->created_at->diffForHumans();

    return $message;
  }

  public function getDashboardInfo()
  {
    $subjects = collect(Subject::where('trash', '=', false)->get()->toArray())->groupBy('name')->count();
    $partitions = Partition::where('trash', '=', false)->count();
    $questions = Question::where('trash', '=', false)->count();

    $invites = null;
    $users = null;
    $trash = null;
    $testrooms = null;

    if(\Entrust::hasRole('admin')){
      $invites = Invite::count();
      $trash = Question::where('trash', '=', true)->count() + Subject::where('trash', '=', true)->count() + Partition::where('trash', '=', true)->count() + TestRoom::where('teacher_id', '=', \Auth::user()->id)->where('trash', '=', true)->count();
      $users = User::count();
    }elseif (\Entrust::hasRole('teacher')) {
      $testrooms = TestRoom::where('teacher_id', '=', \Auth::user()->id)->count();
    }

   return [
     "subjects" => $subjects,
     "partitions" => $partitions,
     "invites" => $invites,
     "questions" => $questions,
     "users" => $users,
     "trash" => $trash,
     "testrooms" => $testrooms
   ];
  }
}
