<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // 🔹 Method untuk menampilkan semua data kategori
    public function index()
    {
        // Ambil semua data kategori dari database
        $kategoris = Kategori::all();

        // Kembalikan response dalam bentuk JSON
        return response()->json([
            'success' => true,
            'data' => $kategoris
        ], 200);
    }

    // 🔹 Method untuk menambahkan kategori baru
    public function store(Request $request)
    {
        // Normalisasi nama_kategori (hapus spasi berlebih, trim, ubah ke lowercase)
        $request->merge([
            'nama_kategori' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_kategori)))
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori', // harus unik
            'deskripsi' => 'required|string',
        ], [
            // Pesan error custom
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah terdaftar',
            'deskripsi.required' => 'Deskripsi kategori wajib diisi'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Simpan kategori baru ke database
        $kategori = Kategori::create($validator->validated());

        // Kembalikan response JSON sukses
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.',
            'data'    => $kategori
        ], 201);
    }

    // 🔹 Method untuk menampilkan detail kategori berdasarkan ID
    public function show($id)
    {
        // Cari kategori berdasarkan ID
        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        // Jika ditemukan, kembalikan data kategori
        return response()->json([
            'success' => true,
            'data' => $kategori
        ], 200);
    }

    // 🔹 Method untuk mengupdate kategori
    public function update(Request $request, $id)
    {
        // Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_kategori' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_kategori)))
        ]); 

        // Validasi input (unique tapi mengecualikan ID saat ini)
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori,' . $id,
            'deskripsi'     => 'required|string',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Cari kategori berdasarkan ID
        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        // Update data kategori
        $kategori->update($validator->validated());

        // Kembalikan response JSON sukses
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate.',
            'data'    => $kategori
        ], 200);
    }

    // 🔹 Method untuk menghapus kategori
    public function destroy($id)
    {
        // Cari kategori berdasarkan ID
        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        // Cek apakah kategori masih dipakai oleh data obat
        if ($kategori->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak bisa dihapus karena masih digunakan oleh data obat.'
            ], 409);
        }

        // Hapus kategori
        $kategori->delete();

        // Kembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.'
        ], 200);
    }
}
