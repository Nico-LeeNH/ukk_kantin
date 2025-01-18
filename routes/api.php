<?php

use App\Http\Controllers\AdminSController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuDiskonController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TransaksiController;
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

Route::get('/get', [SiswaController::class, 'get']);
Route::post('/add', [SiswaController::class, 'create']);
Route::put('/update/{id}', [SiswaController::class, 'update']);
Route::delete('/delete/{id}', [SiswaController::class, 'delete']);
Route::get('/getmenu', [SiswaController::class, 'getMenu']);

Route::get('/getadmin', [AdminSController::class, 'getadmin']);
Route::post('/addadmin', [AdminSController::class, 'createadmin']);
Route::put('/updateadmin/{id}', [AdminSController::class, 'updateadmin']);
Route::delete('/deleteadmin/{id}', [AdminSController::class, 'deleteadmin']);

Route::get('/get', [MenuController::class, 'getmenu']);
Route::post('/add', [MenuController::class, 'createmenu']);
Route::put('/update/{id}', [MenuController::class, 'updatemenu']);
Route::delete('/delete/{id}', [MenuController::class, 'deletemenu']);

Route::get('/diskon', [DiskonController::class, 'get']);
Route::post('/diskon', [DiskonController::class, 'creatediskon']);
Route::put('/diskon/{id}', [DiskonController::class, 'updatediskon']);
Route::delete('/diskon/{id}', [DiskonController::class, 'deletediskon']);

Route::post('/diskonmenu', [MenuDiskonController::class, 'creatediskonmenu']);

Route::get('/gettransaksi', [TransaksiController::class, 'gettransaksi']);
Route::post('/addtransaksi', [TransaksiController::class, 'transaksi']);

Route::get('/getdetailtransaksi', [DetailTransaksiController::class, 'getdetailtransaksi']);
Route::post('/detailtransaksi', [DetailTransaksiController::class, 'detailtransaksi']);