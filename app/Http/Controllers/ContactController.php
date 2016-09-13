<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MailStore;

use Vinkla\Pusher\Facades\Pusher;

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
      \Session::flash('error_mail_send', '');
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $message['name'] = $request->get('first_name').' '.$request->get('last_name');
    $message['email'] = $request->get('email');
    $message['subject'] = $request->get('subject');
    $message['message'] = $request->get('message');
    $message['read'] = false;
    $message['trash'] = false;

    MailStore::create($message);
    
    $pusher = \App::make('pusher');

    $pusher->trigger('MailChanel', 'NewMail', array('new_mail' => true));

    \Session::flash('mail_send', 'Съобщението изпратено успешно.');
    return redirect()->back();
  }

  public function index()
  {

    \Carbon\Carbon::setLocale('bg');

    $mail = MailStore::orderBy('created_at', 'desc')->where('trash', '=', false)->get();

    foreach ($mail as $key => $message) {
      $mail[$key]['time'] = $message->created_at->diffForHumans();
    }

    return view('admin.mail.index', ['mail' => $mail]);
  }

  public function show($id)
  {
    $message = MailStore::findOrFail($id);

    $message->read = true;
    $message->save();

    return view('admin.mail.show', ['message' => $message]);
  }

  public function destroy($id)
  {
    $message = MailStore::findOrFail($id);

    $message->trash = true;
    $message->save();

    \Session::flash('flash_message', 'Съобщението беше успешно преместено в кошчето!');

    return redirect()->route('admin.mail.index');
  }
}
