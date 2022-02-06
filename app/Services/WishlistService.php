<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class WishlistService
{

    public function toggle(User $user, int $productID): bool|string
    {
        try {
            $result = DB::transaction(function () use ($user, $productID): bool
            {
                if (! $user->wishlists()->count()) {
                    $user->wishlists()->create([
                        'product_id' => $productID
                    ]);
                }

                $productExists = $this->checkProductExists($user, $productID);

                if (! $productExists) 
                {
                    $user
                        ->wishlists()
                        ->create([
                            'product_id' => $productID
                        ]);
                }
                else 
                {
                    $user
                        ->wishlists()
                        ->where('product_id', $productID)
                        ->delete();
                }

                return true;
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return $result;
    }

    public function checkProductExists(User $user, int $productID): bool
    {
        return $user->wishlists()->where('product_id', $productID)->exists();
    }
}