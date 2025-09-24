<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\Obat;
use Illuminate\Support\Facades\Validator;

class HargaController extends Controller
{
    /**
     * 🔹 Ambil semua data harga (untuk DataTables)
     */
    public function index()
    {
        $hargas = Harga::with('obat')->latest()->get();

        return response()->json([
            "data" => $hargas
        ]);
    }

    /**
     * 🔹 Simpan harga baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "obat_id"      => "required|exists:obats,id",
            "harga_pokok"  => "required|numeric|min:0",
            "margin"       => "nullable|numeric|min:0",
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first()], 422);
        }

        $harga_jual = $request->harga_pokok + ($request->margin ?? 0);

        $harga = Harga::create([
            "obat_id"     => $request->obat_id,
            "harga_pokok" => $request->harga_pokok,
            "margin"      => $request->margin ?? 0,
            "harga_jual"  => $harga_jual,
        ]);

        return response()->json([
            "message" => "Harga obat berhasil ditambahkan",
            "data"    => $harga->load("obat")
        ]);
    }

    /**
     * 🔹 Detail harga
     */
    public function show($id)
    {
        $harga = Harga::with("obat")->findOrFail($id);

        return response()->json($harga);
    }

    /**
     * 🔹 Update harga
     */
    public function update(Request $request, $id)
    {
        $harga = Harga::findOrFail($id);

        $validator = Validator::make($request->all(), [
            "obat_id"      => "required|exists:obats,id",
            "harga_pokok"  => "required|numeric|min:0",
            "margin"       => "nullable|numeric|min:0",
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first()], 422);
        }

        $harga_jual = $request->harga_pokok + ($request->margin ?? 0);

        $harga->update([
            "obat_id"     => $request->obat_id,
            "harga_pokok" => $request->harga_pokok,
            "margin"      => $request->margin ?? 0,
            "harga_jual"  => $harga_jual,
        ]);

        return response()->json([
            "message" => "Harga obat berhasil diperbarui",
            "data"    => $harga->load("obat")
        ]);
    }

    /**
     * 🔹 Hapus harga
     */
    public function destroy($id)
    {
        $harga = Harga::findOrFail($id);
        $harga->delete();

        return response()->json([
            "message" => "Harga obat berhasil dihapus"
        ]);
    }
}