<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            // customer_idはcustomerテーブルに存在するものが条件になる
            'customer_id' => 'required|integer|exists:customers,id',
            // product_id1はproductsテーブルに存在するものが条件になる
            'product_id1' => 'required|integer|exists:products,id',
            // 商品個数は、必須で1以上20以下
            'num1' => 'required|integer|max:20|min:1',
            // product_id2 が入力されている場合にのみ num2 を必須にする
            'product_id2' => 'nullable|integer|exists:products,id',
            'num2' => 'nullable|required_with:product_id2|integer|max:20|min:1',
            // product_id3 が入力されている場合にのみ num3 を必須にする
            'product_id3' => 'nullable|integer|exists:products,id',
            'num3' => 'nullable|required_with:product_id3|integer|max:20|min:1',
        ];
    }

    // こちらはプロパティの名前を定義している
    public function attributes()
    {
        return [
            'customer_id' => '顧客',
            'product_id1' => '商品1',
            'product_id2' => '商品2',
            'product_id3' => '商品3',
            'num1' => '注文数',
            'num2' => '注文数',
            'num3' => '注文数',
        ];
    }
    // バリデーションが聞いた時に表示されるメッセージの設定
    public function messages()
    {
        return [
            'num1.required' => ':attributeを入力してください。',
            'num1.integer' => ':attributeは数値で入力してください。',
            'num1.min' => ':attributeは:min以上で入力してください。',
            'num1.max' => ':attributeは:max以下で入力してください。',
            'num2.required' => ':attributeを入力してください。',
            'num2.integer' => ':attributeは数値で入力してください。',
            'num2.min' => ':attributeは:min以上で入力してください。',
            'num2.max' => ':attributeは:max以下で入力してください。',
            'num3.required' => ':attributeを入力してください。',
            'num3.integer' => ':attributeは数値で入力してください。',
            'num3.min' => ':attributeは:min以上で入力してください。',
            'num3.max' => ':attributeは:max以下で入力してください。',
        ];
    }
}
