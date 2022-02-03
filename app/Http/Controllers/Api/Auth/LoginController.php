<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginControllerRequest;
use App\Providers\RouteServiceProvider;
use App\Services\ApiService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("guest:api")->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \App\Http\Requests\Auth\LoginControllerRequest  $request
     * @param \App\Services\ApiService  $service
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginControllerRequest $request, ApiService $service)
    {
        if (! Auth::attempt($request->validated())) 
        {
            return $this->error(
                "Login failed, your password is incorrect"
            );
        }

        return $service->token(
            $service->getPersonalAccessToken(),
            "User logged in successfully."
        );
    }

    public function logout(Request $request)
    {
        $request    
            ->user("api")
            ->token()
            ->revoke();

        return $this->success("User logged out successfully.");
    }
}
