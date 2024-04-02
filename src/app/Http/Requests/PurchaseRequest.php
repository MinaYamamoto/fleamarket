<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'post_code' => 'required|integer|digits:7',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'post_code.required' => '郵便番号を入力してください',
            'post_code.integer' => '郵便番号は数値で入力してください',
            'post_code.digits' => '郵便番号は7桁で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
            'address.max' => '住所は255文字以内で入力してください',
            'building.string' => '建物は文字列で入力してください',
            'building.max' => '建物は255文字以内で入力してください',
        ];
    }
}
