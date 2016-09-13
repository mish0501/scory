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

    public function roles()
    {
      // $teacher = new Role();
      // $teacher->name         = 'teacher';
      // $teacher->display_name = 'Учител'; // optional
      // $teacher->save();

      // $admin = Role::findOrFail(1);
      //
      // $permission = new Permission();
      // $permission->name = 'create-question';
      // $permission->display_name = 'Създава въпроси';
      // $permission->description  = 'Създава нови въпроси';
      // $permission->save();
      //
      // $permission1 = new Permission();
      // $permission1->name = 'edit-question';
      // $permission1->display_name = 'Редактира въпроси';
      // $permission1->description  = 'Редактира, вече съдадените въпроси';
      // $permission1->save();
      //
      // $permission2 = new Permission();
      // $permission2->name = 'list-question';
      // $permission2->display_name = 'Показва въпроси';
      // $permission2->description  = 'Показва, вече съдадените въпроси';
      // $permission2->save();
      //
      // $permission3 = new Permission();
      // $permission3->name = 'delete-question';
      // $permission3->display_name = 'Изтрива въпроси';
      // $permission3->description  = 'Изтрива даден въпрос';
      // $permission3->save();

      // $admin->attachPermissions([15, 16, 17]);
    }
}
