<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * 🔹 Ambil semua data Purchase Order (untuk DataTables)
     */
    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'user'])
            ->orderBy('tgl_po', 'desc');

        if ($request->has('supplier_id') && $request->supplier_id != '') {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled(['tanggal_mulai', 'tanggal_selesai'])) {
            $query->whereBetween('tgl_po', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $data = $query->get()->map(function ($po) {
            return [
                'id'              => $po->id,
                'nomor_po'        => $po->nomor_po,
                'tgl_po'          => $po->tgl_po ? $po->tgl_po->format('d/m/Y') : '-',
                'tgl_kirim'       => $po->tgl_kirim ? $po->tgl_kirim->format('d/m/Y') : '-',
                'top'             => $po->metode_pembayaran,
                'tgl_jatuh_tempo' => $po->tgl_jatuh_tempo ? $po->tgl_jatuh_tempo->format('d/m/Y') : '-',
                'supplier'        => $po->supplier->nama_supplier ?? '-',
                'total'           => number_format($po->total, 2, ',', '.'),
                'status'          => $po->status,
                'valid_user'      => strtoupper($po->user->name ?? '-') . ' ' . $po->updated_at->format('d/m/Y H:i:s'),
            ];
        });

        return response()->json(['data' => $data]);
    }

    /**
     * 🔹 Ambil daftar supplier untuk dropdown filter
     */
    public function getSuppliers()
    {
        $suppliers = Supplier::select('id', 'nama_supplier')->orderBy('nama_supplier')->get();
        return response()->json(['data' => $suppliers]);
    }
}
