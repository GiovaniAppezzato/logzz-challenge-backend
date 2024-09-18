<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{TestConnectionController,AuthController,ProductController};

Route::get('/test-connection', TestConnectionController::class);

Route::post('/sign-in', [AuthController::class, 'signIn']);
Route::post('/sign-up', [AuthController::class, 'signUp']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::delete('/sign-out', [AuthController::class, 'signOut']);
    Route::get('/user', [AuthController::class, 'show']);
    Route::put('/user', [AuthController::class, 'update']);

    Route::apiResource('/products', ProductController::class);
});
