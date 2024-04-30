<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;
use App\Http\Requests\MailRequest;

class MailController extends Controller
{
    public function form(Request $request)
    {
        $user_name = $request->user_name;
        $user_email = $request->user_email;
        return view('admin/mail', compact('user_name', 'user_email'));
    }

    public function execute(MailRequest $request)
    {
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $txt = $request->txt;
        Mail::to($email)->send(new SendMail($name, $subject, $txt ?? ''));
        return view('admin/result')->with('mail_message', 'メールを送信しました');
    }
}
