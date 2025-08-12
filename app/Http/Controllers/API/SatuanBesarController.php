<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SatuanBesar;
use Illuminate\Support\Facades\Validator;

class SatuanBesarController extends Controller
{
    // Tampilkan satuanbesar
    public function index()
    {
        $satuanbesars = SatuanBesar::all();
        return response()->json([
            'success' => true,
            'data' => $satuanbesars
        ], 200);
    }

    // Input satuanbesar
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_satuanbesar' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jumlah_satuankecil' => 'required|string',
        ]);


        // satuanbesar tidak valid
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'validasi error',
                'errors'=> $validator->errors()
            ], 422);
        }

        // satuanbesar valid
        $satuanbesar = SatuanBesar::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Satuan Besar berhasil ditambahkan.',
            'data'    => $satuanbesar
        ], 201);
    }


    // Tampilkan detail
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

    // Update satuanbesar
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_satuanbesar' => 'required|string',
            'deskripsi' => 'nullable|string',
            'jumlah_satuankecil' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }
        
        $satuanbesar = SatuanBesar::find($id);

        if (!$satuanbesar) {
            return response()->json([
                'success' => false,
                'message' => 'Satuan Besar tidak ditemukan.'
            ], 404);
        }

        $satuanbesar->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Satuan Besar berhasil diupdate.',
            'data'    => $satuanbesar
        ], 200);

    }

    // Hapus satuanbesar
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
