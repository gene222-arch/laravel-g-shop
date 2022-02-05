<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class RatingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'value' => ['required', 'numeric', 'min:1']
        ];
    }
}
