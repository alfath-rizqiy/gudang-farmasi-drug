<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Harga;
use Illuminate\Http\Request;

class HargaController extends Controller
{
    /**
     * Tampilkan daftar harga obat
     */
    public function index()
    {
        // Ambil data harga terbaru per obat
        $obats = Obat::with(['hargaTerbaru'])->get();

        // Semua role diarahkan ke view yang sama
        return view('harga.index', compact('obats'));
    }

    public function create()
    {
        return view('harga.create');
    }

    /**
     * Simpan harga baru untuk obat (khusus admin/petugas)
     */
    public function store(Request $request, $obat_id)
    {
        $request->validate([
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

        Harga::create([
            'obat_id'     => $obat->id,
            'harga_pokok' => $request->harga_pokok,
            'margin'      => $request->margin,
            'harga_jual'  => $request->harga_pokok + $request->margin,
        ]);

        return redirect()->route('harga.index')->with('success', 'Harga obat berhasil ditambahkan.');
    }

    /**
     * Detail harga per obat
     */
    public function show($obat_id)
    {
        $obat = Obat::with(['hargaTerbaru'])->findOrFail($obat_id);

        // Tetap 1 view saja
        return view('harga.show', compact('obat'));
    }
}