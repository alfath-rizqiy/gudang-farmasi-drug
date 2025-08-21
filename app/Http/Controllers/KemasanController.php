<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kemasan;
use Illuminate\Support\Facades\Validator;

class KemasanController extends Controller
{
     /**
     * Menampilkan semua data kemasan.
     * Mengambil semua record dari tabel kemasan dan mengirimkannya ke view index.
     */
    public function index()
    {
        $kemasan = Kemasan::all();
        return view('kemasan.index', compact('kemasan')); 
    }

   
    /**
     * Menampilkan form untuk membuat data kemasan baru.
     */
    public function create()
    {
        return view('kemasan.index');
    }

     /**
     * Menyimpan data kemasan baru ke database.
     * Validasi input, lalu simpan menggunakan mass assignment.
     */
    public function store(Request $request)
    {
        $request->merge([
            'nama_kemasan' => (preg_replace('/\s+/', ' ', trim($request->nama_kemasan)))
        ]);

        $validator = Validator::make($request->all(), [
         'nama_kemasan'         => 'required|string|unique:kemasans,nama_kemasan',
        'tanggal_produksi'     => 'required|date',
        'tanggal_kadaluarsa'   => 'required|date|after:tanggal_produksi',
        'petunjuk_penyimpanan' => 'required|string|unique:kemasans,petunjuk_penyimpanan',
    ], [
        'nama_kemasan.required'         => 'Nama kemasan wajib diisi.',
        'tanggal_produksi.required'     => 'Tanggal produksi wajib diisi.',
        'tanggal_kadaluarsa.required'   => 'Tanggal kadaluarsa wajib diisi.',
        'tanggal_kadaluarsa.after'      => 'Tanggal kadaluarsa harus setelah tanggal produksi.',
        'petunjuk_penyimpanan.required' => 'Petunjuk penyimpanan wajib diisi.',
    ]);

     if ($validator->fails()) {
        return redirect()
            ->route('kemasan.index') // balik ke index
            ->withErrors($validator) 
            ->with('open_modal', true)
            ->withInput(); 
    }

   $kemasan = Kemasan::create($validator->validated());


    return redirect()->route('kemasan.index')->with('success', 'kemasan berhasil ditambahkan.');

    }

     /**
     * Menampilkan detail dari satu data kemasan berdasarkan ID.
     * Mengambil relasi dengan tabel obats jika ada.
     */
    public function show(string $id)
    {
        $kemasan = Kemasan::with('obats')->findOrFail($id);
         return view('kemasan.show', compact('kemasan'));
    }

   /**
     * Menampilkan form edit untuk data kemasan tertentu.
     */
    public function edit(string $id)
    {
        $kemasan = Kemasan::findOrFail($id); // perbaikan di sini
    return view('kemasan.edit', compact('kemasan')); // dan di sini
    }

     /**
     * Memperbarui data kemasan berdasarkan ID.
     * Validasi input, lalu update hanya field yang diperlukan.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nama_kemasan' => 'required|string',
        'tanggal_produksi' => 'required|date',
        'tanggal_kadaluarsa' => 'required|date',
        'petunjuk_penyimpanan' => 'required|string', 
    ]);

        $kemasan = Kemasan::findOrFail($id);
        $kemasan->update($request->only(['nama_kemasan', 'tanggal_produksi', 'tanggal_kadaluarsa', 'petunjuk_penyimpanan']));;

        return redirect()->route('kemasan.index')->with('success', 'Data berhasil diupdate.');

    }

     /**
     * Menghapus data kemasan berdasarkan ID.
     */
    public function destroy($id)
{
    try {
        $kemasan = Kemasan::findOrFail($id);

        // Cek apakah kemasan masih punya relasi obat
        if ($kemasan->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data kemasan tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $kemasan->delete();
        return redirect()->back()->with('success', 'Data kemasan berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data kemasan.');
    }
}

}