<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Список пользователей.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        $users = User::all();
        if (!$authUser || $authUser->cannot('viewAny', $users->first())) {
            return response()->json([
                'data'  =>  [],
                'error' =>  [
                    'code'  =>  401,
                    'message'   =>  'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data'  =>  UserResource::collection($users),
                'error' =>  [],
            ], 200);
        }
    }

    /**
     * Авторизация пользователя в системе.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function auth(LoginRequest $request): JsonResponse
    {
        
        $valid = $request->validated();
        $user = User::where('email', $valid['email'])->first();
        if ($user && Auth::attempt($valid)) {
            
            /** @var User $user */
            $user = Auth::user();
            $token = $user->createToken('main')->plainTextToken;

            $user->remember_token = $token;
            $user->save();

            return response()->json([
                'data'  =>  [
                    'user'  =>  new UserResource($user),
                    'token'=>   $token
                ],
                'error' =>  [],
            ]);
        } else {
            return response()->json([
                'data'  =>  [],
                'error' =>  [
                    'code'  =>  422,
                    'message'   =>  'User not found',
                ],
            ], 422);
        }
    }

    /**
     * Регистрация пользователя.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        $user = new User();
        $user->fill($request->validated());
        // $user->setRememberToken(
        //     Str::random(100)
        // );
        $user->save();
        $token = $user->createToken('main')->plainTextToken;
        $user->remember_token = $token;
        $user->save();
        return response()->json([
            'data'  =>  [
                'user'  =>  new UserResource($user),
                'token' =>  $token,
            ],
            'error' =>  [],
        ], 201);
    }

    /**
     * Получение информации о пользователе (для личного кабинета).
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function show(Request $request, User $user): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('view', $user)) {
            return response()->json([
                'data'  =>  [],
                'error' =>  [
                    'code'  =>  401,
                    'message'   =>  'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data'  =>  new UserResource($user),
                'error' =>  [],
            ]);
        }
    }

    /**
     * Обновление информации о пользователе.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('view', $user)) {
            return response()->json([
                'data'  =>  [],
                'error' =>  [
                    'code'  =>  401,
                    'message'   =>  'Unauthorized',
                ],
            ], 401);
        } else {
            $user->update($request->validated()['user']);
            $role = Role::find($request->role_id);
            if ($role) {
                $user->role()->associate($role);
            }
            $user->save();
            return response()->json([
                'data'  =>  new UserResource($user),
                'error' =>  [],
            ], 200);
        }
    }

    /**
     * Удаление пользователя.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(Request $request, User $user): JsonResponse
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('view', $user) || $authUser->role->id === 1) {
            return response()->json([
                'data'  =>  [],
                'error' =>  [
                    'code'  =>  401,
                    'message'   =>  'Unauthorized',
                ],
            ], 401);
        } else {
            $user->delete();
            return response()->json([
                'data'  =>  [],
                'error' =>  [],
            ], 200);
        }
    }

    /**
     * Выход пользователя.
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'data'  =>  [],
            'error' =>  [],
        ], 204);
    }




    //  /**
    //  * Получение информации о пользователе (для личного кабинета).
    //  *
    //  * @param Request $request
    //  * @param User $user
    //  * @return JsonResponse
    //  */
    // public function user(Request $request): JsonResponse
    // {
    //     return response()->json([
    //         'data'  =>  $request,
    //         'error' =>  [],
    //     ]);
    // }
}
