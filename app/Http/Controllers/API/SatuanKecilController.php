<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SatuanKecil;

class SatuanKecilController extends Controller
{
    // GET /api/suppliers
    public function index()
    {
        $satuankecil = SatuanKecil::all();
        return response()->json([
            'success' => true,
            'data' => $satuankecil
        ], 200); 
    }

    // POST /api/suppliers
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_satuankecil' => 'required|string',
            'deskripsi' => 'nullable|string', 
        ]);

        // Simpan data
        $satuankecil = SatuanKecil::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Satuan Kecil berhasil ditambahkan.',
            'data'    => $satuankecil
        ], 201);
    }

    // GET /api/suppliers/{id}
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

    // PUT /api/suppliers/{id}
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_satuankecil' => 'required|string',
            'deskripsi' => 'nullable|string', 
        ]);

        // Update data
        $satuankecil = SatuanKecil::find($id);

        if (!$satuankecil) {
            return response()->json([
                'success' => false,
                'message' => 'Satuan Kecil tidak ditemukan.'
            ], 404);
        }


        $satuankecil->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Satuan Kecil berhasil diupdate.',
            'data'    => $satuankecil
        ], 200);
    }

    // DELETE /api/suppliers/{id}
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