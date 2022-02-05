<?php

namespace App\Http\Requests\Category;

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
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['nullable', 'string', "unique:categories,name,{$this->category_id}"],
            'description' => ['nullable', 'string'],
            'hex_code' => ['nullable', 'string', 'min:7', 'max:8', "unique:categories,hex_code{$this->category_id}"]
        ];
    }
}
