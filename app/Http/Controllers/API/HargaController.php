<?php  

namespace App\Http\Controllers\Api;  

use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;  
use App\Models\Harga;  
use Illuminate\Support\Facades\Validator;  

class HargaController extends Controller  
{     
    /** 
     * 🔹 Ambil semua data harga terbaru untuk tiap obat
     * Digunakan oleh DataTables di tampilan utama.
     * Mengambil data harga dengan ID terbesar (harga terbaru per obat).
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
     * 🔹 Simpan harga baru
     * Melakukan validasi input, menghitung otomatis PPN dan harga jual,
     * lalu menyimpan data harga baru ke tabel `hargas`.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            "obat_id"      => "required|exists:obats,id",
            "harga_pokok"  => "required|numeric|min:0",
            "margin"       => "nullable|numeric|min:0",
            "ppn"          => "nullable|numeric|min:0", // ✅ validasi kolom PPN
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first()], 422);
        }

        // Hitung PPN otomatis jika tidak dikirim dari frontend (11%)
        $ppn = $request->ppn ?? 0.11 * $request->harga_pokok;

        // Hitung harga jual = harga pokok + margin + ppn
        $harga_jual = $request->harga_pokok + ($request->margin ?? 0) + $ppn;

        // Simpan ke database
        $harga = Harga::create([
            "obat_id"     => $request->obat_id,
            "harga_pokok" => $request->harga_pokok,
            "margin"      => $request->margin ?? 0,
            "ppn"         => $ppn,
            "harga_jual"  => $harga_jual,
        ]);

        return response()->json([
            "message" => "Harga obat berhasil ditambahkan",
            "data"    => $harga->load("obat")
        ]);
    }

    /**
     * 🔹 Tampilkan detail harga dan seluruh riwayat per obat
     * Ditampilkan di modal "Detail Harga".
     */
    public function show($id)
    {
        // Ambil data harga berdasarkan ID
        $harga = Harga::with("obat")->findOrFail($id);

        // Ambil semua riwayat harga berdasarkan obat_id
        $riwayat = Harga::where("obat_id", $harga->obat_id)
                        ->orderBy("created_at", "desc")
                        ->get();

        return response()->json([
            "obat"    => $harga->obat,
            "riwayat" => $riwayat
        ]);
    }

    /**
     * 🔹 Update harga (dengan membuat record baru)
     * Setiap update tidak mengubah data lama, tapi menambah versi harga baru.
     */
    public function update(Request $request, $id)
    {
        $old = Harga::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            "obat_id"      => "required|exists:obats,id",
            "harga_pokok"  => "required|numeric|min:0",
            "margin"       => "nullable|numeric|min:0",
            "ppn"          => "nullable|numeric|min:0", // ✅ validasi kolom PPN
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first()], 422);
        }

        // Hitung PPN otomatis jika tidak diisi
        $ppn = $request->ppn ?? 0.11 * $request->harga_pokok;

        // Hitung total harga jual
        $harga_jual = $request->harga_pokok + ($request->margin ?? 0) + $ppn;

        // Simpan versi harga baru
        $newHarga = Harga::create([
            "obat_id"     => $request->obat_id,
            "harga_pokok" => $request->harga_pokok,
            "margin"      => $request->margin ?? 0,
            "ppn"         => $ppn,
            "harga_jual"  => $harga_jual,
        ]);

        return response()->json([
            "message" => "Harga obat berhasil diperbarui",
            "data"    => $newHarga->load("obat")
        ]);
    }

    /**
     * 🔹 Hapus harga berdasarkan ID
     * Menghapus satu record harga dari tabel `hargas`.
     */
    public function destroy($id)
    {
        try {
            $harga = Harga::findOrFail($id);

            $harga->delete();

            return response()->json([
                'success' => true,
                'message' => 'Harga berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            // Tangani error jika terjadi kegagalan saat hapus
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus harga',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
