<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KemasanController;
use App\Http\Controllers\AturanPakaiController;
use App\Http\Controllers\SatuanKecilController;
use App\Http\Controllers\SatuanBesarController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Obat Route
    Route::prefix('obat')->name('obat.')->group(function () {
        Route::get('/', [ObatController::class, 'index'])->name('index');
        Route::get('/create', [ObatController::class, 'create'])->name('create');
        Route::post('/', [ObatController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ObatController::class, 'update'])->name('update');
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('destroy');
    });

    // Supplier Route
    Route::prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/create', [SupplierController::class, 'create'])->name('create');
        Route::post('/', [SupplierController::class, 'store'])->name('store');
        Route::get('/{supplier}', [SupplierController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SupplierController::class, 'update'])->name('update');
        Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('destroy');
    });

    // Kemasan Route
    Route::prefix('kemasan')->name('kemasan.')->group(function () {
        Route::get('/', [KemasanController::class, 'index'])->name('index');
        Route::get('/create', [KemasanController::class, 'create'])->name('create');
        Route::post('/', [KemasanController::class, 'store'])->name('store');
        Route::get('/{kemasan}', [KemasanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [KemasanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KemasanController::class, 'update'])->name('update');
        Route::delete('/{id}', [KemasanController::class, 'destroy'])->name('destroy');
    });

     Route::prefix('aturanpakai')->name('aturanpakai.')->group(function () {
    Route::get('/', [AturanPakaiController::class, 'index'])->name('index');
    Route::get('/create', [AturanPakaiController::class, 'create'])->name('create');
    Route::post('/', [AturanPakaiController::class, 'store'])->name('store');
    Route::get('/{aturanpakai}', [AturanPakaiController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [AturanPakaiController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AturanPakaiController::class, 'update'])->name('update');
    Route::delete('/{id}', [AturanPakaiController::class, 'destroy'])->name('destroy');
     });
    
     // Satuan Kecil Route
    Route::prefix('satuankecil')->name('satuankecil.')->group(function () {
        Route::get('/', [SatuanKecilController::class, 'index'])->name('index');
        Route::get('/create', [SatuanKecilController::class, 'create'])->name('create');
        Route::post('/', [SatuanKecilController::class, 'store'])->name('store');
        Route::get('/{satuankecil}', [SatuanKecilController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SatuanKecilController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SatuanKecilController::class, 'update'])->name('update');
        Route::delete('/{id}', [SatuanKecilController::class, 'destroy'])->name('destroy');
    });

    // Satuan Besar Route
    Route::prefix('satuanbesar')->name('satuanbesar.')->group(function () {
        Route::get('/', [SatuanBesarController::class, 'index'])->name('index');
        Route::get('/create', [SatuanBesarController::class, 'create'])->name('create');
        Route::post('/', [SatuanBesarController::class, 'store'])->name('store');
        Route::get('/{satuanbesar}', [SatuanBesarController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SatuanBesarController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SatuanBesarController::class, 'update'])->name('update');
        Route::delete('/{id}', [SatuanBesarController::class, 'destroy'])->name('destroy');
    });
});
});

require __DIR__.'/auth.php';
