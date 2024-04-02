<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mylist;

class MylistController extends Controller
{
    public function store(Request $request)
    {
        $mylist = new Mylist;
        $mylist->user_id = Auth::id();
        $mylist->item_id = $request->item_id;
        $mylist->save();
        return back();
    }

    public function destroy(Request $request)
    {
        $user_id = Auth::id();
        $mylist = Mylist::where('user_id', $user_id)->where('item_id', $request->item_id)->first();
        $mylist->delete();
        return back();
    }
}
