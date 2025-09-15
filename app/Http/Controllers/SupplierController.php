<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier.index'); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'nama_supplier' => (preg_replace('/\s+/', ' ', trim($request->nama_supplier))),
            'email' => (preg_replace('/\s+/', ' ', trim($request->email)))
        ]);

        $validator = Validator::make($request->all(), [
        'nama_supplier' => 'required|string|unique:suppliers,nama_supplier',
        'telepon' => 'required|string',
        'email' => 'required|string|unique:suppliers,email',
        'alamat' => 'required|string',
        ], [
        'nama_supplier.required' => 'Nama supplier wajib diisi',
        'telepon.required' => 'Telepon supplier wajib diisi',
        'alamat.required' => 'Alamat supplier wajib diisi',
        'email.required' => 'Email supplier wajib diisi',
        'nama_supplier.unique' => 'Nama supplier sudah terdaftar',
        'email.unique' => 'Email supplier sudah digunakan.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $supplier = Supplier::create($validator->validated());
    
        return response()->json([
            'status' => true,
            'message'  => 'Data berhasil disimpan!',
            'data'     => $supplier,
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::with('obats')->findOrFail($id);
         return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::findOrFail($id); 
        return response()->json($supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Ambil supplier dulu
        $supplier = Supplier::findOrFail($id);

        // Cek apakah supplier masih punya relasi obat
        if ($supplier->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data supplier tidak dapat diedit karena masih digunakan oleh data obat.');
        }

        // Validasi input
        $request->validate([
            'nama_supplier' => 'required|string|unique:suppliers,nama_supplier,' . $id,
            'telepon' => 'required|string',
            'email' => 'required|email|unique:suppliers,email,' . $id,
            'alamat' => 'required', 
        ]);

        // Update data supplier
        $supplier->update($request->only(['nama_supplier', 'telepon', 'email', 'alamat']));

        return redirect()->route('satuankecil.index')->with('success', 'Data berhasil diupdate.');
    
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
 
        $supplier = Supplier::findOrFail($id);

        // Cek apakah supplier masih punya relasi obat
        if ($supplier->obats()->count() > 0) {
            return redirect()->back()->with('error', 'Data supplier tidak dapat dihapus karena masih digunakan oleh data obat.');
        }

        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil dihapus'
        ]);

    }

}
