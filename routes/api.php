<?php

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

Route::post('/login', [UserController::class, 'auth'])->name('login');
Route::post('/register', [UserController::class, 'store'])->name('register');

Route::middleware('api.auth')->group(function() {

    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');

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

});
