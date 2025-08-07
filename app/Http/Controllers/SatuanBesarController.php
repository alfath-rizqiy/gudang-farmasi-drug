<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SatuanBesar;

class SatuanBesarController extends Controller
{
    /**
     * Menampilkan semua data satuan besar.
     */
    public function index()
    {
        $satuanbesar = SatuanBesar::all();
        return view('satuanbesar.index', compact('satuanbesar')); 
    }

    /**
     * Menampilkan form untuk menambahkan satuan besar baru.
     */
    public function create()
    {
        return view('satuanbesar.create');
    }

    /**
     * Menyimpan data satuan besar ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_satuanbesar' => 'required|string',
            'deskripsi' => 'nullable|string', 
            'jumlah_satuankecil' => 'required|string',
        ]);

        // Simpan data
        SatuanBesar::create($validated);

        return redirect()->route('satuanbesar.index')->with('success', 'Satuan Besar berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satuan besar berdasarkan ID.
     */
    public function show(string $id)
    {
        $satuanbesar = SatuanBesar::with('obats')->findOrFail($id);
        return view('satuanbesar.show', compact('satuanbesar'));
    }

    /**
     * Menampilkan form edit untuk satuan besar tertentu.
     */
    public function edit(string $id)
    {
        $satuanbesar = SatuanBesar::findOrFail($id);
        return view('satuanbesar.edit', compact('satuanbesar'));
    }

    /**
     * Memperbarui data satuan besar berdasarkan ID.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama_satuanbesar' => 'required|string',
            'deskripsi' => 'nullable|string', 
            'jumlah_satuankecil' => 'required|string',
        ]);

        // Update data
        $satuanbesar = SatuanBesar::findOrFail($id);
        $satuanbesar->update($request->only(['nama_satuanbesar', 'deskripsi', 'jumlah_satuankecil']));

        return redirect()->route('satuanbesar.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Menghapus data satuan besar berdasarkan ID.
     */
   public function destroy($id)
{
    try {
        $satuanbesar = SatuanBesar::findOrFail($id);

        // Cek apakah supplier masih punya relasi obat
        if ($satuanbesar->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data satuanbesar tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $satuanbesar->delete();
        return redirect()->back()->with('success', 'Data satuanbesar berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data satuanbesar.');
    }
}

}
