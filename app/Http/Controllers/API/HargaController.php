<?php  

namespace App\Http\Controllers\Api;  

use App\Http\Controllers\Controller;  
use Illuminate\Http\Request;  
use App\Models\Harga;  
use App\Models\Obat;  
use Illuminate\Support\Facades\Validator;  

class HargaController extends Controller  
{     
    /** 🔹 Ambil semua data harga (untuk DataTables) */     
    public function index()  
    {     
        // Ambil harga terbaru per obat     
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

    /** 🔹 Simpan harga baru */     
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

    /** 🔹 Detail harga */     
    public function show($id)  
    {     
        $harga = Harga::with("obat")->findOrFail($id);  

        // Ambil semua riwayat harga obat ini     
        $riwayat = Harga::where("obat_id", $harga->obat_id)  
                        ->orderBy("created_at", "desc")  
                        ->get();  

        return response()->json([  
            "obat"    => $harga->obat,  
            "riwayat" => $riwayat  
        ]);  
    }  

    /** 🔹 Update harga (simpan sebagai riwayat baru) */  
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

        $harga_jual = $request->harga_pokok + ($request->margin ?? 0);  

        // 👉 Insert record baru, bukan update     
        $newHarga = Harga::create([  
            "obat_id"     => $request->obat_id,  
            "harga_pokok" => $request->harga_pokok,  
            "margin"      => $request->margin ?? 0,  
            "harga_jual"  => $harga_jual,  
        ]);  

        return response()->json([  
            "message" => "Harga obat berhasil diperbarui",  
            "data"    => $newHarga->load("obat")  
        ]);  
    }  

    /** 🔹 Hapus harga */     
    public function destroy(string $id)  
    {         
        try {  
            $harga = Harga::findOrFail($id);  

            if ($harga->obats()->count() > 0) {  
                return redirect()->back()->with('error', 'harga tidak dapat dihapus karena masih digunakan oleh data obat.');  
            }  

            $harga->delete();  
            return redirect()->back()->with('success', 'harga berhasil dihapus.');  

        } catch (\Exception $e) {  
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus harga.');  
        }  
    }  
}
