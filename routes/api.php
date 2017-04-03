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

    $perms = [];

    foreach($user->roles()->get() as $role){
      foreach($role->perms()->get() as $perm){
        array_push($perms, $perm->name);
      }
    }

    $user->permissions = $perms;

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

  Route::resource('subject', 'SubjectController', ['except' => ['show', 'create']]);
  Route::resource('partition', 'PartitionController', ['except' => ['show', 'create']]);
  Route::resource('question', 'QuestionController', ['except' => ['show', 'create']]);
  Route::resource('lesson', 'LessonController', ['except' => ['show', 'create']]);

  // Trash
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
      Route::delete('/testroom/{code}' , 'TrashController@deleteTestRoom');
      Route::delete('/mail/{id}' , 'TrashController@deleteMail');
    });
  });

  // Testroom
  Route::group(['prefix' => 'testroom'], function () {
    Route::get('/{userId}', 'TestRoomController@index');
    Route::post('/', 'TestRoomController@store');

    Route::post('/active' , 'TestRoomController@activate');
    Route::post('/start' , 'TestRoomController@startTest');
    Route::get('/{code}/end' , 'TestRoomController@endTest');
    Route::post('/results' , 'TestRoomController@getResults');
    Route::get('/{code}/student/{user}' , 'TestRoomController@getStudentResults');
    Route::get('/{code}/download' , 'TestRoomController@downloadStudentResults');
    Route::delete('/{code}' , 'TestRoomController@destroy');
  });

  // Mail
  Route::group(['prefix' => 'mail'], function () {
    Route::get('/', 'ContactController@index');
    Route::get('/{id}', 'ContactController@show');
    Route::delete('/{id}', 'ContactController@destroy');
  });

  // Settings
  Route::group(['prefix' => 'settings'], function () {
    // User Role
    Route::get('/users' , 'SettingsController@users');
    Route::get('/users/{id}/edit' , 'SettingsController@editUsers');
    Route::post('/users/{id}/edit' , 'SettingsController@updateUsers');

    // Permission
    Route::get('/permissions' , 'SettingsController@permissions');
    Route::post('/permissions/create' , 'SettingsController@storepermissions');
    Route::get('/permissions/{id}/edit' , 'SettingsController@editpermissions');
    Route::post('/permissions/{id}/edit' , 'SettingsController@updatepermissions');

    // Roles
    Route::get('/roles' , 'SettingsController@roles');
    Route::get('/roles/create' , 'SettingsController@createRoles');
    Route::post('/roles/create' , 'SettingsController@storeRoles');
    Route::get('/roles/{id}/edit' , 'SettingsController@editRoles');
    Route::post('/roles/{id}/edit' , 'SettingsController@updateRoles');
  });

  // Invites
  Route::get('/invite', 'InviteController@index');
  Route::get('/invite/create/{id?}', 'InviteController@create');
  Route::post('/invite', 'InviteController@store');
  Route::delete('/invite/{id}', 'InviteController@destroy');

  // Users
  Route::get('/user/edit', 'UserController@edit');
  Route::put('/user/edit', 'UserController@update');
  Route::post('user/changepass', 'UserController@changePass');
  Route::post('user/changeavatar', 'UserController@changeAvatar');
  Route::get('/user/{id}', 'UserController@show');
});

//Test routes
Route::post('/selectSubjects', 'TestController@selectSubject');
Route::post('/selectPartitions', 'TestController@selectPartition');
Route::post('/selectQuestions', 'TestController@selectQuestions');
Route::post('/test/check', 'TestController@checkTest');

// Testroom
Route::post('/join' , 'TestRoomController@join');
Route::post('/connect' , 'TestRoomController@connect');
Route::post('/testroom/getQuestions' , 'TestRoomController@getQuestions');
Route::post('/testroom/getTime' , 'TestRoomController@getTime');

// Lessons
Route::post('/selectLessons', 'LessonController@selectLessons');
Route::get('/lesson/{id}', 'LessonController@show');
