<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * ユーザーのログイン後のリダイレクト先を取得します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $role = \Auth::user()->role;
        if ($request->wantsJson()) {
            return response()->json(['two_factor' => false]);
        }
        switch ($role) {
            case 'admin':
                return redirect('/admin/user');
            case 'user':
                return redirect('/mypage');
            default:
                return redirect('/login');
        }    }

    /**
     * ログイン後のユーザーのJSONレスポンスを取得します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toJson($request)
    {
        return new JsonResponse(['status' => 'success', 'message' => 'Login successful'], 200);
    }
}
