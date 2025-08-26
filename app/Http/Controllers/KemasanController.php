<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kemasan;
use Illuminate\Support\Facades\Validator;

class KemasanController extends Controller
{
    public function index()
    {
        $kemasans = Kemasan::all();
        return view('kemasan.index', compact('kemasans'));
    }

    public function create()
    {
        return view('kemasan.index'); // kalau pakai modal, tetap di index
    }

    public function store(Request $request)
    {
        $request->merge([
            'nama_kemasan' => preg_replace('/\s+/', ' ', trim($request->nama_kemasan))
        ]);

        $validator = Validator::make($request->all(), [
            'nama_kemasan'         => 'required|string|unique:kemasans,nama_kemasan',
            'tanggal_produksi'     => 'required|date',
            'tanggal_kadaluarsa'   => 'required|date|after:tanggal_produksi',
            'petunjuk_penyimpanan' => 'required|string|',
        ], [
            'nama_kemasan.required' => 'Nama kemasan wajib diisi',
            'nama_kemasan.unique'   => 'Nama kemasan sudah terdaftar'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('kemasan.index')
                ->withErrors($validator)
                ->with('open_modal', true)
                ->withInput();
        }

        Kemasan::create($validator->validated());

        return redirect()->route('kemasan.index')->with('success', 'Kemasan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $kemasan = Kemasan::with('obats')->findOrFail($id);
        return view('kemasan.show', compact('kemasan'));
    }

    public function edit(string $id)
    {
        $kemasan = Kemasan::findOrFail($id);
        return view('kemasan.edit', compact('kemasan'));
    }

    public function update(Request $request, string $id)
    {
        $kemasan = Kemasan::findOrFail($id);

        if ($kemasan->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Kemasan tidak dapat diedit karena masih digunakan oleh data obat.');
        }

        $request->merge([
            'nama_kemasan' => preg_replace('/\s+/', ' ', trim($request->nama_kemasan))
        ]);

        $validator = Validator::make($request->all(), [
            'nama_kemasan'         => 'required|string|unique:kemasans,nama_kemasan,' . $id,
            'tanggal_produksi'     => 'required|date',
            'tanggal_kadaluarsa'   => 'required|date|after:tanggal_produksi',
            'petunjuk_penyimpanan' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kemasan->update($validator->validated());

        return redirect()->route('kemasan.index')->with('success', 'Kemasan berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        try {
            $kemasan = Kemasan::findOrFail($id);

            if ($kemasan->obats()->count() > 0) {
                return redirect()->back()->with('error', 'Kemasan tidak dapat dihapus karena masih digunakan oleh data obat.');
            }

            $kemasan->delete();
            return redirect()->back()->with('success', 'Kemasan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kemasan.');
        }
    }
}
