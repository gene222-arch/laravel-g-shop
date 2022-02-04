<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class DestroyRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_ids' => ['required', 'array', 'distinct'],
            'product_ids.*' => ['required', 'integer', 'exists:products,id']
        ];
    }
}
