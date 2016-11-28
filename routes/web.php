<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function() {
    return view('welcome');
});

Route::get('/home', function() {
    return redirect(url("/admin/home"));
});

Route::group(['prefix' => 'test'],function() {
  Route::get('/', function() {
    return view('test');
  });

  Route::get('/select', function() {
    return view('test');
  });

  Route::get('/check', function() {
    return view('test');
  });
});

Route::post('/invite', ['as' => 'invite', 'uses' => 'InviteController@newUser']);

Route::post('/contact', ['as' => 'contact', 'uses' => 'ContactController@sendMail']);


// Test routes
Route::get('/endtest', ['as' => 'end', 'uses' => 'TestController@endTest']);


// TestRoom
Route::post('/join' , ['as' => 'testroom.join', 'uses' => 'TestRoomController@join']);
Route::get('/connect' , ['as' => 'testroom.connect', 'uses' => 'TestRoomController@connect']);
Route::get('/{code}/start' , ['as' => 'testroom.start', 'uses' => 'TestController@startTestRoomTest']);
Route::get('/finish' , ['as' => 'testroom.finish', function() {
    return view('testroom.finish');
}]);

// Authentication routes
Auth::routes();
Route::get('auth/register/{invite?}', 'Auth\RegisterController@showRegistrationForm');

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin|teacher']], function () {

  Route::get('/{vue_capture?}', function () {
      return view('admin');
  })->where('vue_capture', '[\/\w\.-]*');


  Route::get('/profile', function() {
      return view('admin.setings');
  });

  Route::resource('invite', 'InviteController', ['except' => ['show', 'update', 'edit'], 'names' => ['index' => 'admin.invite.index', 'store' => 'admin.invite.store', 'create' => 'admin.invite.create', 'destroy' => 'admin.invite.destroy', ]]);
  Route::get('/invite/create/{email?}', 'InviteController@sendInvite');

  // Trash
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

  // Testroom
  Route::resource('testroom', 'TestRoomController', ['except' => ['show', 'update', 'edit'], 'names' => [ 'index' => 'admin.testroom.index', 'store' => 'admin.testroom.store', 'create' => 'admin.testroom.create', 'destroy' => 'admin.testroom.destroy', ]]);
  Route::group(['prefix' => 'testroom'], function () {
    Route::get('/{code}/active' , ['as' => 'admin.testroom.start', 'uses' => 'TestRoomController@activate']);
    Route::get('/{code}/start' , ['as' => 'admin.testroom.start', 'uses' => 'TestRoomController@startTest']);
    Route::get('/{code}/end' , ['as' => 'admin.testroom.end', 'uses' => 'TestRoomController@endTest']);
    Route::get('/{code}/results' , ['as' => 'admin.testroom.results', 'uses' => 'TestRoomController@getResults']);
    Route::get('/{code}/student/{user}' , ['as' => 'admin.testroom.studentResults', 'uses' => 'TestRoomController@getStudentResults']);
  });

  // Settings
  Route::group(['prefix' => 'settings'], function () {
    // User Role
    Route::get('/users' , ['as' => 'admin.settings.users.index', 'uses' => 'SettingsController@users']);
    Route::get('/users/{id}/edit' , ['as' => 'admin.settings.users.edit', 'uses' => 'SettingsController@editUsers']);
    Route::post('/users/{id}/edit' , ['as' => 'admin.settings.users.update', 'uses' => 'SettingsController@updateUsers']);

    // Permission
    Route::get('/permissions' , ['as' => 'admin.settings.permissions.index', 'uses' => 'SettingsController@permissions']);
    Route::get('/permissions/create' , ['as' => 'admin.settings.permissions.create', 'uses' => 'SettingsController@createPermissions']);
    Route::post('/permissions/create' , ['as' => 'admin.settings.permissions.store', 'uses' => 'SettingsController@storePermissions']);
    Route::get('/permissions/{id}/edit' , ['as' => 'admin.settings.permissions.edit', 'uses' => 'SettingsController@editPermissions']);
    Route::post('/permissions/{id}/edit' , ['as' => 'admin.settings.permissions.update', 'uses' => 'SettingsController@updatePermissions']);

    // Roles
    Route::get('/roles' , ['as' => 'admin.settings.roles.index', 'uses' => 'SettingsController@roles']);
    Route::get('/roles/create' , ['as' => 'admin.settings.roles.create', 'uses' => 'SettingsController@createRoles']);
    Route::post('/roles/create' , ['as' => 'admin.settings.roles.store', 'uses' => 'SettingsController@storeRoles']);
    Route::get('/roles/{id}/edit' , ['as' => 'admin.settings.roles.edit', 'uses' => 'SettingsController@editRoles']);
    Route::post('/roles/{id}/edit' , ['as' => 'admin.settings.roles.update', 'uses' => 'SettingsController@updateRoles']);
  });

  Route::resource('subject', 'SubjectController', ['except' => ['show'], 'names' => [ 'index' => 'admin.subject.index', 'store' => 'admin.subject.store', 'create' => 'admin.subject.create', 'destroy' => 'admin.subject.destroy', 'update' => 'admin.subject.update', 'edit' => 'admin.subject.edit' ]]);
  Route::resource('partition', 'PartitionController', ['except' => ['show'], 'names' => [ 'index' => 'admin.partition.index', 'store' => 'admin.partition.store', 'create' => 'admin.partition.create', 'destroy' => 'admin.partition.destroy', 'update' => 'admin.partition.update', 'edit' => 'admin.partition.edit' ]]);
  Route::resource('question', 'QuestionController', ['except' => ['show'], 'names' => [ 'index' => 'admin.question.index', 'store' => 'admin.question.store', 'create' => 'admin.question.create', 'destroy' => 'admin.question.destroy', 'update' => 'admin.question.update', 'edit' => 'admin.question.edit' ]]);
  Route::resource('mail', 'ContactController', ['only' => ['index', 'destroy', 'show'], 'names' => [ 'index' => 'admin.mail.index', 'destroy' => 'admin.mail.destroy', 'show' => 'admin.mail.show' ]]);
  Route::get('user/edit', ['as' => 'admin.user.edit', 'uses' => 'UserController@edit']);
  Route::get('user/{user}', ['as' => 'admin.user.show', 'uses' => 'UserController@show']);
  Route::post('user/edit', ['as' => 'admin.user.update', 'uses' => 'UserController@update']);
  Route::post('user/changepass', ['as' => 'admin.user.change', 'uses' => 'UserController@change']);
});
