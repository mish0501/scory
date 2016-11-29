<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TestRoom;
use App\TestRoomStudents;
use App\Subject;
use App\Partition;
use App\Question;
use App\Answer;
use Session;
use File;

use App\Events\StudentConnected;

class TestRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
      $testrooms = TestRoom::where('teacher_id', '=', $user_id)->where('trash', '=', false)->with('subject', 'partition')->get();
      return $testrooms;
    }

    public function create()
    {
      $code = $this->generateCode();
      return view('admin.testroom.create', ['code' => $code]);
    }

    public function generateCode()
    {

        $digits = 5;
        $code = rand(pow(10, $digits-1), pow(10, $digits)-1);

        $room = TestRoom::where('code', '=', $code)->count();

        if($room !== 0){
          $this->generateCode();
        }else{
          return $code;
        }
    }

    public function store(Request $request)
    {
      $validator = \Validator::make($request->all(), [
         'code' => 'required|digits:5|unique:testroom',
         'class' => 'required',
         'subject_id' => 'required',
         'partition_id' => 'required',
         'questions' => 'required',
         'teacher_id' => 'required'
      ], [
        'questions.required' => 'Трабва да изберете въпроси.'
      ]);

      if ($validator->fails()) {
        return ['error' => $validator->errors()];
      }

      $questions = '';

      foreach ($request->get('questions') as $key => $value) {
        $questions .= $value['id']. ', ';
      }

      $questions = rtrim($questions, ", ");

      $input = $request->all();
      $input['questions_id'] = $questions;

      TestRoom::create($input);

      return response()->json(['success' => 'Стаята беше успешно създадена!']);
    }

    public function activate(Request $request)
    {
      $code = $request->get('code');

      $testroom = TestRoom::where('code', '=', $code)->update(['status' => true]);

      $students = TestRoomStudents::where('code', '=', $code)->get();

      return ['students' => $students];
    }

    public function join(Request $request)
    {
      $validator = \Validator::make($request->all(), [
         'roomcode' => 'required|digits:5|exists:testroom,code',
      ],[
        'roomcode.required' => 'Полето с кода на стаята е задължително.',
        'roomcode.exists' => 'Стая с такъв код не съществува.',
        'roomcode.digits' => 'Полето c кода трябва да има 5 цифри.'
      ]);

      if ($validator->fails()) {
        return [$validator->errors(), 'room_code_error' => 'Възникна грешка с кода на стаята:'];
      }

      $code = $request->get('roomcode');

      $testroom = TestRoom::where('code', '=', $code)->where('status', '=', 1)->orWhere('status', '=', 2)->count();

      if($testroom == 1){
        $url = url('testroom/'.$code.'/join');
        return ['redirect' => true, 'url' => $url];
      }
    }

    public function connect(Request $request)
    {
      $this->validate($request, [
         'code' => 'required|digits:5|exists:testroom,code',
         'name' => 'required',
         'lastname' => 'required'
      ]);

      $code = $request->get('code');
      $name = $request->get('name');
      $lastname = $request->get('lastname');

      $students = TestRoomStudents::where('code', '=', $code);

      $testroom = TestRoom::where('code', '=', $code)->get()[0];

      if ($students->count() >= 1) {
        if($students->where('name', '=', $name)->where('lastname', '=', $lastname)->count() != 0){
          if($testroom->status == 2){
            return response()->json([
              'testStarted' => true
            ]);
          }elseif($testroom->status == 1){
            return response()->json([
              'testStarted' => false
            ]);
          }
        }else{
          $number = TestRoomStudents::where('code', '=', $code)->orderBy('id', 'desc')->first()->number + 1;
        }
      }else{
        $number = 1;
      }

      $newStudent = new TestRoomStudents;
      $newStudent->name = $name;
      $newStudent->lastname = $lastname;
      $newStudent->code = $code;
      $newStudent->number = $number;

      $newStudent->save();

      $data = array('code' => $code, 'name' => $name, 'lastname' => $lastname, 'number' => $number);
      event(new StudentConnected($data));

      if($testroom->status == 2){
        return response()->json([
          'testStarted' => true
        ]);
      }elseif($testroom->status == 1){
        return response()->json([
          'testStarted' => false
        ]);
      }
    }

    public function startTest($code)
    {
      $testroom = TestRoom::where('code', '=', $code)->update(['status' => 2]);

      $pusher = App::make('pusher');
      $pusher->trigger( 'TestRoomChanel', 'TestStart', array('code' => $code));

      $students = TestRoomStudents::where('code', '=', $code)->where('correct', '>', '0')->get();

      return view('admin.testroom.start', ['code' => $code, 'students' => $students]);
    }

    public function finishTest($correctAnswers, $userAnswers, $code, $name, $lastname)
    {
      $student = TestRoomStudents::where('code', '=', $code)
                                  ->where('name', '=', $name)
                                  ->where('lastname', '=', $lastname);

      $update = $student->update(['correct' => $correctAnswers, 'checked_answers' => $userAnswers]);

      $number = $student->get()[0]->number;

      Session::forget('questions');
      Session::forget('answers');
      Session::forget('checked');
      Session::forget('name');
      Session::forget('lastname');

      $pusher = App::make('pusher');
      $pusher->trigger( 'TestRoomChanel', 'FinishTest', array('name' => $name, 'lastname' => $lastname, 'code' => $code, 'number' => $number, 'correct' => $correctAnswers));

      return redirect()->route('testroom.finish');
    }

    public function endTest($code)
    {
      $testroom = TestRoom::where('code', '=', $code)->where('status', '=', 2)->update(['status' => 3]);

      return redirect()->route('admin.testroom.index');
    }

    public function getResults($code)
    {
      $students = TestRoomStudents::where('code', '=', $code)->get();
      return view('admin.testroom.results', ['students' => $students, 'code' => $code]);
    }

    public function getStudentResults($code, $user)
    {
      $student = TestRoomStudents::where('code', '=', $code)->where('number', '=' , $user)->get()[0];
      $questions = '';

      if(isset($student->checked_answers)){
        $userAnswers = json_decode($student->checked_answers);

        $index = 0;

        foreach ($userAnswers as $key => $value) {
          $questions[$index] = Question::where('id', '=', $key)->with('answers')->get()[0];

          foreach ($questions[$index]->answers as $k => $v) {
            if(is_array($value)){
              foreach ($value as $val) {
                if($v->id == $val){
                  $v->checked = true;
                }
              }
            }
            if($v->id == $value){
              $v->checked = true;
            }
          }

          $index ++;
        }
      }

      return view('admin.testroom.user', ['student' => $student, 'questions' => $questions]);
    }

    public function destroy($code)
    {
      $testroom = TestRoom::where('code', '=', $code)->update(['trash' =>true]);

      $testroom_students = TestRoomStudents::where('code', '=', $code)->update(['trash' => true]);

      Session::flash('flash_message', 'Стаята беше изтрита!');

      return redirect()->route('admin.testroom.index');
    }
}
