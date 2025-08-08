<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SatuanBesar;

class SatuanBesarController extends Controller
{
    // GET /api/satuan_besars
    public function index()
    {
        $satuanbesar = SatuanBesar::all();
        return response()->json([
            'success' => true,
            'data' => $satuanbesar
        ], 200); 
    }

    // POST /api/satuan_besars
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_satuanbesar' => 'required|string',
            'deskripsi' => 'nullable|string', 
            'jumlah_satuankecil' => 'required|string',
        ]);

        // Simpan data
        $satuanbesar = SatuanBesar::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Satuan Besar berhasil ditambahkan.',
            'data'    => $satuanbesar
        ], 201);
    }

    // GET /api/satuan_besars/{id}
    public function show($id)
    {
        $satuanbesar = SatuanBesar::with('obats')->find($id);

        if (!$satuanbesar) {
            return response()->json([
                'success' => false,
                'message' => 'Satuan Besar tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $satuanbesar
        ], 200);
    }

    // PUT /api/satuan_besars/{id}
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_satuanbesar' => 'required|string',
            'deskripsi' => 'nullable|string', 
            'jumlah_satuankecil' => 'required|string',
        ]);

        // Update data
        $satuanbesar = SatuanBesar::find($id);

        if (!$satuanbesar) {
            return response()->json([
                'success' => false,
                'message' => 'Satuan Besar tidak ditemukan.'
            ], 404);
        }


        $satuanbesar->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Satuan Besar berhasil diupdate.',
            'data'    => $satuanbesar
        ], 200);
    }

    // DELETE /api/satuan_besars/{id}
     public function destroy($id)
    {
        $satuanbesar = SatuanBesar::find($id);

        if (!$satuanbesar) {
            return response()->json([
                'success' => false,
                'message' => 'Satuan Besar tidak ditemukan.'
            ], 404);
        }

        if ($satuanbesar->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data Satuan Besar tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 409); // 409 Conflict
        }

        $satuanbesar->delete();


        return response()->json([
            'success' => true,
            'message' => 'Data Satuan Besar berhasil dihapus.'
        ], 200);
    }
}