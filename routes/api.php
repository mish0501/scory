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
    Route::get('/', ['as' => 'admin.trash', 'uses' => 'TrashController@index']);

    Route::group(['prefix' => 'renew'], function () {
      Route::post('/subject' , ['as' => 'trash.renew.subject', 'uses' => 'TrashController@renewSubject']);
      Route::post('/partition' , ['as' => 'trash.renew.partition', 'uses' => 'TrashController@renewPartition']);
      Route::post('/question' , ['as' => 'trash.renew.question', 'uses' => 'TrashController@renewQuestion']);
      Route::post('/testroom' , ['as' => 'trash.renew.testroom', 'uses' => 'TrashController@renewTestRoom']);
      Route::post('/mail' , ['as' => 'trash.renew.mail', 'uses' => 'TrashController@renewMail']);
    });

    Route::group(['prefix' => 'delete'], function () {
      Route::delete('/subject/{subject}' , ['as' => 'trash.delete.subject', 'uses' => 'TrashController@deleteSubject']);
      Route::delete('/partition/{partition}' , ['as' => 'trash.delete.partition', 'uses' => 'TrashController@deletePartition']);
      Route::delete('/question/{question}' , ['as' => 'trash.delete.question', 'uses' => 'TrashController@deleteQuestion']);
      Route::delete('/testroom/{question}' , ['as' => 'trash.delete.testroom', 'uses' => 'TrashController@deleteTestRoom']);
      Route::delete('/mail/{question}' , ['as' => 'trash.delete.mail', 'uses' => 'TrashController@deleteMail']);
    });
  });
});

//Test routes
Route::post('/selectSubjects', ['as' => 'subject', 'uses' => 'TestController@selectSubject']);
Route::post('/selectPartitions', ['as' => 'partition', 'uses' => 'TestController@selectPartition']);
Route::post('/selectQuestions', ['as' => 'selectQuestion', 'uses' => 'TestController@selectQuestions']);
Route::post('/test/check', 'TestController@checkTest');
