<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;

class MetodePembayaranController extends Controller
{
    /**
     * Menampilkan semua data metode pembayaran.
     */
    public function index()
    {
        $metodepembayaran = MetodePembayaran::all(); // Ambil semua data dari tabel metode_pembayaran
        return view('metodepembayaran.index', compact('metodepembayaran')); // Tampilkan ke view index
    }

    /**
     * Menampilkan form untuk membuat metode pembayaran baru.
     */
    public function create()
    {
        return view('metodepembayaran.create'); // Tampilkan view form create
    }

    /**
     * Menyimpan data metode pembayaran baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'nama_metode' => 'required|string',
            'deskripsi' => 'nullable|string', 
        ]);

        // Simpan data ke tabel metode_pembayaran
        MetodePembayaran::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('metodepembayaran.index')->with('success', 'metodepembayaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail metode pembayaran berdasarkan ID.
     */
    public function show(string $id)
    {
        // Ambil data metode pembayaran beserta relasi obats (jika ada)
        $metodepembayaran = MetodePembayaran::with('obats')->findOrFail($id);

        // Tampilkan ke view show
        return view('metodepembayaran.show', compact('metodepembayaran'));
    }

    /**
     * Menampilkan form edit untuk metode pembayaran tertentu.
     */
    public function edit(string $id)
    {
        $metodepembayaran = MetodePembayaran::findOrFail($id); // Ambil data berdasarkan ID
        return view('metodepembayaran.edit', compact('metodepembayaran')); // Tampilkan ke view edit
    }

    /**
     * Mengupdate data metode pembayaran berdasarkan ID.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input dari form
        $request->validate([
            'nama_metode' => 'required|string',
            'deskripsi' => 'nullable|string', 
        ]);

        // Ambil data dan update dengan input baru
        $metodepembayaran = MetodePembayaran::findOrFail($id);
        $metodepembayaran->update($request->only(['nama_metode', 'deskripsi']));

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('metodepembayaran.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Menghapus data metode pembayaran berdasarkan ID.
     */
    public function destroy(string $id)
{
    try {
        $metodepembayaran = MetodePembayaran::findOrFail($id);

        // Cek apakah metodepembayaran masih punya relasi obat
        if ($metodepembayaran->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Metode pembayaran tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $metodepembayaran->delete();
        return redirect()->back()->with('success', 'Metode pembayaran berhasil dihapus.');
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus metode pembayaran.');
    }
}
}
