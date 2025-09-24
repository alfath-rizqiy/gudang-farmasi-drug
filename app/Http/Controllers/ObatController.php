<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Supplier;
use App\Models\Kemasan;
use App\Models\AturanPakai;
use App\Models\SatuanKecil;
use App\Models\SatuanBesar;
use App\Models\Kategori;
use App\Models\MetodePembayaran;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ObatController extends Controller
{
    
    // Menampilkan View
    public function index()
    {
        return view('obat.index');
    }

    // Membuat Data
    public function create()
    {
        return view('obat.create', [
        'suppliers'          => Supplier::all(),
        'kemasans'           => Kemasan::all(),
        'aturan_pakais'      => AturanPakai::all(),
        'satuan_kecils'      => SatuanKecil::all(),
        'satuan_besars'      => SatuanBesar::all(),
        'kategoris'          => Kategori::all(),
        'metode_pembayarans' => MetodePembayaran::all(),
        ]);
    }

  
    // Menyimpan data obat baru ke database
    public function store(Request $request)
    {
         // Store on default disk
         Excel::store(new ObatExport(2018), 'data-obat.xlsx');

        //  Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_obat' => (preg_replace('/\s+/', ' ', trim($request->nama_obat)))
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
        'nama_obat'           => 'required|string|max:255|unique:obats,nama_obat',
        'foto'                => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'supplier_id'         => 'required|exists:suppliers,id',
        'kemasan_id'          => 'required|exists:kemasans,id',
        'aturanpakai_id'      => 'required|exists:aturan_pakais,id',
        'satuan_kecil_id'     => 'required|exists:satuan_kecils,id',
        'satuan_besar_id'     => 'required|exists:satuan_besars,id',
        'kategori_id'         => 'required|exists:kategoris,id',
        'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi',
            'nama_obat.unique' => 'Nama obat sudah terdaftar'
        ]);

         if ($validator->fails()) {
        return redirect()
            ->route('obat.index') // balik keForm
            ->withErrors($validator) 
            ->withInput(); 
        }

        $foto = $request->file('foto');
        $fileName = Str::uuid() . '.' . $foto->getClientOriginalExtension();

        Storage::disk('public')->putFileAs('foto_obat', $foto, $fileName);

        $newRequest = $request->all();
        $newRequest['foto'] = $fileName;
        
        // Menyimpan data obat ke database
        Obat::create($newRequest);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('obat.index')->with('success', 'obat berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $obat = Obat::with([
        'supplier',
        'kemasan',
        'aturanpakai',
        'satuankecil',
        'satuanbesar',
        'kategori',
        'metodepembayaran',
        'hargaTerbaru',
        'hargaLama'
    ])->findOrFail($id);

        // Tampilkan ke view show
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
        $kategoris = Kategori::all();
        $metode_pembayarans = MetodePembayaran::all(); 

        return view('obat.edit', compact('obat', 'suppliers', 'kemasans', 'aturan_pakais', 'satuan_kecils', 'satuan_besars',  'kategoris', 'metode_pembayarans'));
    }

    /**
     * Memperbarui data obat berdasarkan ID.
     * Validasi input, lalu update data dengan field yang diperlukan.
     */
    public function update(Request $request, string $id)
    {
        $obat = Obat::findOrFail($id);

        // Validasi input
        $request->validate([
        'nama_obat'           => 'required|string|max:255',
        'foto'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'supplier_id'         => 'required|exists:suppliers,id',
        'kemasan_id'          => 'required|exists:kemasans,id',
        'aturanpakai_id'      => 'required|exists:aturan_pakais,id',
        'satuan_kecil_id'     => 'required|exists:satuan_kecils,id',
        'satuan_besar_id'     => 'required|exists:satuan_besars,id',
        'kategori_id'         => 'required|exists:kategoris,id',
        'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
    ]);

        // Default foto lama
        $fotoName = $obat->foto;

        // Kalau ada foto baru
        if ($request->hasFile('foto')) {
        // Hapus foto lama
        if ($obat->foto && Storage::disk('public')->exists('foto_obat/'.$obat->foto)) {
            Storage::disk('public')->delete('foto_obat/'.$obat->foto);
        }

        // Simpan foto baru
        $fotoName = Str::uuid().'.'.$request->foto->extension();
        $request->foto->storeAs('foto_obat', $fotoName);
    }

    // Update data
    $obat->update([
        'nama_obat'           => $request->nama_obat,
        'foto'                => $fotoName,
        'supplier_id'         => $request->supplier_id,
        'kemasan_id'          => $request->kemasan_id,
        'aturanpakai_id'      => $request->aturanpakai_id,
        'satuan_kecil_id'     => $request->satuan_kecil_id,
        'satuan_besar_id'     => $request->satuan_besar_id,
        'kategori_id'         => $request->kategori_id,
        'metodepembayaran_id' => $request->metodepembayaran_id,
    ]);

    // lanjut update
    $obat->update($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil diupdate',
        'data' => $obat
    ]);
    }


    /**
     * Menghapus data obat berdasarkan ID.
     */
    public function destroy(string $id)
    {
        try {
            $obat = Obat::findOrFail($id);
   
            $obat->delete();
            return redirect()->back()->with('success', 'Obat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }

}