<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_po',
        'tgl_po',
        'tgl_kirim',
        'metode_pembayaran',
        'tgl_jatuh_tempo',
        'supplier_id',
        'status',
        'keterangan',
        'total',
        'created_by',
    ];

    protected $dates = [
        'tgl_po',
        'tgl_kirim',
        'tgl_jatuh_tempo',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }

    // 🔹 Relasi ke supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // 🔹 Relasi ke user yang membuat PO
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // 🔹 Relasi ke item PO
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id');
    }

    // 🔹 Accessor untuk format tanggal (optional)
    public function getTglPoFormatAttribute()
    {
        return $this->tgl_po ? Carbon::parse($this->tgl_po)->format('d/m/Y') : '-';
    }

    // 🔹 Accessor untuk format total
    public function getTotalFormatAttribute()
    {
        return number_format($this->total, 2, ',', '.');
    }
}
