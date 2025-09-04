<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SatuanKecil;
use Illuminate\Support\Facades\Validator;

class SatuanKecilController extends Controller
{
    // Tampilkan satuankecil
    public function index()
    {
        $satuankecils = SatuanKecil::all();
        return response()->json([
            'success' => true,
            'data' => $satuankecils
        ], 200);
    }

    // Input satuankecil
    public function store(Request $request)
    {
        // 🔧 Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_satuankecil' => (preg_replace('/\s+/', ' ', trim($request->nama_satuankecil)))
        ]);

        $validator = Validator::make($request->all(),[
            'nama_satuankecil' => 'required|string|unique:satuan_kecils,nama_satuankecil',
            'deskripsi' => 'required|string',
        ], [
            'nama_satuankecil.required' => 'Nama satuan kecil wajib diisi',
            'nama_satuankecil.unique' => 'Nama satuan kecil sudah terdaftar',
            'deskripsi.required' => 'Deskripsi satuan kecil wajib diisi',
        ]);


        // satuankecil tidak valid
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'validasi error',
                'errors'=> $validator->errors()
            ], 422);
        }

         $satuankecil = SatuanKecil::create($validator->validated());
        return response()->json([
            'success' => true,
            'message' => 'satuankecil berhasil ditambahkan.',
            'data'    => $satuankecil
        ], 201);
    }


    // Tampilkan detail
    public function show($id)
    {
        $satuankecil = SatuanKecil::with('obats')->find($id);

        if (!$satuankecil) {
            return response()->json([
                'success' => false,
                'message' => 'satuankecil tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $satuankecil
        ], 200);
    }

    // Update satuankecil
    public function update(Request $request, $id)
    {
        // 🔧 Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_satuankecil' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_satuankecil)))
        ]);

        $validator = Validator::make($request->all(), [
            'nama_satuankecil' => 'required|string|unique:satuan_kecils,nama_satuankecil,' . $id,
            'deskripsi'       => 'required|string',
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
                'message' => 'satuankecil tidak ditemukan.'
            ], 404);
        }

        $satuankecil->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'satuankecil berhasil diupdate.',
            'data'    => $satuankecil
        ], 200);

    }

    // Hapus satuankecil
    public function destroy($id)
    {
        $satuankecil = SatuanKecil::find($id);

        if (!$satuankecil) {
            return response()->json([
                'success' => false,
                'message' => 'satuankecil tidak ditemukan.'
            ], 404);
        }

        if ($satuankecil->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data satuankecil tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 409); // 409 Conflict
        }

        $satuankecil->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data satuankecil berhasil dihapus.'
        ], 200);
    }
}