<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kemasan;
use Illuminate\Support\Facades\Validator;

class KemasanController extends Controller
{
    // GET /api/kemasans
    public function index()
    {
        $kemasans = Kemasan::all();
        return response()->json([
            'success' => true,
            'data' => $kemasans
        ], 200);
    }

    // POST /api/kemasans
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kemasan'         => 'required|string',
            'tanggal_produksi'     => 'required|date',
            'tanggal_kadaluarsa'   => 'required|date',
            'petunjuk_penyimpanan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'=> false,
                'message'=> 'Validasi error',
                'errors'=> $validator->errors()
            ], 422);
        }

        $kemasan = Kemasan::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kemasan berhasil ditambahkan.',
            'data'    => $kemasan
        ], 201);
    }

    // GET /api/kemasans/{id}
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

    // PUT /api/kemasans/{id}
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kemasan'         => 'required|string',
            'tanggal_produksi'     => 'required|date',
            'tanggal_kadaluarsa'   => 'required|date',
            'petunjuk_penyimpanan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success'  => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $kemasan = Kemasan::find($id);

        if (!$kemasan) {
            return response()->json([
                'success' => false,
                'message' => 'Kemasan tidak ditemukan.'
            ], 404);
        }

        $kemasan->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kemasan berhasil diupdate.',
            'data'    => $kemasan
        ], 200);
    }

    // DELETE /api/kemasans/{id}
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
