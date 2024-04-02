<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'category_content_id' => 'required',
            'condition_id' => 'required',
            'name' => 'required|string|max:255',
            'explanation' => 'required|string|max:255',
            'price' => 'required|integer',
            'image' => 'required|mimes:jpg,jpeg,png|max:10240'
        ];
    }

    public function messages()
    {
        return [
            'category_content_id.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'name.required' => '商品名を入力してください',
            'name.string' => '商品名は文字列で入力してください',
            'name.max' => '商品名は255文字以内で入力してください',
            'explanation.required' => '商品の説明を入力してください',
            'explanation.string' => '商品の説明は文字列で入力してください',
            'explanation.max' => '商品の説明は255文字以内で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は数字で入力してください',
            'image.required' => '商品画像を選択してください',
            'image.mimes' => '画像ファイルを選択してください',
            'image.max' => '10M以下の画像ファイルを選択してください'
        ];
    }
}
