<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailSendRequest;
use App\Mail\SendAdminToUserMail;
use App\Mail\SendAdminToUsersMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailSendController extends Controller
{
    public function adminToUser(MailSendRequest $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);

        Mail::to($user)->send(new SendAdminToUserMail($request->subject, $request->content));
        return redirect('/admin-page/users')->with('message', $user->name . 'さんにメールを送信しました。');
    }

    public function adminToUsers(MailSendRequest $request)
    {
        $users = json_decode($request->users, true); // 配列に直す

        Mail::to($users)->send(new SendAdminToUsersMail($request->subject, $request->content));
        return redirect('/admin-page/users')->with('message', 'メールを一括送信しました。');
    }
}
