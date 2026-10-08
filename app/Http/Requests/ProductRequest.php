<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * 誰でもこのバリデーションを利用できるように true に変更します。
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * コントローラに書かれていたバリデーションルールをここに集約します。
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id'   => 'required|exists:companies,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'comment'      => 'nullable|string',
            'img_path'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MBまでの画像
        ];
    }
}