<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SatuanKecil;
use Illuminate\Support\Facades\Validator;

class SatuanKecilController extends Controller
{
    // Tampilkan semua satuankecil
    public function index()
    {
        $satuankecil = SatuanKecil::all();
        return response()->json([
            'success' => true,
            'data' => $satuankecil
        ], 200);
    }

    // Tambah satuan kecil baru
    public function store(Request $request)
{
    
        // 🔧 Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_satuankecil' => (preg_replace('/\s+/', ' ', trim($request->nama_satuankecil)))
        ]);

    $validator = Validator::make($request->all(), [
        'nama_satuankecil'    => 'required|string|unique:satuan_kecils,nama_satuankecil',
        'deskripsi'           => 'required|string',
    ], [
        'nama_satuankecil.required' => 'Nama satuankecil wajib diisi.',
        'nama_satuankecil.unique'   => 'Nama satuankecil sudah digunakan.',
        'deskripsi.required'        => 'Deskripsi wajib diisi.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => 'Validasi error',
            'errors'  => $validator->errors()
        ], 422);
    }

    $satuankecil = SatuanKecil::create($validator->validated());

    return response()->json([
        'success' => true,
        'message' => 'Satuan kecil berhasil ditambahkan.',
        'data'    => $satuankecil
    ], 201);
}


    // Tampilkan detail satuan kecil
    public function show($id)
    {
        $satuankecil = SatuanKecil::with('obats')->find($id);

        if (!$satuankecil) {
            return response()->json([
                'success' => false,
                'message' => 'Satuan kecil tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $satuankecil
        ], 200);
    }

    // Update satuan kecil
    public function update(Request $request, $id)
{
    // 🔧 Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_satuankecil' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_satuankecil)))
        ]);

    $validator = Validator::make($request->all(), [
        'nama_satuankecil' => 'required|string|unique:satuan_kecils,nama_satuankecil,' . $id,
        'deskripsi'           => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => 'Validasi error',
            'errors'  => $validator->errors()
        ], 422);
    }

    $satuankecil = SatuanKecil::find($id);

    if (!$satuankecil) {
        return response()->json([
            'success' => false,
            'message' => 'Satuan kecil tidak ditemukan.'
        ], 404);
    }

    $satuankecil->update($validator->validated());

    return response()->json([
        'success' => true,
        'message' => 'Satuan kecil berhasil diupdate.',
        'data'    => $satuankecil
    ], 200);
}


    // Hapus satuan kecil
    public function destroy($id)
    {
        $satuankecil = SatuanKecil::find($id);

        if (!$satuankecil) {
            return response()->json([
                'success' => false,
                'message' => 'Satuan kecil tidak ditemukan.'
            ], 404);
        }

        if ($satuankecil->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data satuan kecil tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 409);
        }

        $satuankecil->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data satuan kecil berhasil dihapus.'
        ], 200);
    }
}