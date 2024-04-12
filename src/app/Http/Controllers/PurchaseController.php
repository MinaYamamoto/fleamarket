<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Http\RedirectResponse;
use App\Models\Item;
use App\Models\Profile;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;


class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $payment_method = 'card';
        if(Session::has('payment_method')) {
            $payment_method = Session::get('payment_method');
        }
        $item_id = $request->item_id;
        Session::put('item_id', $item_id);
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
        return view('purchase', compact('item', 'post_code', 'profile', 'item_id', 'payment_method'));
    }

    public function checkout(Request $request) {
        $payment_method = 'card';
        if(Session::has('payment_method')) {
            $payment_method = Session::get('payment_method');
        }
        $item_id = Session::get('item_id');
        $item = Item::find($item_id);

        \Stripe\Stripe::setApiKey(config('services.stripe.stripe_secret_key'));
        $product = \Stripe\Product::create([
            'name' => $item->name,
            'description' => $item->explanation,
        ]);
        $price = \Stripe\Price::create([
            'currency' => 'jpy',
            'unit_amount' => $item->price,
            'product' => $product->id,
        ]);
        if($payment_method === 'card' || $payment_method === 'konbini') {
            $session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    'price' => $price->id,
                    'quantity' => 1
                ]],
                'payment_method_types' => [$payment_method],
                'mode' => 'payment',
                'success_url' => route('success', ['item_id' => $item_id]),
                'cancel_url' => route('purchase', ['item_id' => $item_id]),
            ]);
        } elseif($payment_method === 'bank') {
            $customer = \Stripe\Customer::create();
            $session = \Stripe\Checkout\Session::create([
                'customer' => $customer,
                'line_items' => [[
                    'price' => $price->id,
                    'quantity' => 1
                ]],
                'payment_method_types' => ['customer_balance'],
                'payment_method_options' =>[
                    'customer_balance' => [
                        'funding_type' => 'bank_transfer',
                        'bank_transfer' =>[
                            'type' => 'jp_bank_transfer'
                        ],
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('success', ['item_id' => $item_id]),
                'cancel_url' => route('purchase', ['item_id' => $item_id]),
            ]);
        }
        return view('checkout', compact('session', 'item_id'));
    }

    public function store() {
        $user_id = Auth::id();
        $item_id = Session::get('item_id');
        $purchase['user_id'] = $user_id;
        $purchase['item_id'] = $item_id;
        Purchase::create($purchase);
        return redirect(route('index'));
    }

    public function paymentIndex(Request $request)
    {
        $item_id = Session::get('item_id');
        Session::put('purchase_url', url()->previous());
        return view('payment', compact('item_id'));
    }

    public function paymentChange(Request $request)
    {
        $payment_method = Session::put('payment_method', $request->payment_method);
        $purchaseUrl = Session::get('purchase_url');
        return new RedirectResponse($purchaseUrl);
    }

    public function success()
    {
        $item_id = Session::get('item_id');
        return view('success', compact('item_id'));
    }

    public function addressStore(Request $request)
    {
        $user_id = Auth::id();
        $profile_check = Profile::where('user_id', $user_id)->first();
        if(is_null($profile_check)){
            $new_profile['post_code'] = '';
            $new_profile['address'] = '住所未登録';
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

    public function addressIndex()
    {
        $user_id = Auth::id();
        $profile = Profile::where('user_id', $user_id)->first();
        return view('address',compact('profile'));
    }

    public function addressUpdate(PurchaseRequest $request)
    {
        $new_profile = $request->only(['post_code', 'address', 'building']);
        Profile::find($request->id)->update($new_profile);
        $purchaseUrl = Session::get('purchase_url');
        return new RedirectResponse($purchaseUrl);
    }

}
