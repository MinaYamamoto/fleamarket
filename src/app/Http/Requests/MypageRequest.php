<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MypageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:60',
            'post_code' => 'required|integer|digits:7',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'mimes:jpg,jpeg,png|max:10240'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.string' => '名前は文字列で入力してください',
            'name.max' => '名前は60文字以内で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.integer' => '郵便番号は数値で入力してください',
            'post_code.digits' => '郵便番号は7桁で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'building.string' => '建物は文字列で入力してください',
            'building.max' => '建物は255文字以内で入力してください',
            'profile_image.mimes' => '画像ファイルを選択してください',
            'profile_image.max' => '10M以下の画像ファイルを選択してください',
        ];
    }
}
