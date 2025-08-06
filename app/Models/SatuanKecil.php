<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SatuanKecil extends Model
{
    use HasFactory;

protected $fillable = [
    'nama_satuankecil',
    'deskripsi',
];

 public function obats()
    {
        return $this->hasMany(Obat::class, 'satuan_kecil_id');
    }
}