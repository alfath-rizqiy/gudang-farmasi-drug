<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ObatExport;
use App\Models\Obat;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KemasanController;
use App\Http\Controllers\AturanPakaiController;
use App\Http\Controllers\SatuanKecilController;
use App\Http\Controllers\SatuanBesarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatImportExportController;


// Pdf Download
Route::get('/obat/export-pdf', function () {
    $obats = Obat::all();
    $pdf = Pdf::loadView('obat.pdf', compact('obats'));

    $tanggal = now()->format('Y-m-d');
    $filename = "Data Obat {$tanggal}.pdf";

    return $pdf->download($filename);
})->name('obat.export.pdf');

// Excel Download
Route::get('obat/export/', [ObatImportExportController::class, 'export'])
->name('obat.export.excel');


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
    Route::get('/', function () {
        return view('obat.index');
    })->name('index');

    // ✅ ini yang penting
    Route::post('/import', [ObatImportExportController::class, 'import'])->name('import');
    });


    // Supplier Route
    Route::prefix('supplier')->name('supplier.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('index');
        Route::get('/{supplier}', [SupplierController::class, 'show'])->name('show');
    });

    // Kemasan Route
    Route::prefix('kemasan')->name('kemasan.')->group(function () {
        Route::get('/', [KemasanController::class, 'index'])->name('index');
        Route::get('/{kemasan}', [KemasanController::class, 'show'])->name('show');
    });

     Route::prefix('aturanpakai')->name('aturanpakai.')->group(function () {
    Route::get('/', [AturanPakaiController::class, 'index'])->name('index');
    Route::get('/{aturanpakai}', [AturanPakaiController::class, 'show'])->name('show');
     });
    
     // Satuan Kecil Route
    Route::prefix('satuankecil')->name('satuankecil.')->group(function () {
        Route::get('/', [SatuanKecilController::class, 'index'])->name('index');
        Route::get('/{satuankecil}', [SatuanKecilController::class, 'show'])->name('show');
    });

    // Satuan Besar Route
    Route::prefix('satuanbesar')->name('satuanbesar.')->group(function () {
        Route::get('/', [SatuanBesarController::class, 'index'])->name('index');
        Route::get('/{satuanbesar}', [SatuanBesarController::class, 'show'])->name('show');
    });
    
    // Kategori Route
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/{kategori}', [KategoriController::class, 'show'])->name('show');
    });

    // Metode Pembayaran Route
    Route::prefix('metodepembayaran')->name('metodepembayaran.')->group(function () {
        Route::get('/', [MetodePembayaranController::class, 'index'])->name('index');
        Route::get('/{metodepembayaran}', [MetodePembayaranController::class, 'show'])->name('show');
    });
});
});

require __DIR__.'/auth.php';