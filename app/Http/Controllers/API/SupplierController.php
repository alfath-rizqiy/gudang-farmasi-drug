<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    // GET /api/suppliers
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json([
            'success' => true,
            'data' => $suppliers
        ], 200);
    }

    // POST /api/suppliers
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string',
            'telepon'       => 'required|string',
            'email'         => 'required|email',
            'alamat'        => 'required|string',
        ]);

        $supplier = Supplier::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil ditambahkan.',
            'data'    => $supplier
        ], 201);
    }

    // GET /api/suppliers/{id}
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

    // PUT /api/suppliers/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_supplier' => 'required|string',
            'telepon'       => 'required|string',
            'email'         => 'required|email',
            'alamat'        => 'required|string',
        ]);

        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json([
                'success' => false,
                'message' => 'Supplier tidak ditemukan.'
            ], 404);
        }

        $supplier->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil diupdate.',
            'data'    => $supplier
        ], 200);
    }

    // DELETE /api/suppliers/{id}
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
