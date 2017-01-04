<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MailStore;
use App\Events\NewMail;
use App\Events\MessageOpened;

class ContactController extends Controller
{
  public function sendMail(Request $request)
  {
    $validator = \Validator::make($request->all(), [
       'first_name' => 'required|min:5',
       'last_name' => 'required|min:5',
       'email' => 'required|email',
       'subject' => 'required',
       'message' => 'required|min:5'
    ],[
      'subject.required' => 'Полето Относно е задължително'
    ]);

    if ($validator->fails()) {
      return [$validator->errors()->toJSON(), 'success' => false];
    }

    $message['name'] = $request->get('first_name').' '.$request->get('last_name');
    $message['email'] = $request->get('email');
    $message['subject'] = $request->get('subject');
    $message['message'] = $request->get('message');
    $message['read'] = false;
    $message['trash'] = false;

    MailStore::create($message);

    event(new NewMail(true));

    return ["mailSend" => 'Съобщението изпратено успешно.', 'success' => true];
  }

  public function index()
  {

    \Carbon\Carbon::setLocale('bg');

    $mail = MailStore::orderBy('created_at', 'desc')->where('trash', '=', false)->get();

    foreach ($mail as $key => $message) {
      $mail[$key]['time'] = $message->created_at->diffForHumans();
      $mail[$key]['message'] = str_limit($message->message, 55);
    }

    return $mail;
  }

  public function show($id)
  {
    $message = MailStore::findOrFail($id);

    if($message->read) {
      return $message;
    }

    $message->read = true;
    $message->save();

    event(new MessageOpened());

    return $message;
  }

  public function destroy($id)
  {
    $message = MailStore::findOrFail($id);

    $message->trash = true;
    $message->save();

    return ['success' => 'Съобщението беше успешно преместено в кошчето!'];
  }
}
