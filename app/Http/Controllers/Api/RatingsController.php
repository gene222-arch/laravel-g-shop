<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Models\Rating;

class RatingsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RatingRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RatingRequest $request)
    {
        $rating = Rating::create($request->validated());

        return $this->success("Rated successfully.", $rating);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RatingRequest  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RatingRequest $request, Rating $rating)
    {
        $rating->update($request->validated());

        return $this->success("Rating updated successfully");
    }
}
