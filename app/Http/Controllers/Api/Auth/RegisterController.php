<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterControllerRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\ApiService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware("guest:api");
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \App\Http\Requests\Auth\RegisterControllerRequest  $request
     * @param  \App\Services\ApiService  $service
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(RegisterControllerRequest $request, ApiService $service)
    {
        $user = array_merge(
            $request->validated(),
            [
                "password" => Hash::make($request->password)
            ]
        );

        $user = User::create($user);
        $user->assignRole($request->role_id);

        if (! Auth::attempt($request->safe(["email", "password"]))) {
            return $this->error("Login failed");
        }

        return $service->token(
            $service->getPersonalAccessToken(),
            "Account registered successfully",
            auth()->user(),
            201
        );
    }
}
