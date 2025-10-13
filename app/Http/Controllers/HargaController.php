<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Harga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HargaController extends Controller
{
    /**
     * 🔹 Tampilkan daftar harga obat (harga terbaru per obat)
     */
    public function index()
    {
        $obats = Obat::with(['hargaTerbaru'])->get();
        return view('harga.index', compact('obats'));
    }

    /**
     * 🔹 Form tambah harga
     */
    public function create()
    {
        $obats = Obat::all();
        return view('harga.create', compact('obats'));
    }

    /**
     * 🔹 Simpan harga baru (admin/petugas)
     */
    public function store(Request $request, $obat_id)
    {
        $validator = Validator::make($request->all(), [
            'harga_pokok' => 'required|numeric|min:0',
            'margin'      => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('harga.index')
                ->withErrors($validator)
                ->withInput();
        }

        $obat = Obat::findOrFail($obat_id);

        // pastikan nilai disimpan dengan dua angka desimal
        $hargaPokok = round($request->harga_pokok, 2);
        $margin = round($request->margin, 2);
        $hargaJual = round($hargaPokok + $margin, 2);

        Harga::create([
            'obat_id'     => $obat->id,
            'harga_pokok' => $hargaPokok,
            'margin'      => $margin,
            'harga_jual'  => $hargaJual,
        ]);

        return redirect()->route('harga.index')->with('success', 'Harga obat berhasil ditambahkan.');
    }

    /**
     * 🔹 Detail harga per obat
     */
    public function show($obat_id)
    {
        $obat = Obat::with(['hargaTerbaru', 'hargas' => function ($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($obat_id);

        return view('harga.show', compact('obat'));
    }

    /**
     * 🔹 Hapus harga
     */
    public function destroy($id)
    {
        try {
            $harga = Harga::findOrFail($id);

            // Pastikan tidak terkait dengan data lain (kalau perlu)
            if ($harga->obat()->exists()) {
                return redirect()->back()->with('error', 'Harga tidak dapat dihapus karena masih digunakan oleh obat.');
            }

            $harga->delete();
            return redirect()->back()->with('success', 'Harga berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus harga.');
        }
    }
}
