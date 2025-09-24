<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Validator;

class MetodePembayaranController extends Controller
{
    // 🔹 Tampilkan halaman daftar metode pembayaran
    public function index()
    {
        return view('metodepembayaran.index');
    }

    // 🔹 Tampilkan form tambah metode pembayaran
    public function create()
    {
        return view('metodepembayaran.create');
    }

    // 🔹 Simpan metode pembayaran baru
    public function store(Request $request)
    {
        // Normalisasi nama_metode (trim, hapus spasi berlebih, ubah ke lowercase)
        $request->merge([
            'nama_metode' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_metode)))
        ]);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_metode' => 'required|string|unique:metode_pembayarans,nama_metode',
            'deskripsi'   => 'required|string',
        ], [
            // Pesan error custom
            'nama_metode.required' => 'Nama metode wajib diisi',
            'nama_metode.unique'   => 'Nama metode sudah terdaftar',
            'deskripsi.required'   => 'Deskripsi metodepembayaran wajib diisi'
        ]);

        // Jika validasi gagal → kembali ke halaman index + tampilkan error
        if ($validator->fails()) {
            return redirect()
                ->route('metodepembayaran.index')
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi lolos → simpan data ke database
        $metodepembayaran = MetodePembayaran::create($validator->validated());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('metodepembayaran.index')->with('success', 'metodepembayaran berhasil ditambahkan.');
    }

    // 🔹 Menampilkan detail metode pembayaran (beserta relasi obats) dalam bentuk JSON
    public function show(string $id)
    {
         $metodepembayaran = MetodePembayaran::with('obats')->findOrFail($id);
         return response()->json($metodepembayaran);
    }

    // 🔹 Tampilkan form edit metode pembayaran
    public function edit(string $id)
    {
        // Cari data metode pembayaran berdasarkan ID
        $metodepembayaran = MetodePembayaran::findOrFail($id);

        // Kirim data ke view edit
        return view('metodepembayaran.edit', compact('metodepembayaran'));
    }

    // 🔹 Update metode pembayaran
    public function update(Request $request, string $id)
    {
        // Ambil data metode pembayaran berdasarkan ID
        $metodepembayaran = MetodePembayaran::findOrFail($id);

        // Cek apakah metode pembayaran masih dipakai oleh data obat
        if ($metodepembayaran->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data metodepembayaran tidak dapat diedit karena masih digunakan oleh data obat.');
        }

        // Validasi input (unique kecuali data yang sedang diedit)
        $request->validate([
            'nama_metode' => 'required|string|unique:metode_pembayarans,nama_metode,' . $id,
            'deskripsi'   => 'required|string',
        ]);

        // Update data metode pembayaran
        $metodepembayaran->update($request->only(['nama_metode', 'deskripsi']));

        // Redirect ke index dengan pesan sukses
        return redirect()->route('metodepembayaran.index')->with('success', 'Data berhasil diupdate.');
    }

    // 🔹 Hapus metode pembayaran
    public function destroy(string $id)
    {
        try {
            // Cari data berdasarkan ID
            $metodepembayaran = MetodePembayaran::findOrFail($id);

            // Jika masih dipakai di data obat → tidak boleh dihapus
            if ($metodepembayaran->obats()->count() > 0) {
                return redirect()->back()->with('error', 'metodepembayaran tidak dapat dihapus karena masih digunakan oleh data obat.');
            }

            // Jika tidak ada relasi → hapus data
            $metodepembayaran->delete();

            // Kembali dengan pesan sukses
            return redirect()->back()->with('success', 'metodepembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika terjadi error saat proses delete
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus metodepembayaran.');
        }
    }
}
