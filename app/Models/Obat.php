<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Supplier;
use App\Models\SatuanKecil;
use App\Models\SatuanBesar;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_obat',
        'supplier_id',
        'satuan_kecil_id',
        'satuan_besar_id'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relasi ke tabel SatuanKecil (obat memiliki satu satuan kecil)
    public function satuankecil() {
        return $this->belongsTo(SatuanKecil::class, 'satuan_kecil_id');
    }

    // Relasi ke tabel SatuanBesar (obat memiliki satu satuan besar)
    public function satuanbesar() {
        return $this->belongsTo(SatuanBesar::class, 'satuan_besar_id');
    }
}
