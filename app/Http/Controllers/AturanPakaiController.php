<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AturanPakai;
use Illuminate\Support\Facades\Validator;

class AturanPakaiController extends Controller
{
    public function index()
    {
        return view('aturanpakai.index');
    }

    public function create()
    {
        return view('aturanpakai.create');
    }

    public function store(Request $request)
    {
        //normalisasi input sebelum validasi
        $request->merge([
            'frekuensi_pemakaian' => strtolower(preg_replace('/\s+/', ' ', trim($request->frekuensi_pemakaian)))
        ]);

        $validator = Validator::make($request->all(), [
            'frekuensi_pemakaian' => 'required|string|unique:aturan_pakais,frekuensi_pemakaian',
            'waktu_pemakaian'     => 'required|string',
            'deskripsi'           => 'required|string'
        ], [
            'frekuensi_pemakaian.required' => 'Frekuensi pemakaian wajib diisi',
            'frekuensi_pemakaian.unique'   => 'Frekuensi pemakaian sudah terdaftar'
        ]);

       if ($validator->fails()) {
            return redirect()
                ->route('aturanpakai.index')
                ->withErrors($validator)
                ->with('open_modal', true)
                ->withInput();
        }

        AturanPakai::create($validator->validated());

        return redirect()->route('aturanpakai.index')->with('success', 'Aturan pakai berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $aturanpakai = AturanPakai::with('obats')->findOrFail($id);
        return view('aturanpakai.show', compact('aturanpakai'));
    }

    public function edit(string $id)
    {
        $aturanpakai = AturanPakai::findOrFail($id);
        return view('aturanpakai.edit', compact('aturanpakai'));
    }

    public function update(Request $request, string $id)
    {
        $aturanpakai = AturanPakai::findOrFail($id);

        // Cek relasi dulu
        if ($aturanpakai->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Aturan pakai tidak dapat diedit karena masih digunakan oleh data obat.');
        }

        // 🔧 Normalisasi input
        $request->merge([
            'frekuensi_pemakaian' => strtolower(preg_replace('/\s+/', ' ', trim($request->frekuensi_pemakaian)))
        ]);

        $validator = Validator::make($request->all(), [
            'frekuensi_pemakaian' => 'required|string|unique:aturan_pakais,frekuensi_pemakaian,' . $id,
            'waktu_pemakaian'     => 'required|string',
            'deskripsi'           => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $aturanpakai->update($validator->validated());

        return redirect()->route('aturanpakai.index')->with('success', 'Aturan pakai berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        try {
            $aturanpakai = AturanPakai::findOrFail($id);

            if ($aturanpakai->obats()->count() > 0) {
                return redirect()->back()->with('error', 'Aturan pakai tidak dapat dihapus karena masih digunakan oleh data obat.');
            }

            $aturanpakai->delete();
            return redirect()->back()->with('success', 'Aturan pakai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus aturan pakai.');
        }
    }
}
