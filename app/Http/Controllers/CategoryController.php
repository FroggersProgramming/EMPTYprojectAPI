<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        $categories = Category::where('parent_id', null)->get();
        if (!$authUser || $authUser->cannot('viewAny', new Category())) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data' => CategoryResource::collection($categories),
                'error' => [],
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param CategoryStoreRequest $request
     * @return JsonResponse
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        $category = new Category();
        if (!$authUser || $authUser->cannot('create', $category)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $category->fill($request->validated());
            $category->save();
            return response()->json([
                'data'  =>  new CategoryResource($category),
                'error' =>  [],
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     * @param Category $category
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Category $category, Request $request): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('view', $category)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data'  =>  new CategoryResource($category),
                'error' =>  [],
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('update', $category)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $category->update($request->validated());
            $category->save();
            return response()->json([
                'data'  =>  new CategoryResource($category),
                'error' =>  [],
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Category $category, Request $request): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('delete', $category)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $category->delete();
            return response()->json([
                'data'  =>  [
                    'message'   =>  'Success',
                ],
                'error' =>  [],
            ]);
        }
    }
}
