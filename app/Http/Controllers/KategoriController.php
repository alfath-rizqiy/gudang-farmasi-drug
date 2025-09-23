<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index');
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        // 🔧 Normalisasi nama_kategori sebelum validasi
        $request->merge([
            'nama_kategori' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_kategori)))
        ]);

        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori',
            'deskripsi'     => 'required|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique'   => 'Nama kategori sudah terdaftar',
            'deskripsi.required'     => 'Deskripsi kategori wajib diisi'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('kategori.index')
                ->withErrors($validator)
                ->withInput();
        }

        $kategori = Kategori::create($validator->validated());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $kategori = Kategori::with('obats')->findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, string $id)
    {
         // Ambil kategori dulu
    $kategori = Kategori::findOrFail($id);

    // Cek apakah kategori masih punya relasi obat
    if ($kategori->obats()->count() > 0) {
        return redirect()->back()->with('error', 'Data kategori tidak dapat diedit karena masih digunakan oleh data obat.');
    }

    // Validasi input
    $request->validate([
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori,' . $id,
            'deskripsi'     => 'required|string',
        ]);

        // Update data kategori
    $kategori->update($request->only(['nama_kategori', 'deskripsi']));

    return redirect()->route('kategori.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            if ($kategori->obats()->count() > 0) {
                return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh data obat.');
            }

            $kategori->delete();
            return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}
