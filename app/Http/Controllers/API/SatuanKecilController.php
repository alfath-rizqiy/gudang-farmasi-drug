<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SatuanKecil;
use Illuminate\Support\Facades\Validator;

class SatuanKecilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $satuankecil = SatuanKecil::all();
        return view('satuankecil.index', compact('satuankecil')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('satuankecil.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         $request->merge([
            'nama_satuankecil' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_satuankecil)))
        ]);

        $validator = Validator::make($request->all(), [
        'nama_satuankecil' => 'required|string|unique:satuan_kecils,nama_satuankecil',
        'deskripsi' => 'required|string',
    ], [
        'nama_satuankecil.required' => 'Nama satuan kecil wajib diisi',
        'nama_satuankecil.unique' => 'Nama satuan kecil sudah terdaftar',
        'deskripsi.required' => 'Deskripsi satuan kecil wajib diisi.'
    ]);

     if ($validator->fails()) {
        return redirect()
            ->route('satuankecil.index') // balik ke index
            ->withErrors($validator) // kirim errors ke view index
            ->withInput(); // kirim input sebelumnya
    }

    SatuanKecil::create($validated);

    return redirect()->route('satuankecil.index')->with('success', 'satuankecil berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $satuankecil = SatuanKecil::with('obats')->findOrFail($id);
         return view('satuankecil.show', compact('satuankecil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $satuankecil = SatuanKecil::findOrFail($id); // perbaikan di sini
    return view('satuankecil.edit', compact('satuankecil')); // dan di sini
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

         $request->merge([
            'nama_satuankecil' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_satuankecil)))
        ]);

        $request->validate([
        'nama_satuankecil' => 'required|string|unique:satuan_kecils,nama_satuankecil,' . $id,
        'deskripsi' => 'required|string',
    ]);

        $satuankecil = SatuanKecil::findOrFail($id);
        $satuankecil->update($request->only(['nama_satuankecil', 'deskripsi']));;

        return redirect()->route('satuankecil.index')->with('success', 'Data berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        $satuankecil = SatuanKecil::findOrFail($id);

        // Cek apakah satuankecil masih punya relasi obat
        if ($satuankecil->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data satuankecil tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $satuankecil->delete();
        return redirect()->back()->with('success', 'Data satuankecil berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data satuankecil.');
    }
}

}