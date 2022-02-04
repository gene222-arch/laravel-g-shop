<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image_url' => ['required', 'string'],
            'title' => ['required', 'string', 'max:80', 'unique:products'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:1'],
            'in_stock' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
