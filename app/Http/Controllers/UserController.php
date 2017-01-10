<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\FileManager;
use Auth;

class UserController extends Controller
{
    public function show($id)
    {
      $user = User::findOrFail($id);
      $editable = false;
      if(Auth::user()->id == $id){
        $editable = true;
      }

      if($user->avatar != NULL){
        $avatarId = $user->avatar;

        $avatar = $user->files()->find($avatarId)->url;
      }else{
        $avatar = 'admin/assets/images/avatar/avatar.jpg';
      }

      $questionCount = $user->questions->count();

      return ['name' => $user->name, 'email' => $user->email, 'edit' => $editable, 'avatar' => $avatar, 'questions' => $questionCount];
    }

    public function edit()
    {
      $user = Auth::user();

      if($user->avatar != NULL){
        $avatarId = $user->avatar;

        $avatar = $user->files()->find($avatarId)->url;
      }else{
        $avatar = 'admin/assets/images/avatar/avatar.jpg';
      }
      return ['name' => $user->name, 'email' => $user->email, 'avatar' => $avatar];
    }

    public function update(Request $request)
    {
      $user = Auth::user();

      $validator = \Validator::make($request->all(), [
         'name' => 'min:5',
         'email' => 'min:5'
      ]);

      if ($validator->fails()) {
        return ['error' => $validator->errors()];
      }


      $input['name'] = $request->get('name');
      $input['email'] = $request->get('email');

      $user->update($input);

      return ['success' => 'Профилът ви беше успешно редактиран!'];
    }

    public function changePass(Request $request)
    {
      $validator = \Validator::make($request->all(), [
          'old_password' => 'required|min:6',
          'password' => 'required|confirmed|min:6',
      ]);

      if ($validator->fails()) {
        return ['error' => $validator->errors()];
      }


      $credentials = $request->only(
          'password', 'password_confirmation', 'old_password'
      );

      $user = Auth::user();

      if (\Hash::check($credentials['old_password'], $user->password)) {

        $user->password = bcrypt($credentials['password']);
        $user->save();

      }

      return ['success' => 'Паролата беше успешно сменена!'];
    }

    public function changeAvatar(Request $request)
    {
      $user = Auth::user();

      $user->update(['avatar' => $request->get('id')]);

      return $user->files()->find($request->get('id'))->url;
    }
}
