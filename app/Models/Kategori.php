<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal (mass assignment)
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Relasi satu ke banyak: satu kategori bisa punya banyak obat.
     * Menghubungkan ke tabel 'obats' dengan foreign key 'kategori_id'.
     */
    public function obats()
    {
        return $this->hasMany(Obat::class, 'kategori_id');
    }
}
