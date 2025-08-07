<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Supplier;
use App\Models\Kemasan;
use App\Models\AturanPakai;
use App\Models\SatuanKecil;
use App\Models\SatuanBesar;



class ObatController extends Controller
{

    public function index()
    {
       $obats = Obat::with(['supplier', 'kemasan', 'aturanpakai', 'satuankecil', 'satuanbesar'])->get();

        return view('obat.index', compact('obats')); 
    }

    public function create()
    {
        return view('obat.create', [
        'suppliers' => Supplier::all(),
        'kemasans' => Kemasan::all(),
        'aturan_pakais' => AturanPakai::all(),
        'satuan_kecils' => SatuanKecil::all(),
        'satuan_besars' => SatuanBesar::all(),
        ]);
    }
    /**
     * Menyimpan data obat baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
        'nama_obat' => 'required|string|max:255',
        'supplier_id' => 'required|exists:suppliers,id',
        'kemasan_id' => 'required|exists:kemasans,id',
        'aturanpakai_id' => 'required|exists:aturan_pakais,id',
        'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
        'satuan_besar_id' => 'required|exists:satuan_besars,id',
        ]);


        // Menyimpan data obat ke database
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
            'kemasan_id' => $request->kemasan_id,
            'aturanpakai_id' => $request->aturanpakai_id,
            'satuan_kecil_id' => $request->satuan_kecil_id,
            'satuan_besar_id' => $request->satuan_besar_id,
        ]);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'obat berhasil ditambahkan.');
    }

     /**
     * Menampilkan detail dari satu data obat berdasarkan ID.
     * Mengambil relasi dengan supplier, kemasan, dan aturan pakai.
     */
    public function show(string $id)
    {
        $obat = Obat::with([
        'supplier',
        'kemasan',
        'aturanpakai',
        'satuankecil',
        'satuanbesar',
    ])->findOrFail($id);

        // Tampilkan view detail
        return view('obat.show', compact('obat'));
    }

    /**
     * Menampilkan form edit untuk data obat tertentu.
     */
    public function edit(string $id)
    {
        // Ambil data obat dan relasi untuk form edit
        $obat = Obat::findOrFail($id);
        $suppliers = Supplier::all();
        $kemasans = Kemasan::all();
        $aturan_pakais = AturanPakai::all();
        $satuan_kecils = SatuanKecil::all();
        $satuan_besars = SatuanBesar::all();

        return view('obat.edit', compact('obat', 'suppliers', 'kemasans', 'aturan_pakais', 'satuan_kecils', 'satuan_besars'));
    }

    /**
     * Memperbarui data obat berdasarkan ID.
     * Validasi input, lalu update data dengan field yang diperlukan.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
        'nama_obat' => 'required|string|max:255',
        'supplier_id' => 'required|exists:suppliers,id',
        'kemasan_id' => 'required|exists:kemasans,id',
        'aturanpakai_id' => 'required|exists:aturan_pakais,id',
        'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
        'satuan_besar_id' => 'required|exists:satuan_besars,id',
        ]);

        // Update data obat
        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
            'kemasan_id' => $request->kemasan_id,
            'aturanpakai_id' => $request->aturanpakai_id,
            'satuan_kecil_id' => $request->satuan_kecil_id,
            'satuan_besar_id' => $request->satuan_besar_id,
        ]);

        // Redirect ke index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Menghapus data obat berdasarkan ID.
     */
    public function destroy(string $id)
    {
        // Hapus data obat
        $obat = Obat::findOrFail($id);
        $obat->delete();

        // Redirect ke index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'Data berhasil dihapus.');
    }
}
