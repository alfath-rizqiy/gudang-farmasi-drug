<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AturanPakai;
use Illuminate\Support\Facades\Validator;

class AturanPakaiController extends Controller
{
    /**
     * Menampilkan semua data Aturan Pakai.
     * Mengambil semua record dari tabel aturan_pakai dan mengirimkannya ke view index.
     */
    public function index()
    {
        $aturanpakai = AturanPakai::all();
        return view('aturanpakai.index', compact('aturanpakai')); 
    }

    /**
     * Menampilkan form untuk membuat data Aturan Pakai baru.
     */
    public function create()
    {
        return view('aturanpakai.create');
    }

     /**
     * Menyimpan data Aturan Pakai baru ke database.
     * Validasi input, lalu simpan menggunakan mass assignment.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'frekuensi_pemakaian' => 'required|string|unique:aturan_pakais,frekuensi_pemakaian',
        'waktu_pemakaian'     => 'required|string|unique:aturan_pakais,waktu_pemakaian',
        'deskripsi'           => 'required|string',
    ], [
        'frekuensi_pemakaian.required' => 'Frekuensi pemakaian wajib diisi.',
        'waktu_pemakaian.required'     => 'Waktu pemakaian wajib diisi.',
    ]);

    if ($validator->fails()) {
        return redirect()
            ->route('Aturanpakai.index') // balik ke index
            ->withErrors($validator) // kirim errors ke view index
            ->withInput(); // kirim input sebelumnya
    }

   $Aturanpakai = AturanPakai::create($validator->validated());


    return redirect()->route('Aturanpakai.index')->with('success', 'Aturanpakai berhasil ditambahkan.');

    }

    /**
     * Menampilkan detail dari satu data Aturan Pakai berdasarkan ID.
     * Mengambil relasi dengan tabel obats jika ada.
     */
    public function show(string $id)
    {
        $aturanpakai = AturanPakai::with('obats')->findOrFail($id);
         return view('aturanpakai.show', compact('aturanpakai'));
    }

     /**
     * Menampilkan form edit untuk data Aturan Pakai tertentu.
     */
    public function edit(string $id)
    {
        $aturanpakai = AturanPakai::findOrFail($id); // perbaikan di sini
    return view('aturanpakai.edit', compact('aturanpakai')); // dan di sini
    }

     /**
     * Memperbarui data Aturan Pakai berdasarkan ID.
     * Validasi input, lalu update hanya field yang diperlukan.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'frekuensi_pemakaian' => 'required|string',
        'waktu_pemakaian'     => 'required|string',
        'deskripsi'           => 'nullable|string',
    ]);

        $aturanpakai = AturanPakai::findOrFail($id);
        $aturanpakai->update($request->only(['frekuensi_pemakaian', 'waktu_pemakaian', 'deskripsi',]));;

        return redirect()->route('aturanpakai.index')->with('success', 'Data berhasil diupdate.');

    }

     /**
     * Menghapus data Aturan Pakai berdasarkan ID.
     */
    public function destroy($id)
{
    try {
        $aturanpakai = AturanPakai::findOrFail($id);

        // Cek apakah aturanpakai masih punya relasi obat
        if ($aturanpakai->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data aturanpakai tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $aturanpakai->delete();
        return redirect()->back()->with('success', 'Data aturanpakai berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data aturanpakai.');
    }
}

}