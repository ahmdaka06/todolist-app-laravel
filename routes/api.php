<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\TodoController;
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

Route::group(['namespace' => 'API', 'middleware' => ['json']], function () {
    Route::group(['prefix' => 'v2'], function () {

        Route::post('/register', [RegisterController::class, 'index']);
        Route::post('/login', [LoginController::class, 'index']);

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::get('/logout', [LoginController::class, 'logout']);

            Route::group(['prefix' => 'account'], function () {
                Route::post('/saveToken', [AccountController::class, 'saveToken']);
                Route::get('/profile', [AccountController::class, 'profile']);
                Route::put('/profile', [AccountController::class, 'update']);
                Route::get('/activities', [AccountController::class, 'activities']);
            });

            Route::group(['prefix' => 'todo'], function () {
                Route::get('/', [TodoController::class, 'index']);
                Route::post('/', [TodoController::class, 'create']);
                Route::get('/{hash}', [TodoController::class, 'show']);
                Route::put('/{hash}', [TodoController::class, 'update']);
                Route::delete('/{hash}', [TodoController::class, 'delete']);
            });
        });
    });
});
