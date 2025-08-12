<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    // Tampilkan Supplier
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json([
            'success' => true,
            'data' => $suppliers
        ], 200);
    }

    // Input Supplier
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_supplier' => 'required|string|unique:suppliers,nama_supplier',
            'telepon' => 'required|string',
            'email' => 'required|email|unique:suppliers,email',
            'alamat' => 'required|string',
        ], [
            'nama_supplier.required' => 'Nama obat wajib diisi',
            'nama_supplier.unique' => 'Nama obat sudah terdaftar',
            'email.unique' => 'Email supplier sudah digunakan.'
        ]);


        // Supplier tidak valid
        if ($validator->fails()) {
            return response()->json([
                'status'=> false,
                'message'=> 'validasi error',
                'errors'=> $validator->errors()
            ], 422);
        }

         $supplier = Supplier::create($validator->validated());

        // Supplier valid
        $supplier = Supplier::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil ditambahkan.',
            'data'    => $supplier
        ], 201);
    }


    // Tampilkan detail
    public function show($id)
    {
        $supplier = Supplier::with('obats')->find($id);

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $supplier
        ], 200);
    }

    // Update Supplier
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required|string|unique:suppliers,nama_supplier,' . $id,
            'telepon'       => 'required|string',
            'email'         => 'required|email|unique:suppliers,email,' . $id,
            'alamat'        => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }
        
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier tidak ditemukan.'
            ], 404);
        }

        $supplier->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil diupdate.',
            'data'    => $supplier
        ], 200);

    }

    // Hapus Supplier
    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier tidak ditemukan.'
            ], 404);
        }

        if ($supplier->obats()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data supplier tidak dapat dihapus karena masih digunakan oleh data obat.'
            ], 409); // 409 Conflict
        }

        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data supplier berhasil dihapus.'
        ], 200);
    }
}
