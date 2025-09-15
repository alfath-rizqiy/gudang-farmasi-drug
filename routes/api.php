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
use App\Http\Controllers\Api\ProfileController;

// routes/api.php
Route::middleware('auth:sanctum')->put('/profil/update', [\App\Http\Controllers\Api\ProfileController::class, 'update']);

Route::apiResource('/obat', ObatController::class);
Route::apiResource('/supplier', SupplierController::class);
Route::apiResource('/kemasan', KemasanController::class);
Route::apiResource('/aturanpakai', AturanPakaiController::class);
Route::apiResource('/satuankecil', SatuanKecilController::class);
Route::apiResource('/satuanbesar', SatuanBesarController::class);
Route::apiResource('/kategori', KategoriController::class);
Route::apiResource('/metodepembayaran', MetodePembayaranController::class);
