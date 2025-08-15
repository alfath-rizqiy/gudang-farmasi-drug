<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SatuanBesar;
use Illuminate\Support\Facades\Validator;

class SatuanBesarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $satuanbesar = SatuanBesar::all();
        return view('satuanbesar.index', compact('satuanbesar')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('satuanbesar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_satuanbesar' => (preg_replace('/\s+/', ' ', trim($request->nama_satuanbesar)))
        ]);

        $validator = Validator::make($request->all(), [
        'nama_satuanbesar' => 'required|string|unique:satuan_besars,nama_satuanbesar',
        'deskripsi' => 'required|string',
        'jumlah_satuankecil' => 'required|string',
    ], [
        'nama_satuanbesar.required' => 'Nama satuan besar wajib diisi',
        'nama_satuanbesar.unique' => 'Nama satuan besar sudah terdaftar',
        'deskripsi.required' => 'Deskripsi satuan besar wajib diisi.',
        'jumlah_satuankecil.required' => 'Jumlah_satuankecil wajib diisi.'
    ]);

     if ($validator->fails()) {
        return redirect()
            ->route('satuanbesar.index') // balik ke index
            ->withErrors($validator) // kirim errors ke view index
            ->withInput(); // kirim input sebelumnya
    }

    $satuanbesar = SatuanBesar::create($validator->validated());

    return redirect()->route('satuanbesar.index')->with('success', 'satuanbesar berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $satuanbesar = SatuanBesar::with('obats')->findOrFail($id);
         return view('satuanbesar.show', compact('satuanbesar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $satuanbesar = SatuanBesar::findOrFail($id); // perbaikan di sini
    return view('satuanbesar.edit', compact('satuanbesar')); // dan di sini
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 🔧 Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_satuanbesar' => (preg_replace('/\s+/', ' ', trim($request->nama_satuanbesar)))
        ]);

        $request->validate([
        'nama_satuanbesar' => 'required|string|unique:satuan_besars,nama_satuanbesar,' . $id,
        'deskripsi' => 'required|string',
        'jumlah_satuankecil' => 'required|string',
    ]);

        $satuanbesar = SatuanBesar::findOrFail($id);
        $satuanbesar->update($request->only(['nama_satuanbesar', 'deskripsi', 'jumlah_satuankecil']));

        return redirect()->route('satuanbesar.index')->with('success', 'Data berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    try {
        $satuanbesar = SatuanBesar::findOrFail($id);

        // Cek apakah satuanbesar masih punya relasi obat
        if ($satuanbesar->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data satuanbesar tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $satuanbesar->delete();
        return redirect()->back()->with('success', 'Data satuanbesar berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data satuanbesar.');
    }
    }

}