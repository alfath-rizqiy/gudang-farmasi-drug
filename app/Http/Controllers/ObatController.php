<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Supplier;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obats = Obat::with('supplier')->get();
        return view('obat.index', compact('obats')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();

        return view('obat.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'nama_obat' => 'required|string|max:255',
        'supplier_id' => 'required|exists:suppliers,id',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
        ]);

        return redirect()->route('obat.index')->with('success', 'obat berhasil ditambahkan.');
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
        $obat = Obat::findOrFail($id);
        $suppliers = Supplier::all();

        return view('obat.edit', compact('obat', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
        'nama_obat' => 'required|string|max:255',
        'supplier_id' => 'required|exists:suppliers,id',
    ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'supplier_id' => $request->supplier_id,
        ]);

        return redirect()->route('obat.index')->with('success', 'Data berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('obat.index')->with('success', 'Data berhasil dihapus.');

    }
}
