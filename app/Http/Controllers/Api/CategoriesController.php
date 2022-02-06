<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Requests\Category\DestroyRestoreRequest;
use App\QueryFilters\DeletedAt;
use App\QueryFilters\Name;
use Illuminate\Pipeline\Pipeline;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Manage Categories');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = app(Pipeline::class)
            ->send(Category::query())
            ->through([
                DeletedAt::class
            ])
            ->thenReturn()
            ->get();

        return $this->success("Categories fetched successfully.", $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Category\StoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $category = Category::create($request->validated());

        return $this->success("Category created successfully.", $category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return $this->success("Category fetched successfully.", $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Category\UpdateRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return $this->success("Category updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Category\DestroyRestoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DestroyRestoreRequest $request)
    {
        Category::whereIn('id', $request->category_ids)->delete();

        return $this->success("Category/ies deleted successfully.");
    }

    public function restore(DestroyRestoreRequest $request)
    {
        Category::onlyTrashed()
            ->whereIn('id', $request->category_ids)
            ->restore();

        return $this->success("Category/ies restored successfully.");
    }
}
