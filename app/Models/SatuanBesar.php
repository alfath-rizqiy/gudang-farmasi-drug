<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SatuanBesar extends Model
{
    use HasFactory;

protected $fillable = [
    'nama_satuanbesar',
    'deskripsi',
    'jumlah_satuankecil',
];

 public function obats()
    {
        return $this->hasMany(Obat::class, 'satuan_besar_id');
    }
}