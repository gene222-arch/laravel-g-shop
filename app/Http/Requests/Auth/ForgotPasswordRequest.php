<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class ForgotPasswordRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:users']
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'The given email does not exist.'
        ];
    }
}
