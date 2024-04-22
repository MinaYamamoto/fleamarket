<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\MypageRequest;

class MypageController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $items = Item::where('user_id', $user_id)->get();
        $purchases = Purchase::where('user_id', $user_id)->get();
        $profile = Profile::where('user_id', $user_id)->first();
        if(is_null($profile)){
            $post_code='';
            $profile = new Profile();
            if(config('app.env') === 'local') {
                $profile['profile_image'] = "/storage/profile.svg";
            } else {
                $profile['profile_image'] = "https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/profile.svg";
            }
        }
        return view('mypage',compact('items', 'purchases', 'profile'));
    }

    public function profileIndex()
    {
        $user_id = Auth::id();
        $profile = Profile::where('user_id', $user_id)->first();
        return view('profile', compact('profile'));
    }

    public function profileStore()
    {
        $user_id = Auth::id();
        $profile_check = Profile::where('user_id', $user_id)->first();
        if(is_null($profile_check)){
            $new_profile['user_id'] = $user_id;
            $new_profile['post_code'] = '';
            $new_profile['address'] = '住所未登録';
            if(config('app.env') === 'local') {
                $new_profile['profile_image'] = "/storage/profile.svg";
            } else {
                $new_profile['profile_image'] = "https://fleamarket-bucket.s3.ap-northeast-1.amazonaws.com/profile.svg";
            }
            Profile::create($new_profile);
        }
        $profile = Profile::where('user_id', $user_id)->first();
        return view('profile', compact('profile'));
    }

    public function profileUpdate(MypageRequest $request)
    {
        $user = $request->only(['name']);
        $profile = $request->only(['post_code', 'address', 'building']);
        if(request('profile_image')) {
            $file = $request->file('profile_image');
            $file_name = $file->getClientOriginalName();
            if(config('app.env') === 'local') {
                $path = Storage::putFileAs('public', $file, $file_name);
                $profile['profile_image'] = Storage::url($path);
            } else {
                $path = Storage::disk('s3')->putFileAs('/', $file, $file_name, 'public');
                $profile['profile_image'] = Storage::disk('s3')->url($path);
            }
        }
        User::find($request->user_id)->update($user);
        Profile::find($request->profile_id)->update($profile);
        return redirect('/mypage');
    }
}
