<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ObatController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\KemasanController;
use App\Http\Controllers\Api\AturanPakaiController;
use App\Http\Controllers\Api\SatuanKecilController;
use App\Http\Controllers\Api\SatuanBesarController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\MetodePembayaranController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/obat', ObatController::class);
Route::resource('/supplier', SupplierController::class);
Route::resource('/kemasans', KemasanController::class);
Route::resource('/aturanpakai', AturanPakaiController::class);
Route::resource('/satuankecil', SatuanKecilController::class);
Route::resource('/satuanbesar', SatuanBesarController::class);
Route::resource('/kategori', KategoriController::class);
Route::resource('/metodepembayaran', MetodePembayaranController::class);
