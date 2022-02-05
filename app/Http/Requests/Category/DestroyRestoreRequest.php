<?php

namespace App\Http\Requests\Category;

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
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['required', 'integer', 'distinct', 'exists:categories,id']
        ];
    }
}
