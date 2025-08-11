<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kemasan;

class KemasanController extends Controller
{
    // GET /api/kemasan
    public function index()
    {
        $kemasan = Kemasan::with('obats')->get();
        return response()->json([
            'success' => true,
            'data' => $kemasan
        ], 200);
    }

    // POST /api/kemasan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kemasan'         => 'required|string',
            'tanggal_produksi'     => 'required|date',
            'tanggal_kadaluarsa'   => 'required|date',
            'petunjuk_penyimpanan' => 'required|string',
        ]);

        $kemasan = Kemasan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kemasan berhasil ditambahkan.',
            'data'    => $kemasan
        ], 201);
    }

    // GET /api/kemasan/{id}
    public function show($id)
    {
        $kemasan = Kemasan::with('obats')->find($id);

        if (!$kemasan) {
            return response()->json([
                'success' => false,
                'message' => 'Kemasan tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $kemasan
        ], 200);
    }

    // PUT /api/kemasan/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kemasan'         => 'required|string',
            'tanggal_produksi'     => 'required|date',
            'tanggal_kadaluarsa'   => 'required|date',
            'petunjuk_penyimpanan' => 'required|string',
        ]);

        $kemasan = Kemasan::find($id);

        if (!$kemasan) {
            return response()->json([
                'success' => false,
                'message' => 'Kemasan tidak ditemukan.'
            ], 404);
        }

        $kemasan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kemasan berhasil diupdate.',
            'data'    => $kemasan
        ], 200);
    }

    // DELETE /api/kemasan/{id}
    public function destroy($id)
    {
        $kemasan = Kemasan::find($id);

        if (!$kemasan) {
            return response()->json([
                'success' => false,
                'message' => 'Kemasan tidak ditemukan.'
            ], 404);
        }

        if ($kemasan->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data kemasan tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 409); 
        }

        $kemasan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data kemasan berhasil dihapus.'
        ], 200);
    }
}