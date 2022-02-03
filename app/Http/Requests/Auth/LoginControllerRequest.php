<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class LoginControllerRequest extends BaseRequest
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
            "email" => ["required", "email", "exists:users"],
            "password" => ["required", "string"]
        ];
    }

    public function messages()
    {
        return [
            "email.exists" => "An account with this email does not exist."
        ];
    }
}
