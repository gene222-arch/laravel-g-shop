<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class WishlistRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id']
        ];
    }
}
