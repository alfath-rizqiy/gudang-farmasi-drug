<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;

class MetodePembayaranController extends Controller
{
    // GET /api/metodepembayaran
    public function index()
    {
        $metodepembayaran = MetodePembayaran::with('obats')->get();

        return response()->json([
            'success' => true,
            'data' => $metodepembayaran
        ], 200);
    }

    // POST /api/metodepembayaran
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_metodepembayaran' => 'required|string',
            'deskripsi'     => 'nullable|string',
        ]);

        $metodepembayaran = MetodePembayaran::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Metode Pembayaran berhasil ditambahkan.',
            'data'    => $metodepembayaran
        ], 201);
    }

    // GET /api/metodepembayaran/{id}
    public function show($id)
    {
        $metodepembayaran = MetodePembayaran::with('obats')->find($id);

        if (!$metodepembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Metode Pembayaran tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $metodepembayaran
        ], 200);
    }

    // PUT /api/metodepembayaran/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_metodepembayaran' => 'required|string',
            'deskripsi'     => 'nullable|string',
        ]);

        $metodepembayaran = MetodePembayaran::find($id);

        if (!$metodepembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Metode Pembayaran tidak ditemukan.'
            ], 404);
        }

        $metodepembayaran->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Metode Pembayaran berhasil diupdate.',
            'data'    => $metodepembayaran
        ], 200);
    }

    // DELETE /api/metodepembayaran/{id}
    public function destroy($id)
    {
        $metodepembayaran = MetodePembayaran::find($id);

        if (!$metodepembayaran) {
            return response()->json([
                'success' => false,
                'message' => 'Metode Pembayaran tidak ditemukan.'
            ], 404);
        }

        if ($metodepembayaran->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Metode Pembayaran tidak bisa dihapus karena masih digunakan oleh data obat.'
            ], 409);
        }

        $metodepembayaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Metode Pembayaran berhasil dihapus.'
        ], 200);
    }
}
