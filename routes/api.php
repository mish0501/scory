<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    $user = $request->user();

    if($user->hasRole('admin')){
      $user->role='admin';
    }elseif ($user->hasRole('teacher')) {
      $user->role='teacher';
    }

    return $user;
})->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function () {
  Route::post('/getSubjects', ['as' => 'getSubjects', 'uses' => 'APIController@Subjects']);
  Route::post('/getPartitions', ['as' => 'getPartitions', 'uses' => 'APIController@Partitions']);
  Route::post('/getStudents', ['as' => 'getStudents', 'uses' => 'APIController@getStudents']);
  Route::post('/getStudentsPoints', ['as' => 'getStudentsPoints', 'uses' => 'APIController@getStudentsPoints']);
  Route::post('/checkTestStart', ['as' => 'checkTestStart', 'uses' => 'APIController@checkTestStart']);
  Route::post('/codeGenerate', ['as' => 'codeGenerate', 'uses' => 'APIController@CodeGenerate']);
  Route::post('/questionGenerate', ['as' => 'questionGenerate', 'uses' => 'APIController@QuestionGenerate']);
  Route::post('/getAllMessages', ['as' => 'getAllMessages', 'uses' => 'APIController@getAllMessages']);
  Route::post('/getMessage', ['as' => 'getMessage', 'uses' => 'APIController@getMessage']);
  Route::post('/getDashboardInfo', ['as' => 'getDashboardInfo', 'uses' => 'APIController@getDashboardInfo']);

  // Route::post('/subjects', ['as' => 'getAllSubjects', 'uses' => 'APIController@allSubjects']);
  // Route::post('/subject', ['as' => 'getSubject', 'uses' => 'APIController@Subject']);
  Route::resource('subject', 'SubjectController', ['except' => ['show', 'create']]);
  Route::resource('partition', 'PartitionController', ['except' => ['show', 'create']]);
  Route::resource('question', 'QuestionController', ['except' => ['show', 'create']]);

  Route::group(['prefix' => 'trash'], function () {
    Route::get('/', 'TrashController@index');

    Route::group(['prefix' => 'renew'], function () {
      Route::post('/subject' , 'TrashController@renewSubject');
      Route::post('/partition' , 'TrashController@renewPartition');
      Route::post('/question' , 'TrashController@renewQuestion');
      Route::post('/testroom' , 'TrashController@renewTestRoom');
      Route::post('/mail' , 'TrashController@renewMail');
    });

    Route::group(['prefix' => 'delete'], function () {
      Route::delete('/subject/{subject}' , 'TrashController@deleteSubject');
      Route::delete('/partition/{partition}' , 'TrashController@deletePartition');
      Route::delete('/question/{question}' , 'TrashController@deleteQuestion');
      Route::delete('/testroom/{question}' , 'TrashController@deleteTestRoom');
      Route::delete('/mail/{question}' , 'TrashController@deleteMail');
    });
  });

  // Testroom
  Route::group(['prefix' => 'testroom'], function () {
    Route::get('/{userId}', 'TestRoomController@index');
    Route::post('/', 'TestRoomController@store');

    Route::post('/active' , 'TestRoomController@activate');
    Route::get('/{code}/start' , 'TestRoomController@startTest');
    Route::get('/{code}/end' , 'TestRoomController@endTest');
    Route::get('/{code}/results' , 'TestRoomController@getResults');
    Route::get('/{code}/student/{user}' , 'TestRoomController@getStudentResults');


  });
});

//Test routes
Route::post('/selectSubjects', 'TestController@selectSubject');
Route::post('/selectPartitions', 'TestController@selectPartition');
Route::post('/selectQuestions', 'TestController@selectQuestions');
Route::post('/test/check', 'TestController@checkTest');

// Testroom
Route::post('/join' , ['as' => 'testroom.join', 'uses' => 'TestRoomController@join']);
Route::post('/connect' , ['as' => 'testroom.connect', 'uses' => 'TestRoomController@connect']);
