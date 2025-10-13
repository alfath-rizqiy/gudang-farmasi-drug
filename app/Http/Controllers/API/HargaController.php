<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harga;
use App\Models\Obat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HargaController extends Controller
{
    /**
     * 🔹 Ambil semua data harga (hanya harga terbaru per obat)
     */
    public function index()
    {
        $hargas = Harga::with('obat')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                      ->from('hargas')
                      ->groupBy('obat_id');
            })
            ->latest()
            ->get();

        return response()->json([
            "data" => $hargas
        ]);
    }

    /**
     * 🔹 Simpan harga baru (support desimal)
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

        // pastikan nilai desimal di-format 2 angka di belakang koma
        $hargaPokok = round($request->harga_pokok, 2);
        $margin = round($request->margin ?? 0, 2);
        $hargaJual = round($hargaPokok + $margin, 2);

        $harga = Harga::create([
            "obat_id"     => $request->obat_id,
            "harga_pokok" => $hargaPokok,
            "margin"      => $margin,
            "harga_jual"  => $hargaJual,
        ]);

        return response()->json([
            "message" => "Harga obat berhasil ditambahkan",
            "data"    => $harga->load("obat")
        ]);
    }

    /**
     * 🔹 Detail harga + riwayatnya
     */
    public function show($id)
    {
        $harga = Harga::with("obat")->findOrFail($id);

        $riwayat = Harga::where("obat_id", $harga->obat_id)
                        ->orderBy("created_at", "desc")
                        ->get();

        return response()->json([
            "obat"    => $harga->obat,
            "riwayat" => $riwayat
        ]);
    }

    /**
     * 🔹 Update harga (buat record baru, bukan edit lama)
     */
    public function update(Request $request, $id)
    {
        $old = Harga::findOrFail($id);

        $validator = Validator::make($request->all(), [
            "obat_id"      => "required|exists:obats,id",
            "harga_pokok"  => "required|numeric|min:0",
            "margin"       => "nullable|numeric|min:0",
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first()], 422);
        }

        $hargaPokok = round($request->harga_pokok, 2);
        $margin = round($request->margin ?? 0, 2);
        $hargaJual = round($hargaPokok + $margin, 2);

        $newHarga = Harga::create([
            "obat_id"     => $request->obat_id,
            "harga_pokok" => $hargaPokok,
            "margin"      => $margin,
            "harga_jual"  => $hargaJual,
        ]);

        return response()->json([
            "message" => "Harga obat berhasil diperbarui",
            "data"    => $newHarga->load("obat")
        ]);
    }

    /**
     * 🔹 Hapus harga
     */
    public function destroy($id)
    {
        try {
            $harga = Harga::findOrFail($id);

            // misalnya kamu mau cegah hapus harga yang masih terkait dengan obat
            if ($harga->obat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harga ini masih terkait dengan obat dan tidak bisa dihapus.'
                ], 400);
            }

            $harga->delete();

            return response()->json([
                'success' => true,
                'message' => 'Harga berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus harga',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
