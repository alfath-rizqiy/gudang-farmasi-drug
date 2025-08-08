<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AturanPakai;

class AturanPakaiController extends Controller
{
    // GET /api/aturanpakai
    public function index()
    {
        $aturanpakai = AturanPakai::all();
        return response()->json([
            'success' => true,
            'data' => $aturanpakai
        ], 200);
    }

    // POST /api/aturanpakai
    public function store(Request $request)
    {
        $validated = $request->validate([
            'frekuensi_pemakaian' => 'required|string',
            'waktu_pemakaian'     => 'required|string',
            'deskripsi'           => 'nullable|string',
        ]);

        $aturanpakai = AturanPakai::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Aturan Pakai berhasil ditambahkan.',
            'data'    => $aturanpakai
        ], 201);
    }

    // GET /api/aturanpakai/{id}
    public function show($id)
    {
        $aturanpakai = AturanPakai::with('obats')->find($id);

        if (!$aturanpakai) {
            return response()->json([
                'success' => false,
                'message' => 'Aturan Pakai tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $aturanpakai
        ], 200);
    }

    // PUT /api/aturanpakai/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'frekuensi_pemakaian' => 'required|string',
            'waktu_pemakaian'     => 'required|string',
            'deskripsi'           => 'nullable|string',
        ]);

        $aturanpakai = AturanPakai::find($id);

        if (!$aturanpakai) {
            return response()->json([
                'success' => false,
                'message' => 'Aturan Pakai tidak ditemukan.'
            ], 404);
        }

        $aturanpakai->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Aturan Pakai berhasil diupdate.',
            'data'    => $aturanpakai
        ], 200);
    }

    // DELETE /api/aturanpakai/{id}
    public function destroy($id)
    {
        $aturanpakai = AturanPakai::find($id);

        if (!$aturanpakai) {
            return response()->json([
                'success' => false,
                'message' => 'Aturan Pakai tidak ditemukan.'
            ], 404);
        }

        if ($aturanpakai->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data Aturan Pakai tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 409); 
        }

        $aturanpakai->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Aturan Pakai berhasil dihapus.'
        ], 200);
    }
}
