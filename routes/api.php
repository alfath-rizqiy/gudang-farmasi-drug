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

Route::apiResource('obats', ObatController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::apiResource('kemasans', KemasanController::class);
Route::apiResource('aturan-pakai', AturanPakaiController::class);
Route::apiResource('satuan-kecil', SatuanKecilController::class);
Route::apiResource('satuan-besar', SatuanBesarController::class);
Route::apiResource('kategori', KategoriController::class);
Route::apiResource('metode-pembayaran', MetodePembayaranController::class);
