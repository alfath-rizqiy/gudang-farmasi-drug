<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Validator;

class MetodePembayaranController extends Controller
{
    // 🔹 Method untuk menampilkan semua metode pembayaran
    public function index()
    {
        // Ambil semua data metode pembayaran dari database
        $metodes = MetodePembayaran::all();

        // Kembalikan response JSON
        return response()->json([
            'success' => true,
            'data' => $metodes
        ], 200);
    }

    // 🔹 Method untuk menambahkan metode pembayaran baru
    public function store(Request $request)
    {
        // Normalisasi nama_metode (hapus spasi berlebih + trim)
        $request->merge([
            'nama_metode' => (preg_replace('/\s+/', ' ', trim($request->nama_metode)))
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_metode' => 'required|string|unique:metode_pembayarans,nama_metode', // harus unik
            'deskripsi'   => 'required|string',
        ], [
            // Pesan error custom
            'nama_metode.required' => 'Nama metode wajib diisi',
            'nama_metode.unique'   => 'Nama metode sudah terdaftar',
            'deskripsi.required'   => 'Deskripsi metodepembayaran wajib diisi'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Simpan metode pembayaran ke database
        $metode = MetodePembayaran::create($validator->validated());

        // Kembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Metode pembayaran berhasil ditambahkan.',
            'data'    => $metode
        ], 201);
    }

    // 🔹 Method untuk menampilkan detail metode pembayaran berdasarkan ID
    public function show($id)
    {
        // Cari metode pembayaran berdasarkan ID
        $metode = MetodePembayaran::find($id);

        // Jika tidak ditemukan
        if (!$metode) {
            return response()->json([
                'success' => false,
                'message' => 'Metode pembayaran tidak ditemukan.'
            ], 404);
        }

        // Jika ditemukan, kembalikan data
        return response()->json([
            'success' => true,
            'data' => $metode
        ], 200);
    }

    // 🔹 Method untuk mengupdate metode pembayaran
    public function update(Request $request, $id)
    {
        // Validasi input (nama_metode max 100 karakter, wajib diisi)
        $validator = Validator::make($request->all(), [
            'nama_metode' => 'required|string|max:100',
            'deskripsi'   => 'required|string',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Cari metode pembayaran berdasarkan ID
        $metode = MetodePembayaran::find($id);

        // Jika tidak ditemukan
        if (!$metode) {
            return response()->json([
                'success' => false,
                'message' => 'Metode pembayaran tidak ditemukan.'
            ], 404);
        }

        // Update data metode pembayaran
        $metode->update($validator->validated());

        // Kembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Metode pembayaran berhasil diupdate.',
            'data'    => $metode
        ], 200);
    }

    // 🔹 Method untuk menghapus metode pembayaran
    public function destroy($id)
    {
        // Cari metode pembayaran berdasarkan ID
        $metode = MetodePembayaran::find($id);

        // Jika tidak ditemukan
        if (!$metode) {
            return response()->json([
                'success' => false,
                'message' => 'Data metode pembayaran tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 404);
        }

        // Hapus data metode pembayaran
        $metode->delete();

        // Kembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Metode pembayaran berhasil dihapus.'
        ], 200);
    }
}
