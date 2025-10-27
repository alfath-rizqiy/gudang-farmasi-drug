<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class PurchaseOrderController extends Controller
{
    /**
     * 🔹 Halaman utama daftar PO
     */
    public function index()
    {
        // Ambil daftar supplier (buat filter dropdown)
        $suppliers = Supplier::orderBy('nama_supplier')->get();

        return view('purchase_orders.index', compact('suppliers'));
    }

    /**
     * 🔹 (Opsional) Halaman form tambah PO
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        return view('purchase_orders.create', compact('suppliers'));
    }

    /**
     * 🔹 (Opsional) Halaman detail PO
     */
    public function show($id)
    {
        return view('purchase_orders.show', ['po_id' => $id]);
    }
}
