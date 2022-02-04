<?php

namespace App\Http\Requests\Upload;

use App\Http\Requests\BaseRequest;

class ImageUploadRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2000'], // 2MB,
            'directory' => ['required', 'string']
        ];
    }
}
