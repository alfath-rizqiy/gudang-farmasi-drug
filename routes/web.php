<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ObatExport;
use App\Models\Obat;
use App\Models\Supplier;
use App\Models\Kemasan;
use App\Models\SatuanKecil;
use App\Models\SatuanBesar;
use App\Models\AturanPakai;
use App\Models\Kategori;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\KemasanController;
use App\Http\Controllers\AturanPakaiController;
use App\Http\Controllers\SatuanKecilController;
use App\Http\Controllers\SatuanBesarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ObatImportExportController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\HargaController;

// Pdf Obat
Route::get('/obat/export-pdf', function () {
    $obats = Obat::all();
    $pdf = Pdf::loadView('obat.pdf', compact('obats'));

    $tanggal = now()->format('Y-m-d');
    $filename = "Data Obat {$tanggal}.pdf";

    return $pdf->download($filename);
})->name('obat.export.pdf');

// Pdf Supplier
Route::get('/supplier/export-pdf', function () {
    $suppliers = Supplier::all();
    $pdf = Pdf::loadView('supplier.pdf', compact('suppliers'));

    $tanggal = now()->format('Y-m-d');
    $filename = "Data Supplier {$tanggal}.pdf";

    return $pdf->download($filename);
})->name('supplier.export.pdf');

// Pdf Kemasan
Route::get('/kemasan/export-pdf', function () {
    $kemasans = Kemasan::all();
    $pdf = Pdf::loadView('kemasan.pdf', compact('kemasans'));

    $tanggal = now()->format('Y-m-d');
    $filename = "Data Kemasan {$tanggal}.pdf";

    return $pdf->download($filename);
})->name('kemasan.export.pdf');

// Pdf Satuan Kecil
Route::get('/satuankecil/export-pdf', function () {
    $satuankecils = SatuanKecil::all();
    $pdf = Pdf::loadView('satuankecil.pdf', compact('satuankecils'));

    $tanggal = now()->format('Y-m-d');
    $filename = "Data Satuan Kecil {$tanggal}.pdf";

    return $pdf->download($filename);
})->name('satuankecil.export.pdf');

// Pdf Satuan Besar
Route::get('/satuanbesar/export-pdf', function () {
    $satuanbesars = SatuanBesar::all();
    $pdf = Pdf::loadView('satuanbesar.pdf', compact('satuanbesars'));

    $tanggal = now()->format('Y-m-d');
    $filename = "Data Satuan Besar {$tanggal}.pdf";

    return $pdf->download($filename);
})->name('satuanbesar.export.pdf');

// Pdf Aturan Pakai
Route::get('/aturanpakai/export-pdf', function () {
    $aturanpakais = AturanPakai::all();
    $pdf = Pdf::loadView('aturanpakai.pdf', compact('aturanpakais'));

    $tanggal = now()->format('Y-m-d');
    $filename = "Data Aturan Pakai {$tanggal}.pdf";

    return $pdf->download($filename);
})->name('aturanpakai.export.pdf');

// Pdf Aturan Pakai
Route::get('/kategori/export-pdf', function () {
    $kategoris = Kategori::all();
    $pdf = Pdf::loadView('kategori.pdf', compact('kategoris'));

    $tanggal = now()->format('Y-m-d');
    $filename = "Data Kategori {$tanggal}.pdf";

    return $pdf->download($filename);
})->name('kategori.export.pdf');


// Excel Obat
Route::get('obat/export/', [ObatImportExportController::class, 'export'])
->name('obat.export.excel');

// Excel Supplier
Route::get('supplier/export/', [SupplierController::class, 'export'])
->name('supplier.export.excel');

// Excel Supplier
Route::get('kemasan/export/', [KemasanController::class, 'export'])
->name('kemasan.export.excel');

// Excel Satuan Kecil
Route::get('satuankecil/export/', [SatuanKecilController::class, 'export'])
->name('satuankecil.export.excel');

// Excel Satuan Besar
Route::get('satuanbesar/export/', [SatuanBesarController::class, 'export'])
->name('satuanbesar.export.excel');

// Excel Satuan Besar
Route::get('aturanpakai/export/', [AturanPakaiController::class, 'export'])
->name('aturanpakai.export.excel');

// Excel Satuan Besar
Route::get('kategori/export/', [KategoriController::class, 'export'])
->name('kategori.export.excel');


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
    Route::get('/{obat}', [ObatController::class, 'show'])->name('show');

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
    });

    // Satuan Besar Route
    Route::prefix('satuanbesar')->name('satuanbesar.')->group(function () {
        Route::get('/', [SatuanBesarController::class, 'index'])->name('index');
    });
    
    // Kategori Route
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('/{kategori}', [KategoriController::class, 'show'])->name('show');
    });

     // Harga Route
    Route::prefix('harga')->name('harga.')->group(function () {
        Route::get('/', [HargaController::class, 'index'])->name('index');
    });
});
});

require __DIR__.'/auth.php';