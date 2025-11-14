<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Supplier;


class PurchaseOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_details';

    protected $fillable = [
        'purchase_order_id',
        'obat_id',
        'jenis_obat',
        'harga',
        'jumlah',
        'satuan',
        'subtotal',
        'keterangan',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
