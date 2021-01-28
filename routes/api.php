<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;

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

