<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    /**
     * Список ролей.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        $roles = Role::all();
        if (!$authUser || $authUser->cannot('viewAny', $roles[0])) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data' => RoleResource::collection($roles),
                'error' => [],
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param RoleStoreRequest $request
     * @return JsonResponse
     */
    public function store(RoleStoreRequest $request): JsonResponse
    {
        $role = new Role();
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('create', $role)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $role->fill($request->validated());
            $role->save();
            return response()->json([
                'data' => new RoleResource($role),
                'error' => [],
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     * @param Role $role
     * @return JsonResponse
     */
    public function show(Role $role, Request $request): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('view', $role)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data' => new RoleResource($role),
                'error' => [],
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param RoleUpdateRequest $request
     * @param Role $role
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('view', $role)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $role->update($request->validated());
            $role->save();
            return response()->json([
                'data' => new RoleResource($role),
                'error' => [],
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Role $role
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Role $role, Request $request)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('delete', $role)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $role->delete();
            return response()->json([
                'data' => [
                    'message' => 'Success',
                ],
                'error' => [],
            ], 200);
        }
    }
}
