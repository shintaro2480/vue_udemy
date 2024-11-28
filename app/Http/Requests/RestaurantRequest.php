<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string|max:30|min:1',
            'address' => 'required|string|max:30|min:1',
            'go' => 'boolean', // 真偽値
            'user_id' => 'integer', // 整数
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 画像のバリデーション

        ];
    }
    public function attributes()
    {
        return [
            'name' => '名前',
            'address' => '住所',
            'go' => '行ったかどうか',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => ':attributeを入力してください。',
            'name.min' => ':attributeは:min文字以上で入力してください。',
            'name.max' => ':attributeは:max文字以内で入力してください。',
            'address.required' => ':attributeを入力してください。',
            'address.min' => ':attributeは:min文字以上で入力してください。',
            'address.max' => ':attributeは:max文字以内で入力してください。',
            'go.required' => ':attributeを入力してください。',
        ];
    }
}
