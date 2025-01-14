<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('/get', [CrudController::class, 'get']);
Route::post('/add', [CrudController::class, 'create']);
Route::put('/update/{id}', [CrudController::class, 'update']);
Route::post('/add', [CrudController::class, 'create']);
Route::delete('/delete/{id}', [CrudController::class, 'delete']);