<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])
            ->withoutMiddleware('auth:sanctum');

        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::get('who-am-i', [AuthController::class, 'whoAmI']);
    });

    Route::resources(
        [
            'teams' => TeamController::class,
            'images' => ImageController::class
        ],
        [
            'only' => ['index', 'store', 'show', 'update', 'destroy']
        ]
    );


});
