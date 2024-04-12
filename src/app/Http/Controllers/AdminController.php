<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Http\Requests\MailRequest;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin/admin');
    }

    public function commentIndex()
    {
        $comments = Comment::paginate(5);
        return view('admin/delete_comment', compact('comments'));

    }
    public function commentDestroy(Request $request)
    {
        Comment::find($request->comment_id)->delete();
        return back()->with('comment_message', 'コメントを削除しました');
    }

    public function userIndex()
    {
        $users = User::where('role', 'user')->paginate(5);
        return view('admin/delete_user', compact('users'));
    }

    public function userDestroy(Request $request)
    {
        User::find($request->user_id)->delete();
        return back()->with('user_message', 'ユーザーを削除しました');
    }

    public function mailListIndex(Request $request)
    {
        $users = User::where('role', 'user')->paginate(5);
        return view('admin/mail_list', compact('users'));
    }

}
