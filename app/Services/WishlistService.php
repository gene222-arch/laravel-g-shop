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

                $userQuery = User::query();
                $productExists = $this->checkProductExists($user, $productID);

                $userQuery
                    ->when($productExists, 
                        function ($query) use ($productID) {
                            $query->wishlists()
                                ->where('product_id', $productID)
                                ->delete();
                        }
                    );

                $userQuery
                    ->when(! $productExists, function ($query) use ($productID) {
                        $query
                            ->wishlists()
                            ->create([
                                'product_id' => $productID
                            ]);
                    });

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