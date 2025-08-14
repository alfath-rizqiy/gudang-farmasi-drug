<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $kategoris = Kategori::all();

        return response()->json([
            'success' => true,
            'data' => $kategoris
        ], 200);
    }

    // Tambah kategori baru
   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama_kategori' => 'required|string|unique:kategoris,nama_kategori',
        'deskripsi' => 'required|string',
    ], [
        'nama_kategori.required' => 'Nama kategori wajib diisi',
        'nama_kategori.unique' => 'Nama kategori sudah terdaftar',
        'deskripsi.required' => 'Deskripsi kategori wajib diisi'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi error',
            'errors'  => $validator->errors()
        ], 422);
}

        $kategori = Kategori::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.',
            'data'    => $kategori
        ], 201);
    }

    // Detail kategori
    public function show($id)
    {
        $kategori = Kategori::all();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $kategori
        ], 200);
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori',
            'deskripsi'     => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        $kategori->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate.',
            'data'    => $kategori
        ], 200);
    }

    // Hapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan.'
            ], 404);
        }

        if ($kategori->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak bisa dihapus karena masih digunakan oleh data obat.'
            ], 409);
        }

        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.'
        ], 200);
    }
}
