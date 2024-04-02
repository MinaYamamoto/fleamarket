<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Http\RedirectResponse;
use App\Models\Item;
use App\Models\Profile;
use App\Http\Requests\PurchaseRequest;


class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $profile = Profile::where('user_id', $user_id)->first();
        if(is_null($profile)){
            $post_code='';
            $profile = new Profile();
            $profile->address = '住所未登録';
        } else {
            $post_code = $profile->post_code;
            $post_code_3 = substr($post_code, 0,3);
            $post_code_4 = substr($post_code, 3);
            $post_code = $post_code_3. "-" . $post_code_4;
        }
        $item = Item::find($request->item_id);
        return view('purchase', compact('item', 'post_code', 'profile'));
    }

    public function store() {
        return view('purchase');
    }

    public function addressstore(Request $request)
    {
        $user_id = Auth::id();
        $profile_check = Profile::where('user_id', $user_id)->first();
        if(is_null($profile_check)){
            $new_profile['post_code'] = '';
            $new_profile['address'] = '未登録';
            $new_profile['user_id'] = Auth::id();
            if(app()->isLocal()) {
                $new_profile['profile_image'] = "/storage/kkrn_icon_user_1.png";
            } else {
                $new_profile['profile_image'] = "/storage/kkrn_icon_user_1.png";
            }
            Profile::create($new_profile);
        }
        $profile = Profile::where('user_id', $user_id)->first();
        Session::put('purchase_url', url()->previous());
        return view('address',compact('profile'));
    }

    public function addressindex()
    {
        $user_id = Auth::id();
        $profile = Profile::where('user_id', $user_id)->first();
        return view('address',compact('profile'));
    }

    public function addressupdate(PurchaseRequest $request)
    {
        $new_profile = $request->only(['post_code', 'address', 'building']);
        Profile::find($request->id)->update($new_profile);
        $purchaseUrl = Session::get('purchase_url');
        return new RedirectResponse($purchaseUrl);
    }

}
