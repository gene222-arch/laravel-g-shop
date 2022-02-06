<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WishlistRequest;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\WishlistService;

class WishlistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->success("Wishlists fetched successfully.", Wishlist::with('user', 'product')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\WishlistRequest  $request
     * @param  \App\Models\User  $user
     * @param  App\Services\WishlistService  $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(WishlistRequest $request, User $user, WishlistService $service)
    {
        $result = $service->toggle($user, $request->product_id);

        return (gettype($result) === 'string')
            ? $this->error($result)
            : $this->success("Wishlist created successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function showViaUser(User $user)
    {
        return $this->success(
            "Wishlists fetched successfully.", 
            $user->wishlists
        );
    }
}
