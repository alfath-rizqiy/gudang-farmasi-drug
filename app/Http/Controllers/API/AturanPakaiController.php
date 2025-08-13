<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AturanPakai;
use Illuminate\Support\Facades\Validator;

class AturanPakaiController extends Controller
{
    // Tampilkan semua aturan pakai
    public function index()
    {
        $aturanpakai = AturanPakai::all();
        return response()->json([
            'success' => true,
            'data' => $aturanpakai
        ], 200);
    }

    // Tambah aturan pakai baru
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'frekuensi_pemakaian' => 'required|string|unique:aturan_pakais,frekuensi_pemakaian',
        'waktu_pemakaian'     => 'required|string|unique:aturan_pakais,waktu_pemakaian',
        'deskripsi'           => 'nullable|string',
    ], [
        'frekuensi_pemakaian.required' => 'Frekuensi pemakaian wajib diisi.',
        'waktu_pemakaian.required'     => 'Waktu pemakaian wajib diisi.',
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $aturanpakai = AturanPakai::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Aturan pakai berhasil ditambahkan.',
            'data'    => $aturanpakai
        ], 201);
    }

    // Tampilkan detail aturan pakai
    public function show($id)
    {
        $aturanpakai = AturanPakai::with('obats')->find($id);

        if (!$aturanpakai) {
            return response()->json([
                'success' => false,
                'message' => 'Aturan pakai tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $aturanpakai
        ], 200);
    }

    // Update aturan pakai
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'frekuensi_pemakaian' => 'required|string|unique:aturan_pakais,frekuensi_pemakaian,' . $id,
            'waktu_pemakaian'     => 'required|string|unique:aturan_pakais,waktu_pemakaian,' . $id,
            'deskripsi'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $aturanpakai = AturanPakai::find($id);

        if (!$aturanpakai) {
            return response()->json([
                'success' => false,
                'message' => 'Aturan pakai tidak ditemukan.'
            ], 404);
        }

        $aturanpakai->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Aturan pakai berhasil diupdate.',
            'data'    => $aturanpakai
        ], 200);
    }

    // Hapus aturan pakai
    public function destroy($id)
    {
        $aturanpakai = AturanPakai::find($id);

        if (!$aturanpakai) {
            return response()->json([
                'success' => false,
                'message' => 'Aturan pakai tidak ditemukan.'
            ], 404);
        }

        if ($aturanpakai->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data aturan pakai tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 409);
        }

        $aturanpakai->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data aturan pakai berhasil dihapus.'
        ], 200);
    }
}
