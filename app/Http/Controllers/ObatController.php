<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Supplier;
use App\Models\Kemasan;
use App\Models\AturanPakai;


class ObatController extends Controller
{
       /**
     * Menampilkan semua data obat.
     * Mengambil relasi dengan supplier, kemasan, dan aturan pakai.
     * Catatan: hanya pemanggilan terakhir yang digunakan, jadi perlu digabung.
     */
    public function index()
    {
       $obats = Obat::with(['supplier', 'kemasan', 'aturanpakai'])->get();

        return view('obat.index', compact('obats')); 
    }

     /**
     * Menampilkan form untuk membuat data obat baru.
     * Mengambil semua data supplier, kemasan, dan aturan pakai untuk dropdown.
     */
    public function create()
    {
        return view('obat.create', [
        'suppliers' => Supplier::all(),
        'kemasans' => Kemasan::all(),
        'aturan_pakais' => AturanPakai::all(),

    ]);
    }

   /**
     * Menyimpan data obat baru ke database.
     * Validasi input, lalu simpan menggunakan mass assignment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'nama_obat' => 'required|string|max:255',
        'supplier_id' => 'required|exists:suppliers,id',
        'kemasan_id' => 'required|exists:kemasans,id',
        'aturanpakai_id' => 'required|exists:aturan_pakais,id',
        ]);


        // Menyimpan data obat ke database
        Obat::create([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
            'kemasan_id' => $request->kemasan_id,
            'aturanpakai_id' => $request->aturanpakai_id,
        ]);

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
    ])->findOrFail($id);

    return view('obat.show', compact('obat'));
    }

   /**
     * Menampilkan form edit untuk data obat tertentu.
     * Mengambil data relasi untuk dropdown agar bisa diubah.
     */
    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        $suppliers = Supplier::all();
        $kemasans = Kemasan::all();
        $aturan_pakais = AturanPakai::all();

        return view('obat.edit', compact('obat', 'suppliers', 'kemasans', 'aturan_pakais'));
    }

    /**
     * Memperbarui data obat berdasarkan ID.
     * Validasi input, lalu update data dengan field yang diperlukan.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nama_obat' => 'required|string|max:255',
        'supplier_id' => 'required|exists:suppliers,id',
        'kemasan_id' => 'required|exists:kemasans,id',
        'aturanpakai_id' => 'required|exists:aturan_pakais,id',
    ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
            'kemasan_id' => $request->kemasan_id,
            'aturanpakai_id' => $request->aturanpakai_id,
        ]);

        return redirect()->route('obat.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Menghapus data obat berdasarkan ID.
     */
    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('obat.index')->with('success', 'Data berhasil dihapus.');

    }
}
