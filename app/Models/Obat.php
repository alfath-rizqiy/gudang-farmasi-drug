<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Supplier;
use App\Models\Kategori;
use App\Models\MetodePembayaran;

class Obat extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal (mass assignment)
    protected $fillable = [
        'nama_obat',
        'supplier_id',
        'kategori_id',
        'metodepembayaran_id',
    ];

    /**
     * Relasi ke tabel Supplier: setiap obat dimiliki oleh satu supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relasi ke tabel Kategori: setiap obat termasuk dalam satu kategori.
     * Menggunakan foreign key 'kategori_id'.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke tabel MetodePembayaran: setiap obat memiliki satu metode pembayaran.
     * Menggunakan foreign key 'metodepembayaran_id'.
     */
    public function metodepembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metodepembayaran_id');
    }
}
