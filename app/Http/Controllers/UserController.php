<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
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
        $avatar = $user->avatar;
      }else{
        $avatar = 'avatar.jpg';
      }

      return view('admin.user.show', ['name' => $user->name, 'email' => $user->email, 'edit' => $editable, 'avatar' => $avatar]);
    }

    public function edit()
    {
      $user = Auth::user();

      if($user->avatar != NULL){
        $avatar = $user->avatar;
      }else{
        $avatar = 'avatar.jpg';
      }
      return view('admin.user.edit', ['name' => $user->name, 'email' => $user->email, 'avatar' => $avatar]);
    }

    public function update(Request $request)
    {
      $id = Auth::user()->id;
      $user = User::findOrFail($id);

      $this->validate($request, [
         'name' => 'min:5',
         'email' => 'min:5',
         'image' => 'mimes:jpg,jpeg,png|max:1000'
      ]);

      $input['name'] = $request->get('name');
      $input['email'] = $request->get('email');

      if($request->file('image') != NULL){
        $image_extension = $request->file('image')->getClientOriginalExtension();
        $image_name = $id;

        $input['avatar'] = $image_name.'.'.$image_extension;


        $destinationFolder = '/admin/assets/images/avatar/';
        $destinationThumbnail = '/admin/assets/images/avatar/thumbs/';

        if(isset($user->avatar)){
          $avatars = array(public_path().$destinationFolder.$user->avatar, public_path().$destinationThumbnail.$user->avatar);

          \File::delete($avatars);
        }

        $user->fill($input)->save();

        $file = \Input::file('image');

        $image = \Image::make($file->getRealPath());

        $image->save(public_path().$destinationFolder.$image_name.'.'.$image_extension)
         ->resize(60, 60)
         ->save(public_path().$destinationThumbnail.$image_name.'.'.$image_extension);
     }

     $user->update($input);

      \Session::flash('flash_message', 'Профилът ви беше успешно редактиран!');

      return redirect()->route('admin.user.edit');
    }

    public function change(Request $request)
    {
      $this->validate($request, [
          'old_password' => 'required|min:6',
          'password' => 'required|confirmed|min:6',
      ]);

      $credentials = $request->only(
          'password', 'password_confirmation', 'old_password'
      );

      $user = \Auth::user();

      if (\Hash::check($credentials['old_password'], $user->password)) {

        $user->password = bcrypt($credentials['password']);
        $user->save();

      }
      
      \Session::flash('flash_message', 'Паролата беше успешно сменена!');

      return redirect()->route('admin.user.edit');
    }
}
