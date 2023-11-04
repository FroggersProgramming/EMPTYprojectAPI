<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryFieldStoreRequest;
use App\Http\Requests\CategoryFieldUpdateRequest;
use App\Http\Resources\CategoryFieldResource;
use App\Models\Category;
use App\Models\CategoryField;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     */
    public function index(Request $request)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        $categoryFields = CategoryField::all();
        if (!$authUser || $authUser->cannot('viewAny', $categoryFields[0])) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data' => CategoryFieldResource::collection($categoryFields),
                'error' => [],
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param CategoryFieldStoreRequest $request
     * @return JsonResponse
     */
    public function store(CategoryFieldStoreRequest $request)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        $categoryField = new CategoryField();
        if (!$authUser || $authUser->cannot('create', $categoryField)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $categoryField->fill($request->validated()['category_field']);
            $category = Category::find($request->validated()['category_id']);
            $categoryField->save();
            $categoryField->category()->attach($category);
            $categoryField->push();
            return response()->json([
                'data' => new CategoryFieldResource($categoryField),
                'error' => [],
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     * @param CategoryField $categoryField
     * @param Request $request
     */
    public function show(CategoryField $categoryField, Request $request)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('view', $categoryField)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data'  =>  new CategoryFieldResource($categoryField),
                'error' =>  [],
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param CategoryFieldUpdateRequest $request
     * @param CategoryField $categoryField
     */
    public function update(CategoryFieldUpdateRequest $request, CategoryField $categoryField)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('update', $categoryField)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $categoryField->update($request->validated()['category_field']);
            $category = Category::find($request?->category_id);
            if ($category) {
                $categoryField->category()->sync($category);
            }
            $categoryField->push();
            return response()->json([
                'data'  =>  new CategoryFieldResource($categoryField),
                'error' =>  [],
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param CategoryField $categoryField
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(CategoryField $categoryField, Request $request)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('delete', $categoryField)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $categoryField->delete();
            return response()->json([
                'data'  =>  [
                    'message'   =>  'Success',
                ],
                'error' =>  [],
            ], 200);
        }
    }
}
