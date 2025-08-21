<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Validator;

class MetodePembayaranController extends Controller
{
    // Tampilkan semua metode pembayaran
    public function index()
    {
        $metodes = MetodePembayaran::all();

        return response()->json([
            'success' => true,
            'data' => $metodes
        ], 200);
    }

    // Tambah metode pembayaran baru
    public function store(Request $request)
    {
        // 🔧 Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_metode' => (preg_replace('/\s+/', ' ', trim($request->nama_metode)))
        ]);

    $validator = Validator::make($request->all(), [
        'nama_metode' => 'required|string|unique:metode_pembayarans,nama_metode',
        'deskripsi' => 'required|string',
    ], [
        'nama_metode.required' => 'Nama metode wajib diisi',
        'nama_metode.unique' => 'Nama metode sudah terdaftar',
        'deskripsi.required' => 'Deskripsi metodepembayaran wajib diisi'
    ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $metode = MetodePembayaran::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Metode pembayaran berhasil ditambahkan.',
            'data'    => $metode
        ], 201);
    }

    // Detail metode pembayaran
    public function show($id)
    {
        $metode = MetodePembayaran::find($id);

        if (!$metode) {
            return response()->json([
                'success' => false,
                'message' => 'Metode pembayaran tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $metode
        ], 200);
    }

    // Update metode pembayaran
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_metode' => 'required|string|max:100',
            'deskripsi'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $metode = MetodePembayaran::find($id);

        if (!$metode) {
            return response()->json([
                'success' => false,
                'message' => 'Metode pembayaran tidak ditemukan.'
            ], 404);
        }

        $metode->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Metode pembayaran berhasil diupdate.',
            'data'    => $metode
        ], 200);
    }

    // Hapus metode pembayaran
    public function destroy($id)
    {
        $metode = MetodePembayaran::find($id);

        if (!$metode) {
            return response()->json([
                'success' => false,
                'message' => 'Data metode pembayaran tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 404);
        }

        $metode->delete();

        return response()->json([
            'success' => true,
            'message' => 'Metode pembayaran berhasil dihapus.'
        ], 200);
    }
}
