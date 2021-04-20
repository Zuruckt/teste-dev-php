<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\BrandController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'cars'], function () {
    Route::get('/', [CarController::class, 'index']);
    Route::post('/', [CarController::class, 'store']);
    Route::get('/{id}', [CarController::class, 'show']);
    Route::put('/{id}', [CarController::class, 'update']);
    Route::delete('/{id}', [CarController::class, 'delete']);
});

Route::group(['prefix' => 'users'], function () {
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::get('/me', [AuthController::class,'me']);
    Route::get('/refresh', [AuthController::class,'refresh']);
    Route::post('/register', [AuthController::class,'register']);
});

Route::get('/brands', BrandController::class);

