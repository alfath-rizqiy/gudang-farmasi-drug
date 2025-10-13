<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara mass-assignment
    // PPN ditambahkan agar nilai pajak bisa tersimpan di database
    protected $fillable = [
        'obat_id',
        'harga_pokok',
        'margin',
        'ppn', // kolom pajak 11%
        'harga_jual',
    ];

    // Relasi ke tabel obat (setiap harga terkait dengan satu obat)
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}
