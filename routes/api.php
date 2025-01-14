<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/get', [CrudController::class, 'get']);
Route::post('/add', [CrudController::class, 'create']);
Route::put('/update/{id}', [CrudController::class, 'update']);
Route::post('/add', [CrudController::class, 'create']);
Route::delete('/delete/{id}', [CrudController::class, 'delete']);