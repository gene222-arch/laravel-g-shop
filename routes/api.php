<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RatingsController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\WishlistsController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\FileUploadsController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\VerificationController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;

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

        Route::controller(VerificationController::class)->group(function () 
        {
            Route::name('verification.')->group(function () 
            {
                Route::get('/verify-email/{id}/{hash}', 'verify')->name('verify');
                Route::get('/resend', 'resend')->name('resend');
            });
        });
    });

    Route::controller(CategoriesController::class)->group(function () 
    {
        Route::prefix('categories')->group(function () 
        {
            Route::get('/', 'index');
            Route::get('/{category}', 'show');
            Route::post('/', 'store');
            Route::put('/restore', 'restore');
            Route::put('/{category}', 'update');
            Route::delete('/', 'destroy');
        });
    });

    Route::controller(ProductsController::class)->group(function () 
    {
        Route::prefix('products')->group(function () 
        {
            Route::get('/', 'index');
            Route::get('/{product}', 'show');
            Route::post('/', 'store');
            Route::put('/restore', 'restore');
            Route::put('/{product}', 'update');
            Route::delete('/', 'destroy');
        });
    });

    Route::controller(RatingsController::class)->group(function () 
    {
        Route::prefix('ratings')->group(function () 
        {
            Route::post('/', 'store');
            Route::put('/{rating}', 'update');
        });
    });

    Route::controller(FileUploadsController::class)->group(function () 
    {
        Route::prefix('file-upload')->group(function () 
        {
            Route::post('/image', 'image');
            Route::post('/video', 'video');
        });
    });

    Route::controller(WishlistsController::class)->group(function () 
    {
        Route::prefix('wishlists')->group(function () 
        {
            Route::get('/', 'index');
            Route::get('/{user}', 'showViaUser');
            Route::post('/{user}', 'toggle');
        }); 
    });
// });