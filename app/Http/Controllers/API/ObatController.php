<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
{
    // Tampilkan Obat
    public function index()
    {
        return response()->json([
            'status' => true,
            'code' => 200,
            'data' => 'test'
        ]);
    }

    // Input Obat
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_obat' => 'required|string||unique:obats,nama_obat',
            'supplier_id' => 'required|exists:suppliers,id',
            'kemasan_id' => 'required|exists:kemasans,id',
            'aturanpakai_id' => 'required|exists:aturan_pakais,id',
            'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
            'satuan_besar_id' => 'required|exists:satuan_besars,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
        ], [
            'nama_supplier.required' => 'Nama obat wajib diisi',
            'nama_supplier.unique' => 'Nama obat sudah terdaftar',
        ]);

        // Supplier tidak valid
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'validasi error',
                'errors'=> $validator->errors()
            ], 422);
        }

        $obat = Obat::create($validator->validated());

        $obat= Obat::create($request->all());
        return response()->json([
            'succes' => true,
            'message' => 'Obat berhasil ditambahkan',
            'data' => $obat
        ], 201);
    }

    // Tampilkan detail
    public function show($id)
    {
        $obat = Obat::with([
            'supplier',
            'kemasan',
            'aturanpakai',
            'satuankecil',
            'satuanbesar',
            'kategori',
            'metodepembayaran'
        ])->findOrFail($id);

        return response()->json($obat);
    }

    // Update Obat
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255|unique:obats,nama_obat,' . $id,
            'supplier_id' => 'required|exists:suppliers,id',
            'kemasan_id' => 'required|exists:kemasans,id',
            'aturanpakai_id' => 'required|exists:aturan_pakais,id',
            'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
            'satuan_besar_id' => 'required|exists:satuan_besars,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $obat = Obat::findOrFail($id);

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier tidak ditemukan.'
            ], 404);
        }

        $obat->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil diupdate.',
            'data'    => $supplier
        ], 200);
    }

    // Hapus Obat
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return response()->json([
            'message' => 'Obat berhasil dihapus'
        ]);
    }
}
