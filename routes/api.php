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
use App\Http\Controllers\Api\HargaController;
use App\Http\Controllers\Api\ObatStatistikController;
use App\Http\Controllers\Api\ProfileController;


Route::resource('/obat', ObatController::class);
Route::get('/obat/{id}/statistik', [ObatStatistikController::class, 'index']);
Route::resource('/supplier', SupplierController::class);
Route::resource('/kemasan', KemasanController::class);
Route::resource('/aturanpakai', AturanPakaiController::class);
Route::apiResource('/satuankecil', SatuanKecilController::class);
Route::apiResource('/satuanbesar', SatuanBesarController::class);
Route::resource('/kategori', KategoriController::class);
Route::apiResource('/harga', HargaController::class);
