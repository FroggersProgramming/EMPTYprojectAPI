<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
    return \App\Http\Resources\CategoryResource::collect(\App\Models\Category::all());
});
Route::post('/login', [UserController::class, 'auth'])->name('login');
Route::post('/register', [UserController::class, 'store'])->name('register');

Route::middleware('api.auth')->group(function() {


    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')
            ->name('user.index');
        Route::get('/user/{user}', 'show')
            ->name('user.show');
        Route::patch('/user/{user}/update', 'update')
            ->name('user.update');
    });

    Route::controller(RoleController::class)->group(function() {
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

    Route::controller(\App\Http\Controllers\CategoryFieldController::class)->group(function() {
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

    Route::controller(CategoryController::class)->group(function() {
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

});
