<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertisementStoreRequest;
use App\Http\Requests\AdvertisementUpdateRequest;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     */
    public function index(Request $request)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        $advertisements = Advertisement::with('user')->get();
        if (!$authUser || $authUser->cannot('viewAny', $advertisements[0])) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data' => AdvertisementResource::collection($advertisements),
                'error' => '',
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param AdvertisementStoreRequest $request
     */
    public function store(AdvertisementStoreRequest $request)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        $advertisement = new Advertisement();
        if (!$authUser || $authUser->cannot('create', $advertisement)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $advertisement->fill($request->advertisement);
            $advertisement->user()->associate($authUser);
            $advertisement->save();
            if ($request->has('categoryFields')) {
                $advertisement->categoryFields()->sync($request->categoryFields);
            }
            $advertisement->push();
            return response()->json([
                'data'  =>  AdvertisementResource::make($advertisement),
                'error' =>  '',
            ],200);
        }
    }

    /**
     * Display the specified resource.
     * @param Advertisement $advertisement
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Advertisement $advertisement, Request $request)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('view', $advertisement)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            return response()->json([
                'data'  =>  AdvertisementResource::make($advertisement),
                'error' =>  '',
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param AdvertisementUpdateRequest $request
     * @param Advertisement $advertisement
     * @return JsonResponse
     */
    public function update(AdvertisementUpdateRequest $request, Advertisement $advertisement)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('update', $advertisement)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            if ($request->has('advertisement')) {
                $advertisement->update($request->advertisement);
            }
            if ($request->has('categoryFields')) {
                $advertisement->categoryFields()->sync($request->categoryFields);
            }
            return response()->json([
                'data'  =>  AdvertisementResource::make($advertisement),
                'error' =>  '',
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Advertisement $advertisement
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Advertisement $advertisement, Request $request)
    {
        $authUser = User::where('remember_token', $request->bearerToken())->first();
        if (!$authUser || $authUser->cannot('delete', $advertisement)) {
            return response()->json([
                'data' => [],
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized',
                ],
            ], 401);
        } else {
            $advertisement->delete();
            return response()->json([
                'data'  =>  [
                    'message'   =>  'Success',
                ],
                'error' =>  '',
            ], 200);
        }
    }
}
