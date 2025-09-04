<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Validator;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        return view('metodepembayaran.index');
    }

    public function create()
    {
        return view('metodepembayaran.create');
    }

    public function store(Request $request)
    {
        // 🔧 Normalisasi nama_metodepembayaran sebelum validasi
        $request->merge([
            'nama_metode' => strtolower(preg_replace('/\s+/', ' ', trim($request->nama_metode)))
        ]);

        $validator = Validator::make($request->all(), [
            'nama_metode' => 'required|string|unique:metode_pembayarans,nama_metode',
            'deskripsi'     => 'required|string',
        ], [
            'nama_metode.required' => 'Nama metode wajib diisi',
            'nama_metode.unique'   => 'Nama metode sudah terdaftar',
            'deskripsi.required'     => 'Deskripsi metodepembayaran wajib diisi'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('metodepembayaran.index')
                ->withErrors($validator)
                ->withInput();
        }

        $metodepembayaran = MetodePembayaran::create($validator->validated());

        return redirect()->route('metodepembayaran.index')->with('success', 'metodepembayaran berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $metodepembayaran = MetodePembayaran::with('obats')->findOrFail($id);
        return view('metodepembayaran.show', compact('metodepembayaran'));
    }

    public function edit(string $id)
    {
        $metodepembayaran = MetodePembayaran::findOrFail($id);
        return view('metodepembayaran.edit', compact('metodepembayaran'));
    }

    public function update(Request $request, string $id)
    {
         // Ambil metodepembayaran dulu
    $metodepembayaran = MetodePembayaran::findOrFail($id);

    // Cek apakah metodepembayaran masih punya relasi obat
    if ($metodepembayaran->obats()->count() > 0) {
        return redirect()->back()->with('error', 'Data metodepembayaran tidak dapat diedit karena masih digunakan oleh data obat.');
    }

    // Validasi input
    $request->validate([
            'nama_metode' => 'required|string|unique:metode_pembayarans,nama_metode,' . $id,
            'deskripsi'     => 'required|string',
        ]);

        // Update data metodepembayaran
    $metodepembayaran->update($request->only(['nama_metode', 'deskripsi']));

    return redirect()->route('metodepembayaran.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        try {
            $metodepembayaran = MetodePembayaran::findOrFail($id);

            if ($metodepembayaran->obats()->count() > 0) {
                return redirect()->back()->with('error', 'metodepembayaran tidak dapat dihapus karena masih digunakan oleh data obat.');
            }

            $metodepembayaran->delete();
            return redirect()->back()->with('success', 'metodepembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus metodepembayaran.');
        }
    }
}
