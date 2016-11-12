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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

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

  Route::post('/test/check', 'TestController@checkTest');
});
