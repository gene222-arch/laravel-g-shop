<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
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
            'image_url' => ['nullable', 'string'],
            'title' => ['nullable', 'string', 'max:80', 'unique:products,title,' . $this->product_id],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['nullable', 'numeric', 'min:1'],
            'in_stock' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
