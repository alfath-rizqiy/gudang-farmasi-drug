<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SatuanKecil;
use Illuminate\Support\Facades\Validator;

class SatuanKecilController extends Controller
{
    public function index()
    {
        $satuankecil = SatuanKecil::all();
        return view('satuankecil.index', compact('satuankecil'));
    }

    public function create()
    {
        return view('satuankecil.index');
    }

    public function store(Request $request)
    {
        // 🔧 Normalisasi nama_satuankecil sebelum validasi
        $request->merge([
            'nama_satuankecil' => (preg_replace('/\s+/', ' ', trim($request->nama_satuankecil)))
        ]);

        $validator = Validator::make($request->all(), [
            'nama_satuankecil' => 'required|string|unique:satuan_kecils,nama_satuankecil',
            'deskripsi'     => 'required|string',
        ], [
            'nama_satuankecil.required' => 'Nama satuankecil wajib diisi',
            'nama_satuankecil.unique'   => 'Nama satuankecil sudah terdaftar',
            'deskripsi.required'     => 'Deskripsi satuankecil wajib diisi'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('satuankecil.index')
                ->withErrors($validator)
                ->withInput();
        }

        $satuankecil = SatuanKecil::create($validator->validated());

        return redirect()->route('satuankecil.index')->with('success', 'satuankecil berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $satuankecil = SatuanKecil::with('obats')->findOrFail($id);
        return view('satuankecil.show', compact('satuankecil'));
    }

    public function edit(string $id)
    {
        $satuankecil = SatuanKecil::findOrFail($id);
        return view('satuankecil.edit', compact('satuankecil'));
    }

    public function update(Request $request, string $id)
    {
         // Ambil satuankecil dulu
    $satuankecil = SatuanKecil::findOrFail($id);

    // Cek apakah satuankecil masih punya relasi obat
    if ($satuankecil->obats()->count() > 0) {
        return redirect()->back()->with('error', 'Data satuankecil tidak dapat diedit karena masih digunakan oleh data obat.');
    }

    // Validasi input
    $request->validate([
            'nama_satuankecil' => 'required|string|unique:satuan_kecils,nama_satuankecil,' . $id,
            'deskripsi'     => 'required|string',
        ]);

        // Update data satuankecil
    $satuankecil->update($request->only(['nama_satuankecil', 'deskripsi']));

    return redirect()->route('satuankecil.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        try {
            $satuankecil = SatuanKecil::findOrFail($id);

            if ($satuankecil->obats()->count() > 0) {
                return redirect()->back()->with('error', 'satuankecil tidak dapat dihapus karena masih digunakan oleh data obat.');
            }

            $satuankecil->delete();
            return redirect()->back()->with('success', 'satuankecil berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus satuankecil.');
        }
    }
}