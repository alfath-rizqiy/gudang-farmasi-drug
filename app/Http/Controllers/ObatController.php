<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Supplier;
use App\Models\SatuanKecil;
use App\Models\SatuanBesar;

class ObatController extends Controller
{
    /**
     * Menampilkan semua data obat beserta relasi supplier, satuan kecil, dan satuan besar.
     */
    public function index()
    {
        // Mengambil data obat beserta relasi supplier, satuan kecil, dan satuan besar
        $obats = Obat::with('supplier')->get();
        $obats = Obat::with('satuankecil')->get();
        $obats = Obat::with('satuanbesar')->get();

        // Menampilkan view index dengan data obat
        return view('obat.index', compact('obats')); 
    }

    /**
     * Menampilkan form untuk menambahkan data obat baru.
     */
    public function create()
    {
        // Mengambil data relasi untuk dropdown di form
        return view('obat.create', [
            'suppliers' => Supplier::all(),
            'satuan_kecils' => SatuanKecil::all(),
            'satuan_besars' => SatuanBesar::all(),
        ]);
    }

    /**
     * Menyimpan data obat baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
            'satuan_besar_id' => 'required|exists:satuan_besars,id',
        ]);

        // Simpan data ke tabel obat
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
            'satuan_kecil_id' => $request->satuan_kecil_id,
            'satuan_besar_id' => $request->satuan_besar_id,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'obat berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data obat berdasarkan ID.
     */
    public function show(string $id)
    {
        // Ambil data obat beserta relasi
        $obat = Obat::with([
            'supplier',
            'satuankecil',
            'satuanbesar',
        ])->findOrFail($id);

        // Tampilkan view detail
        return view('obat.show', compact('obat'));
    }

    /**
     * Menampilkan form edit untuk data obat tertentu.
     */
    public function edit(string $id)
    {
        // Ambil data obat dan relasi untuk form edit
        $obat = Obat::findOrFail($id);
        $suppliers = Supplier::all();
        $satuan_kecils = SatuanKecil::all();
        $satuan_besars = SatuanBesar::all();

        // Tampilkan view edit
        return view('obat.edit', compact('obat', 'suppliers', 'satuan_kecils', 'satuan_besars'));
    }

    /**
     * Memperbarui data obat berdasarkan ID.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama_obat' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
            'satuan_besar_id' => 'required|exists:satuan_besars,id',
        ]);

        // Update data obat
        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
            'satuan_kecil_id' => $request->satuan_kecil_id,
            'satuan_besar_id' => $request->satuan_besar_id,
        ]);

        // Redirect ke index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Menghapus data obat berdasarkan ID.
     */
    public function destroy(string $id)
    {
        // Hapus data obat
        $obat = Obat::findOrFail($id);
        $obat->delete();

        // Redirect ke index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data berhasil dihapus.');
    }
}
