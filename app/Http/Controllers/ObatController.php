<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Supplier;
use App\Models\Kategori;
use App\Models\MetodePembayaran;

class ObatController extends Controller
{
    /**
     * Menampilkan semua data obat.
     */
    public function index()
    {
        // Ambil data obat beserta relasi supplier
        $obats = Obat::with('supplier')->get();

        // Ambil data obat beserta relasi kategori (overwrite variabel sebelumnya)
        $obats = Obat::with('kategori')->get();

        // Ambil data obat beserta relasi metode pembayaran (overwrite lagi)
        $obats = Obat::with('metodepembayaran')->get();

        // Tampilkan ke view index
        return view('obat.index', compact('obats')); 
    }

    /**
     * Menampilkan form untuk membuat obat baru.
     */
    public function create()
    {
        // Ambil semua data relasi untuk dropdown
        return view('obat.create', [
            'suppliers' => Supplier::all(),
            'kategoris' => Kategori::all(),
            'metode_pembayarans' => MetodePembayaran::all(),
        ]);
    }

    /**
     * Menyimpan data obat baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
        ]);

        // Simpan data ke tabel obat
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
            'kategori_id' => $request->kategori_id,
            'metodepembayaran_id' => $request->metodepembayaran_id,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'obat berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail obat berdasarkan ID.
     */
    public function show(string $id)
    {
        // Ambil data obat beserta semua relasi
        $obat = Obat::with([
            'supplier',
            'kategori',
            'metodepembayaran',
        ])->findOrFail($id);

        // Tampilkan ke view show
        return view('obat.show', compact('obat'));
    }

    /**
     * Menampilkan form edit untuk obat tertentu.
     */
    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id); // Ambil data obat berdasarkan ID
        $suppliers = Supplier::all(); // Ambil semua supplier untuk dropdown
        $kategoris = Kategori::all(); // Ambil semua kategori untuk dropdown
        $metode_pembayarans = MetodePembayaran::all(); // Ambil semua metode pembayaran

        // Tampilkan ke view edit dengan data relasi
        return view('obat.edit', compact('obat', 'suppliers', 'kategoris', 'metode_pembayarans'));
    }

    /**
     * Mengupdate data obat berdasarkan ID.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input dari form
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
        ]);

        // Ambil data obat dan update dengan input baru
        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
            'kategori_id' => $request->kategori_id,
            'metodepembayaran_id' => $request->metodepembayaran_id,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Menghapus data obat berdasarkan ID.
     */
    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id); // Ambil data obat berdasarkan ID
        $obat->delete(); // Hapus dari database

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data berhasil dihapus.');
    }
}
