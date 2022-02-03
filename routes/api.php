<?php

use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware("")->group(function () 
// {
    Route::prefix("auth")->group(function () 
    {
        Route::post("/login", [LoginController::class, "login"]);
        Route::post("/register", [RegisterController::class, "register"]);

        Route::prefix('forgot-password')->group(function () 
        {
            Route::post('/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
            Route::post('/reset', [ResetPasswordController::class, 'reset'])
                ->name('password.reset');
        });
    });
// });