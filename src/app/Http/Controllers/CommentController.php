<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Mylist;
use App\Models\Comment;
use App\Models\Profile;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function index(Request $request) {
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        $mylists = Mylist::where('item_id', $request->item_id)->get();
        $comments = Comment::where('item_id', $request->item_id)->get();
        $user_id = Auth::id();
        $profile = Profile::where('user_id', $user_id)->first();
        if(is_null($profile)){
            $profile = new Profile();
            if(app()->isLocal()) {
                $profile['profile_image'] = "/storage/kkrn_icon_user_1.svg";
            } else {
                $profile['profile_image'] = "/storage/kkrn_icon_user_1.svg";
            }
        }
        return view('comment',compact('item','mylists','comments','profile'));
    }

    public function store(CommentRequest $request) {
        $newComment = $request->only(['user_id', 'item_id', 'comment']);
        Comment::create($newComment);
        return back();
    }

}
