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
use App\Models\DetailTransaksi;
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
Route::middleware(['auth:api', \App\Http\Middleware\AddUserIdFromRole::class,])->group(function () {
    Route::post('/siswa', [SiswaController::class, 'create'])->name('create.siswa');
    Route::put('/siswa/{id}', [SiswaController::class, 'update']);
    Route::post('/admin', [AdminSController::class, 'createadmin'])->name('create.admin_stan');
    Route::put('/updateadmin/{id}', [AdminSController::class, 'updateadmin']);
});
Route::get('/get', [SiswaController::class, 'get']);
Route::delete('/delete/{id}', [SiswaController::class, 'delete']);
Route::get('/getmenu', [SiswaController::class, 'getMenu']);
Route::get('/statuspesan/{id_transaksi}', [SiswaController::class, 'getstatuspesan']);
Route::get('/gethistorytransaksi/{id_siswa}/{month}/{year}', [SiswaController::class, 'getTransaksiByMonth']);
Route::get('/cetak-nota/{id_transaksi}', [DetailTransaksiController::class, 'cetakNota']);

Route::middleware(['auth:api', \App\Http\Middleware\CheckRoleSiswa::class,])->group(function () {
    Route::get('/cetak-notas/{id_transaksi}', [SiswaController::class, 'cetakNotas']);
});
Route::middleware(['auth:api', \App\Http\Middleware\CheckRoleAdmin::class,])->group(function () {
    Route::get('/pemesanan/{month}/{year}', [AdminSController::class, 'getRekapPemesananByMonth']);
});

Route::get('/getadmin', [AdminSController::class, 'getadmin']);
Route::delete('/deleteadmin/{id}', [AdminSController::class, 'deleteadmin']);

Route::get('/getmenu', [MenuController::class, 'getmenu']);
Route::post('/menu', [MenuController::class, 'createmenu']);
Route::put('/updatemenu/{id}', [MenuController::class, 'updatemenu']);
Route::delete('/deletemenu/{id}', [MenuController::class, 'deletemenu']);

Route::get('/diskon', [DiskonController::class, 'get']);
Route::post('/diskon', [DiskonController::class, 'creatediskon']);
Route::put('/diskon/{id}', [DiskonController::class, 'updatediskon']);
Route::delete('/diskon/{id}', [DiskonController::class, 'deletediskon']);

Route::post('/diskonmenu', [MenuDiskonController::class, 'creatediskonmenu']);
Route::get('/getmenudiskon', [MenuDiskonController::class, 'getmenudiskon']);
Route::put('/updatemenudiskon/{id}', [MenuDiskonController::class, 'updatediskonmenu']);
Route::delete('/diskonmenu/{id}', [MenuDiskonController::class, 'deletemenudiskon']);

Route::middleware(['auth:api', \App\Http\Middleware\AddSiswaId::class,])->group(function () {
    Route::put('/updatetransaksi/{id}', [TransaksiController::class, 'updatetransaksi']);
    Route::post('/transaksi', [TransaksiController::class, 'transaksi']);
});
Route::get('/gettransaksi', [TransaksiController::class, 'gettransaksi']);
Route::get('/transaksi/{month}/{year}', [TransaksiController::class, 'getTransaksiByMonth']);
Route::put('/updatestatus/{id}', [TransaksiController::class, 'updateStatus']);

Route::middleware(['auth:api', \App\Http\Middleware\CheckRoleSiswa::class,])->group(function () {
    Route::post('/detailtransaksi', [DetailTransaksiController::class, 'detailtransaksi']);
});
Route::get('/getdetailtransaksi', [DetailTransaksiController::class, 'getdetailtransaksi']);
Route::get('/rekappemasukan/{month}/{year}', [DetailTransaksiController::class, 'getRekapPemasukanByMonth']);