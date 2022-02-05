<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class DestroyRestoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_ids' => ['required', 'array'],
            'product_ids.*' => ['required', 'integer', 'distinct', 'exists:products,id']
        ];
    }
}
