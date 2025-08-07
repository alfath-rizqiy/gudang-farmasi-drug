<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SatuanKecil;

class SatuanKecilController extends Controller
{
    /**
     * Menampilkan semua data satuan besar.
     */
    public function index()
    {
        $satuankecil = SatuanKecil::all();
        return view('satuankecil.index', compact('satuankecil')); 
    }

    /**
     * Menampilkan form untuk menambahkan satuan besar baru.
     */
    public function create()
    {
        return view('satuankecil.create');
    }

    /**
     * Menyimpan data satuan besar ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_satuankecil' => 'required|string',
            'deskripsi' => 'nullable|string', 
        ]);

        // Simpan data
        SatuanKecil::create($validated);

        return redirect()->route('satuankecil.index')->with('success', 'Satuan Kecil berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satuan besar berdasarkan ID.
     */
    public function show(string $id)
    {
        $satuankecil = SatuanKecil::with('obats')->findOrFail($id);
        return view('satuankecil.show', compact('satuankecil'));
    }

    /**
     * Menampilkan form edit untuk satuan besar tertentu.
     */
    public function edit(string $id)
    {
        $satuankecil = SatuanKecil::findOrFail($id);
        return view('satuankecil.edit', compact('satuankecil'));
    }

    /**
     * Memperbarui data satuan besar berdasarkan ID.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama_satuankecil' => 'required|string',
            'deskripsi' => 'nullable|string', 
        ]);

        // Update data
        $satuankecil = SatuanKecil::findOrFail($id);
        $satuankecil->update($request->only(['nama_satuankecil', 'deskripsi',]));

        return redirect()->route('satuankecil.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Menghapus data satuan besar berdasarkan ID.
     */
   public function destroy($id)
{
    try {
        $satuankecil = SatuanKecil::findOrFail($id);

        // Cek apakah supplier masih punya relasi obat
        if ($satuankecil->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data satuankecil tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $satuankecil->delete();
        return redirect()->back()->with('success', 'Data satuankecil berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data satuankecil.');
    }
}

}
