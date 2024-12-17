<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Info(title="My First API", version="0.1")
 */

class CategoryController extends Controller
{
    // add swagger annotations
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get all categories",
     *     @OA\Response(response="200", description="List of categories")
     * )
     */
    public function index(Request $request )
    {
        Log::info('CategoryController@index');
        Log::info('User: ' . auth()->user()->name);
        Log::info(Category::get());
        Log::info($request);

        // get table name
        Log::info(Category::getModel()->getTable());

        // select data by db
        Log::info(Category::select('id', 'name')->get());

        return CategoryResource::collection(Category::get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = auth()->user()->categories()->create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        return new CategoryResource(tap($category)->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
