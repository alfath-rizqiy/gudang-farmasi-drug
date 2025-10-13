<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    // 🔹 Tampilkan halaman daftar kategori
    public function index()
    {
        return view('kategori.index');
    }

    // 🔹 Tampilkan form tambah kategori
    public function create()
    {
        return view('kategori.create');
    }

    // 🔹 Simpan kategori baru ke database
    public function store(Request $request)
    {
        // Normalisasi nama_kategori (trim, hapus spasi berlebih, ubah ke lowercase)
        $request->merge([
            'nama_kategori' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_kategori)))
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori',
            'deskripsi'     => 'required|string',
        ], [
            // Pesan error custom
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique'   => 'Nama kategori sudah terdaftar',
            'deskripsi.required'     => 'Deskripsi kategori wajib diisi'
        ]);

        // Jika validasi gagal, kembali ke halaman index + tampilkan error
        if ($validator->fails()) {
            return redirect()
                ->route('kategori.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Jika lolos validasi → simpan data kategori baru
        $kategori = Kategori::create($validator->validated());

        // Redirect ke index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // 🔹 Menampilkan detail kategori (beserta relasi obats) dalam bentuk JSON
    public function show(string $id)
    {
         $kategori = Kategori::with('obats')->findOrFail($id);
         return response()->json($kategori);
    }

    // 🔹 Tampilkan form edit kategori
    public function edit(string $id)
    {
        // Cari kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Kirim data ke view edit
        return view('kategori.edit', compact('kategori'));
    }

    // 🔹 Update data kategori
    public function update(Request $request, string $id)
    {
        // Ambil kategori berdasarkan ID
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori masih digunakan oleh data obat
        if ($kategori->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data kategori tidak dapat diedit karena masih digunakan oleh data obat.');
        }

        // Validasi input (unique kecuali ID yang sedang diedit)
        $request->validate([
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori,' . $id,
            'deskripsi'     => 'required|string',
        ]);

        // Update data kategori
        $kategori->update($request->only(['nama_kategori', 'deskripsi']));

        // Redirect ke index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Data berhasil diupdate.');
    }

    // 🔹 Hapus kategori
    public function destroy(string $id)
    {
        try {
            // Cari kategori berdasarkan ID
            $kategori = Kategori::findOrFail($id);

            // Cek apakah kategori masih dipakai di data obat
            if ($kategori->obats()->count() > 0) {
                return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh data obat.');
            }

            // Hapus kategori
            $kategori->delete();

            // Kembali dengan pesan sukses
            return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika terjadi error saat proses delete
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}
