<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Subject;
use App\Partition;
use App\Invite;
use App\Question;
use App\Answer;
use App\User;
use App\Role;
use App\Permission;
use App\TestRoom;

class HomeController extends Controller
{

    public function index()
    {
      $subjects = collect(Subject::where('trash', '=', false)->get()->toArray())->groupBy('name')->count();
      $partitions = Partition::where('trash', '=', false)->count();
      $invites = Invite::count();
      $questions = Question::where('trash', '=', false)->count();
      $users = User::count();

      $trash = '';
      $testrooms = '';

      if(\Entrust::hasRole('admin')){
       $trash = Question::where('trash', '=', true)->count() + Subject::where('trash', '=', true)->count() + Partition::where('trash', '=', true)->count() + TestRoom::where('teacher_id', '=', \Auth::user()->id)->where('trash', '=', true)->count();
     }elseif (\Entrust::hasRole('teacher')) {
       $testrooms = TestRoom::where('teacher_id', '=', \Auth::user()->id)->count();
     }
      return view('admin.welcome', ['subjects' => $subjects, 'partitions' => $partitions, 'invites' => $invites, 'questions' => $questions, 'users' => $users, 'trash' => $trash, 'testrooms' => $testrooms]);
    }
}
