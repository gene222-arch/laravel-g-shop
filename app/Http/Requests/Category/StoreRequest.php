<?php

namespace App\Http\Requests\Category;

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
            'name' => ['required', 'string', 'unique:categories'],
            'description' => ['nullable', 'string'],
            'hex_code' => ['required', 'string', 'min:7', 'max:8', 'unique:categories']
        ];
    }
}
