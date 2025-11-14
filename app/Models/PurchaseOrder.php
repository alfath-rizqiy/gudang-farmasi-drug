<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_po',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Format: PO-YYYYMMDD-00001
            $today = date('Ymd');
            $latest = self::where('no_po', 'like', "PO-$today-%")
                ->orderBy('id', 'desc')
                ->first();

            $nextNumber = $latest ? ((int) substr($latest->no_po, -5)) + 1 : 1;
            $model->no_po = 'PO-' . $today . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            if (empty($model->tgl_po)) {
                $model->tgl_po = date('Y-m-d');
            }

            if (empty($model->created_by) && auth()->check()) {
            $model->created_by = auth()->id();
        }
        });
    }

    protected $dates = [
        'tgl_po',
        'tgl_kirim',
        'tgl_jatuh_tempo',
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }

    public function details()
{
    return $this->hasMany(PurchaseOrderDetail::class);
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
