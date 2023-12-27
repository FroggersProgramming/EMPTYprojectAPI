<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoStoreRequest;
use App\Models\Advertisement;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Advertisement|null $advertisement
     * @return JsonResponse
     */
    public function index(Advertisement $advertisement=null)
    {
        if ($advertisement) {
            $photos = $advertisement->photos;
        } else {
            $photos = Photo::all();
        }
        return response()->json([
            'data'  =>  $photos,
            'error' =>  '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param PhotoStoreRequest $request
     */
    public function store(PhotoStoreRequest $request)
    {
        $photo = new Photo();
        $photo->fill([
            'URL'   =>  $request->file('URL')->store(),
        ]);
        return response()->json([
            'data'  =>  [
                'message'   =>  'Success',
            ],
            'error' =>  [],
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param Photo $photo
     */
    public function destroy(Photo $photo)
    {
        $file = Storage::has($photo->URL);
        if ($file) {
            Storage::delete($photo->URL);
            return response()->json([
                'data'  =>  [
                    'message'   =>  'Success',
                ],
                'error' =>  [],
            ], 200);
        } else {
            return response()->json([
                'data'  =>  [
                    'message'   =>  'Already deleted',
                ],
                'error' =>  [],
            ], 200);
        }
    }
}
