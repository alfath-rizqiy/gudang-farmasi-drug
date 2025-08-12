<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supplier = Supplier::all();
        return view('supplier.index', compact('supplier')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'nama_supplier' => 'required|string|unique:suppliers,nama_supplier',
        'telepon' => 'required|string',
        'email' => 'required|string|unique:suppliers,email',
        'alamat' => 'required|string',
    ], [
        'nama_supplier.required' => 'Nama obat wajib diisi',
        'nama_supplier.unique' => 'Nama obat sudah terdaftar',
        'email.unique' => 'Email supplier sudah digunakan.'
    ]);

     if ($validator->fails()) {
        return redirect()
            ->route('supplier.index') // balik ke index
            ->withErrors($validator) // kirim errors ke view index
            ->withInput(); // kirim input sebelumnya
    }

    Supplier::create($validated);

    return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::with('obats')->findOrFail($id);
         return view('supplier.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id); // perbaikan di sini
    return view('supplier.edit', compact('supplier')); // dan di sini
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nama_supplier' => 'required|string|unique:suppliers,nama_supplier,' . $id,
        'telepon' => 'required|string',
        'email' => 'required|email|unique:suppliers,email,' . $id,
        'alamat' => 'required', 
    ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->only(['nama_supplier', 'telepon', 'email', 'alamat']));;

        return redirect()->route('supplier.index')->with('success', 'Data berhasil diupdate.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        $supplier = Supplier::findOrFail($id);

        // Cek apakah supplier masih punya relasi obat
        if ($supplier->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data supplier tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $supplier->delete();
        return redirect()->back()->with('success', 'Data supplier berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data supplier.');
    }
}

}
