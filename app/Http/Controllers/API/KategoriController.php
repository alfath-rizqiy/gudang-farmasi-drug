<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Menampilkan semua data kategori.
     */
    public function index()
    {
        $kategoris = kategori::all();
        return response()->json([
            'success' => true,
            'data' => $kategoris
        ], 200);
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        return view('kategori.create'); // Tampilkan view form create
    }

    /**
     * Menyimpan data kategori baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'nama_kategori' => 'required|string',
            'deskripsi' => 'nullable|string', 
        ]);

        // Simpan data ke tabel kategori
        Kategori::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail kategori berdasarkan ID.
     */
    public function show(string $id)
    {
        // Ambil data kategori beserta relasi obats
        $kategori = Kategori::with('obats')->findOrFail($id);

        // Tampilkan ke view show
        return view('kategori.show', compact('kategori'));
    }

    /**
     * Menampilkan form edit untuk kategori tertentu.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id); // Ambil data kategori berdasarkan ID
        return view('kategori.edit', compact('kategori')); // Tampilkan ke view edit
    }

    /**
     * Mengupdate data kategori berdasarkan ID.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input dari form
        $request->validate([
            'nama_kategori' => 'required|string',
            'deskripsi' => 'nullable|string', 
        ]);

        // Ambil data kategori dan update dengan input baru
        $kategori = Kategori::findOrFail($id);
        $kategori->update($request->only(['nama_kategori', 'deskripsi']));

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Menghapus data kategori berdasarkan ID.
     */
    public function destroy(string $id)
{
    try {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori masih punya relasi obat
        if ($kategori->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Metode pembayaran tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $kategori->delete();
        return redirect()->back()->with('success', 'Metode pembayaran berhasil dihapus.');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus metode pembayaran.');
    }
}
}
