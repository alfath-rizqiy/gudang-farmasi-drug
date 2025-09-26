<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Harga;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ObatController extends Controller
{
    // Tampilkan Obat
    public function index()
{
    $obat = Obat::with([
            'supplier:id,nama_supplier',
            'kategori:id,nama_kategori',
            'kemasan:id,nama_kemasan',
            'aturanpakai:id,frekuensi_pemakaian',
            'satuanKecil:id,nama_satuankecil',
            'satuanBesar:id,nama_satuanbesar',
            'metodepembayaran:id,nama_metode',
        ])->get()->map(function($item) {
            return [
            'id' => $item->id,
            'nama_obat' => $item->nama_obat,
            'deskripsi_obat' => $item->deskripsi_obat,
            'stok' => $item->stok,
            'foto' => $item->foto,
            'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
            
            // relasi
            'supplier_id' => $item->supplier->id ?? null,
            'supplier' => $item->supplier->nama_supplier ?? '-',

            'kemasan_id' => $item->kemasan->id ?? null,
            'kemasan' => $item->kemasan->nama_kemasan ?? '-',

            'aturanpakai_id' => $item->aturanpakai->id ?? null,
            'aturanpakai' => $item->aturanpakai->frekuensi_pemakaian ?? '-',

            'satuan_kecil_id' => $item->satuanKecil->id ?? null,
            'satuan_kecil' => $item->satuanKecil->nama_satuankecil ?? '-',

            'satuan_besar_id' => $item->satuanBesar->id ?? null,
            'satuan_besar' => $item->satuanBesar->nama_satuanbesar ?? '-',

            'kategori_id' => $item->kategori->id ?? null,
            'kategori' => $item->kategori->nama_kategori ?? '-',

            'metodepembayaran_id' => $item->metodepembayaran->id ?? null,
            'metode_pembayaran' => $item->metodepembayaran->nama_metode ?? '-',
        ];
    });

    return response()->json([
        'status' => true,
        'data' => $obat
    ]);
}


    // Input Obat
    public function store(Request $request)
    {
        $request->merge([
            'nama_obat' => (preg_replace('/\s+/', ' ', trim($request->nama_obat)))
        ]);

        $validator = Validator::make($request->all(),[
            'nama_obat' => 'required|string|unique:obats,nama_obat',
            'supplier_id' => 'required|exists:suppliers,id',
            'kemasan_id' => 'required|exists:kemasans,id',
            'aturanpakai_id' => 'required|exists:aturan_pakais,id',
            'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
            'satuan_besar_id' => 'required|exists:satuan_besars,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi_obat' => 'required|string',
            'stok' => 'required|integer',
        ], [
            'nama_obat.required' => 'Nama obat wajib diisi',
            'nama_obat.unique' => 'Nama obat sudah terdaftar',
        ]);

        // Supplier tidak valid
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'validasi error',
                'errors'=> $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        
        /// simpan foto kalau ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_obat', 'public');
        }

        $obat = Obat::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil ditambahkan',
            'data' => $obat
        ], 201);

    }

    // Tampilkan detail
    public function show($id)
    {
        $obat = Obat::with([
            'supplier',
            'kemasan',
            'aturanpakai',
            'satuanKecil',
            'satuanBesar',
            'kategori',
            'metodepembayaran'
        ])->findOrFail($id);

        return response()->json($obat);
    }

    // Update Obat
    public function update(Request $request, $id)
    {
        $request->merge([
            'nama_obat' => preg_replace('/\s+/', ' ', trim($request->nama_obat))
        ]);

        $validator = Validator::make($request->all(), [
            'nama_obat' => 'required|string|max:255|unique:obats,nama_obat,' . $id,
            'supplier_id' => 'required|exists:suppliers,id',
            'kemasan_id' => 'required|exists:kemasans,id',
            'aturanpakai_id' => 'required|exists:aturan_pakais,id',
            'satuan_kecil_id' => 'required|exists:satuan_kecils,id',
            'satuan_besar_id' => 'required|exists:satuan_besars,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'metodepembayaran_id' => 'required|exists:metode_pembayarans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // tambahin validasi harga juga
        'harga_pokok' => 'nullable|numeric|min:0',
        'margin'      => 'nullable|numeric|min:0',
        'harga_jual'  => 'nullable|numeric|min:0',
            'deskripsi_obat' => 'required|string',
            'stok' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $obat = Obat::findOrFail($id);

        if (!$obat) {
            return response()->json([
                'success' => false,
                'message' => 'obat tidak ditemukan.'
            ], 404);
        }

        $data = $validator->validated();

        // Update foto jika ada file baru
    if ($request->hasFile('foto')) {
        // hapus foto lama
        if ($obat->foto && Storage::disk('public')->exists($obat->foto)) {
            Storage::disk('public')->delete($obat->foto);
        }

        // simpan foto baru
        $fotoName = Str::uuid() . '.' . $request->foto->extension();
        $path = $request->foto->storeAs('foto_obat', $fotoName, 'public');
        $data['foto'] = $path;
    }

    // Update data obat (kecuali harga)
    $obat->update(collect($data)->except(['harga_pokok','margin','harga_jual'])->toArray());

    // 🔹 Simpan riwayat harga baru kalau ada input harga
    if ($request->filled('harga_pokok')) {
        Harga::create([
            'obat_id'     => $obat->id,
            'harga_pokok' => $request->harga_pokok,
            'margin'      => $request->margin ?? 0,
            'harga_jual'  => $request->harga_jual,
        ]);
    }

        $obat->update($data);

        return response()->json([
            'success' => true,
            'message' => 'obat berhasil diupdate.',
            'data'    => $obat
        ], 200);
    }

    // Hapus Obat
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);

        if ($obat->foto && \Storage::disk('public')->exists($obat->foto)) {
            \Storage::disk('public')->delete($obat->foto);
        }
        $obat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil dihapus.'
        ], 200);
    }
}
