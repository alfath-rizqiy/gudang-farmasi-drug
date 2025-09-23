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
use App\Http\Controllers\Api\HargaController;

Route::get('/obat', function (Request $request) {
    return $request->obat();
})->middleware('auth:sanctum');

Route::resource('/obat', ObatController::class);
Route::resource('/supplier', SupplierController::class);
Route::resource('/kemasan', KemasanController::class);
Route::resource('/aturanpakai', AturanPakaiController::class);
Route::apiResource('/satuankecil', SatuanKecilController::class);
Route::apiResource('/satuanbesar', SatuanBesarController::class);
Route::resource('/kategori', KategoriController::class);
Route::resource('/metodepembayaran', MetodePembayaranController::class);
Route::apiResource('/harga', HargaController::class);