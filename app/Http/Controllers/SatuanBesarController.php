<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SatuanBesar;
use Illuminate\Support\Facades\Validator;

class SatuanBesarController extends Controller
{
    public function index()
    {
        $satuanbesar = SatuanBesar::all();
        return view('satuanbesar.index', compact('satuanbesar'));
    }

    public function create()
    {
        return view('satuanbesar.create');
    }

    public function store(Request $request)
    {
        // 🔧 Normalisasi nama_satuanbesar sebelum validasi
        $request->merge([
            'nama_satuanbesar' => (preg_replace('/\s+/', ' ', trim($request->nama_satuanbesar)))
        ]);

        $validator = Validator::make($request->all(), [
            'nama_satuanbesar' => 'required|string|unique:satuan_besars,nama_satuanbesar',
            'deskripsi'     => 'required|string',
            'jumlah_satuankecil'     => 'required|string',
        ], [
            'nama_satuanbesar.required' => 'Nama satuanbesar wajib diisi',
            'nama_satuanbesar.unique'   => 'Nama satuanbesar sudah terdaftar',
            'deskripsi.required'     => 'Deskripsi satuanbesar wajib diisi',
            'jumlah_satuankecil.required'     => 'Jumlah Satuan Kecil wajib diisi'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('satuanbesar.index')
                ->withErrors($validator)
                ->withInput();
        }

        $satuanbesar = SatuanBesar::create($validator->validated());

        return redirect()->route('satuanbesar.index')->with('success', 'satuanbesar berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $satuanbesar = SatuanBesar::with('obats')->findOrFail($id);
        return view('satuanbesar.show', compact('satuanbesar'));
    }

    public function edit(string $id)
    {
        $satuanbesar = SatuanBesar::findOrFail($id);
        return view('satuanbesar.edit', compact('satuanbesar'));
    }

    public function update(Request $request, string $id)
    {
         // Ambil satuanbesar dulu
    $satuanbesar = SatuanBesar::findOrFail($id);

    // Cek apakah satuanbesar masih punya relasi obat
    if ($satuanbesar->obats()->count() > 0) {
        return redirect()->back()->with('error', 'Data satuanbesar tidak dapat diedit karena masih digunakan oleh data obat.');
    }

    // Validasi input
    $request->validate([
            'nama_satuanbesar' => 'required|string|unique:satuan_besars,nama_satuanbesar,' . $id,
            'deskripsi'     => 'required|string',
            'jumlah_satuankecil'     => 'required|string',
        ]);

        // Update data satuanbesar
    $satuanbesar->update($request->only(['nama_satuanbesar', 'deskripsi', 'jumlah_satuankecil']));

    return redirect()->route('satuanbesar.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        try {
            $satuanbesar = SatuanBesar::findOrFail($id);

            if ($satuanbesar->obats()->count() > 0) {
                return redirect()->back()->with('error', 'satuanbesar tidak dapat dihapus karena masih digunakan oleh data obat.');
            }

            $satuanbesar->delete();
            return redirect()->back()->with('success', 'satuanbesar berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus satuanbesar.');
        }
    }
}