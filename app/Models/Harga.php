<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;

    protected $fillable = [
        'obat_id',
        'harga_pokok',
        'margin',
        'harga_jual',
    ];

    /**
     * Relasi ke obat
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}