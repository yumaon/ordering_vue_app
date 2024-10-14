<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|max:20|min:3',
            'code' => 'required|string|max:4|min:4|',
            'price' => 'required|integer|max:10000|min:100|',
            'tax' => 'required|integer',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '名前',
            'code' => 'コード',
            'price' => '価格',
            'tax' => '税率',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attributeを入力してください。',
            'name.min' => ':attributeは:min文字以上で入力してください。',
            'name.max' => ':attributeは:max文字以内で入力してください。',
            'code.required' => ':attributeを入力してください。',
            'code.min' => ':attributeは:min文字以上で入力してください。',
            'code.max' => ':attributeは:max文字以内で入力してください。',
            'price.required' => ':attributeを入力してください。',
            'price.min' => ':attributeは:min円以上で入力してください。',
            'price.max' => ':attributeは:max円以下で入力してください。',
            'price.integer' => ':attributeは:数値で入力してください。',
            'tax.required' => ':attributeを入力してください。',
        ];
    }
}
