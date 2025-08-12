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
        $validator = Validator::make($request->all(),[
            'nama_satuankecil' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);


        // satuankecil tidak valid
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'validasi error',
                'errors'=> $validator->errors()
            ], 422);
        }

        // satuankecil valid
        $satuankecil = SatuanKecil::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Satuan Kecil berhasil ditambahkan.',
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
                'message' => 'Satuan Kecil tidak ditemukan.'
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
        $validator = Validator::make($request->all(), [
            'nama_satuankecil' => 'required|string',
            'deskripsi'       => 'nullable|string',
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
                'message' => 'Satuan Kecil tidak ditemukan.'
            ], 404);
        }

        $satuankecil->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Satuan Kecil berhasil diupdate.',
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
                'message' => 'Satuan Kecil tidak ditemukan.'
            ], 404);
        }

        if ($satuankecil->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data Satuan Kecil tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 409); // 409 Conflict
        }

        $satuankecil->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Satuan Kecil berhasil dihapus.'
        ], 200);
    }
}
