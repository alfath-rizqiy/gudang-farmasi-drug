<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;

class ObatController extends Controller
{
    // Ambil semua data obat
    public function index()
    {
        $obats = Obat::with([
            'supplier',
            'kemasan',
            'aturanpakai',
            'satuankecil',
            'satuanbesar',
            'kategori',
            'metodepembayaran'
        ])->get();

        return response()->json($obats);
    }

    // Tambah data obat baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'kemasan_id' => 'required|exists:kemasans,id',
            'aturanpakai_id' => 'required|exists:aturan_pakais,id',
            'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
            'satuan_besar_id' => 'required|exists:satuan_besars,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
        ]);

        $obat = Obat::create($validated);

        return response()->json([
            'message' => 'Obat berhasil ditambahkan',
            'data' => $obat
        ], 201);
    }

    // Detail 1 data obat
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

    // Update data obat
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'kemasan_id' => 'required|exists:kemasans,id',
            'aturanpakai_id' => 'required|exists:aturan_pakais,id',
            'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
            'satuan_besar_id' => 'required|exists:satuan_besars,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($validated);

        return response()->json([
            'message' => 'Obat berhasil diperbarui',
            'data' => $obat
        ]);
    }

    // Hapus data obat
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return response()->json([
            'message' => 'Obat berhasil dihapus'
        ]);
    }
}
