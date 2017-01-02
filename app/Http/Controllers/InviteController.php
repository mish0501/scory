<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\InviteMail;
use App\Invite;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $invites = Invite::all();
      return $invites;
    }

    public function create($id = null)
    {
      $invite = '';
      if ($id) {
        $invite = Invite::find($id);
      }

      $code = str_random(40);

      return ['code' => $code, 'invite' => $invite];
    }

    public function store(Request $request)
    {
      $validator = \Validator::make($request->all(), [
         'invite' => 'required',
         'email' => 'required|email'
      ]);

      if ($validator->fails()){
        return ['error' => $validator->errors()];
      }

       $input = $request->all();

       if($request->get('id')){
         $invite = Invite::find($request->get('id'));

         $invite->update($input);
       }else {
         Invite::create($input);
       }

       Mail::to($request->get('email'))->send(new InviteMail($request->get('invite')));

       return ['success' => 'Поканата беше успешно изпратена!'];
    }

    public function destroy($id)
    {
        $invite = Invite::findOrFail($id);

        $invite->delete();

        return ['success' => 'Поканата беше успешно изтрита!'];
    }

    public function redirect(Request $request)
    {
      $this->validate($request, [
        'invite' => 'required'
      ],[
        'invite.required' => 'Полето с поканата е задължително.'
      ]);

      $invite = $request->get('invite');

      return redirect(url('/auth/register/'.$invite));
    }

    public function newUser(Request $request)
    {
      $validator = \Validator::make($request->all(), [
        'inviteEmail' => 'required|unique:invite,email|email'
      ],[
        'inviteEmail.required' => 'Полето с E-mail Ви, е задължително',
        'inviteEmail.unique' => 'E-mail Ви е добавен към списъка за проверка, в скоро време ще получите поканата си.',
        'inviteEmail.email' => 'Полето с E-mail Ви, е в невалиден формат.',
      ]);

      if ($validator->fails()) {
        return [$validator->errors(), "success" => false];
      }

      $input['invite'] = "";
      $input['email'] = $request->get('inviteEmail');

      Invite::create($input);

      return ['invite_email' => 'След проверка на вашият E-mail, ще получите поканата си.', 'success' => true];
    }
}
