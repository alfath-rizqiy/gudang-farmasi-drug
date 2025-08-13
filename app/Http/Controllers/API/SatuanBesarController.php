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
            'nama_satuanbesar' => 'required|string|unique:satuan_besars,nama_satuanbesar',
            'deskripsi' => 'required|string',
            'jumlah_satuankecil' => 'required|string,',
        ], [
            'nama_satuanbesar.required' => 'Nama satuan besar wajib diisi',
            'nama_satuanbesar.unique' => 'Nama satuan besar sudah terdaftar',
            'deskripsi.required' => 'Deskripsi satuan besar wajib diisi',
            'jumlah_satuankecil.required' => 'Jumlah satuan kecil wajib diisi'
        ]);


        // satuanbesar tidak valid
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'validasi error',
                'errors'=> $validator->errors()
            ], 422);
        }

         $satuanbesar = SatuanBesar::create($validator->validated());

        // satuanbesar valid
        $satuanbesar = SatuanBesar::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'satuanbesar berhasil ditambahkan.',
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
                'message' => 'satuanbesar tidak ditemukan.'
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
            'nama_satuanbesar' => 'required|string|unique:satuan_besars,nama_satuanbesar,' . $id,
            'deskripsi'       => 'required|string',
            'jumlah_satuankecil' => 'required|string,',
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
                'message' => 'satuanbesar tidak ditemukan.'
            ], 404);
        }

        $satuanbesar->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'satuanbesar berhasil diupdate.',
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
                'message' => 'satuanbesar tidak ditemukan.'
            ], 404);
        }

        if ($satuanbesar->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data satuanbesar tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 409); // 409 Conflict
        }

        $satuanbesar->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data satuanbesar berhasil dihapus.'
        ], 200);
    }
}