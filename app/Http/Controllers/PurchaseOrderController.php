<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use App\Models\Obat;
use Illuminate\Support\Str;



class PurchaseOrderController extends Controller
{
    public function index()
{
    $purchaseOrders = PurchaseOrder::with('supplier')->latest()->get();

    return view('purchase_orders.index', compact('purchaseOrders'));
}

   private function generateNoPO()
{
    $today = date('Ymd');
    $prefix = 'PO-' . $today . '-';

    $lastPO = PurchaseOrder::where('no_po', 'like', $prefix . '%')
        ->orderBy('id', 'desc')
        ->first();

    if ($lastPO) {
        $lastNumber = (int) substr($lastPO->no_po, -5);
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '00001';
    }

    return $prefix . $newNumber;
}

    public function create()
    {
        $supplier = Supplier::all();
        $obats = Obat::all();
        return view('purchase_orders.create', compact('supplier', 'obats'));
    }

    public function show($id)
{
    $po = \App\Models\PurchaseOrder::with(['supplier', 'details'])->findOrFail($id);

    return view('purchase_orders.show', compact('po'));
}


    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $noPO = $this->generateNoPO();

            $po = PurchaseOrder::create([
                'no_po' => $noPO,
                'tanggal_po' => $request->tanggal_po,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tanggal_kirim' => $request->tanggal_kirim,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                'supplier_id' => $request->supplier_id,
                'status' => 'Open',
                'keterangan' => $request->keterangan,
                'total_harga' => $request->total_harga ?? 0,
            ]);

            foreach ($request->details as $item) {
                PurchaseOrderDetail::create([
                    'purchase_order_id' => $po->id,
                    'obat_id' => $item['obat_id'],
                    'jenis_obat' => $item['jenis_obat'],
                    'harga' => $item['harga'],
                    'jumlah' => $item['jumlah'],
                    'satuan' => $item['satuan'],
                    'subtotal' => $item['subtotal'],
                ]);
            }
            
            DB::commit();

            return redirect()->route('purchase_orders.index')
            ->with('success', 'Puerchase Order berhasil dibuat dengan No: ' . $noPO);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan PO: ' . $e->getMessage());
        }
    }
}
    

