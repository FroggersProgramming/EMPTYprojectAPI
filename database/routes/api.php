<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Resources\CategoryResource;
use App\Http\Controllers\CategoryFieldController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/test/categories', function () {
    return CategoryResource::collect(Category::all());
});
Route::post('/login', [UserController::class, 'auth'])->name('login');
Route::post('/register', [UserController::class, 'store'])->name('register');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['api.auth','auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [UserController::class, 'logout'])->name('loguot');

});

Route::middleware('api.auth')->group(function () {

    // Route::get('/user', function(Request $request){
    //     $user = auth()->user();
    //     return response()->json([
    //         'data'  =>  [$user],
    //         'error' =>  [],
    //     ], 200);
    // });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')
            ->name('user.index');
        // Route::post('/logout', 'logout');
        Route::get('/user/{user}', 'show')
            ->name('user.show');
        Route::patch('/user/{user}/update', 'update')
            ->name('user.update');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index')
            ->name('role.index');
        Route::post('/role', 'store')
            ->name('role.store');
        Route::patch('/role/{role}', 'update')
            ->name('role.update');
        Route::get('/role/{role}', 'show')
            ->name('role.show');
        Route::delete('/role/{role}/destroy', 'destroy')
            ->name('role.destroy');
    });

    Route::controller(CategoryFieldController::class)->group(function () {
        Route::get('/categoryFields', 'index')
            ->name('categoryField.index');
        Route::post('/categoryField', 'store')
            ->name('categoryField.store');
        Route::patch('/categoryField/{categoryField}', 'update')
            ->name('categoryField.update');
        Route::get('/categoryField/{categoryField}', 'show')
            ->name('categoryField.show');
        Route::delete('/categoryField/{categoryField}/destroy', 'destroy')
            ->name('categoryField.destroy');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories', 'index')
            ->name('category.index');
        Route::get('/category/{category}', 'show')
            ->name('category.show');
        Route::post('/category', 'store')
            ->name('category.store');
        Route::patch('/category/{category}', 'update')
            ->name('category.update');
        Route::delete('/category/{category}/destroy', 'destroy')
            ->name('category.destroy');
    });

    Route::controller(AdvertisementController::class)->group(function () {
        Route::get('/advertisements/{filter?}', 'index')
            ->name('advertisement.index');
        Route::post('/advertisement', 'store')
            ->name('advertisement.store');
        Route::patch('/advertisement/{advertisement}', 'update')
            ->name('advertisement.update');
        Route::get('/advertisement/{advertisement}', 'show')
            ->name('advertisement.show');
        Route::delete('/advertisement/{advertisement}/destroy', 'destroy')
            ->name('advertisement.destroy');
    });
    Route::controller(PhotoController::class)->group(function () {
        Route::get('/advertisement/{advertisement}/photo', 'index')
            ->name('advertisement.photo.index');
        Route::post('/advertisement/{advertisement}/photo', 'store')
            ->name('advertisement.photo.store');
        Route::delete('/advertisement/{advertisement}/photo', 'destroy')
            ->name('advertisement.photo.destroy');
    });

});
