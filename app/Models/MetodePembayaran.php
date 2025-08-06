<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MetodePembayaran extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi secara massal (mass assignment)
    protected $fillable = [
        'nama_metode',
        'deskripsi',
    ];

    /**
     * Relasi satu ke banyak: satu metode pembayaran bisa digunakan oleh banyak obat.
     * Menghubungkan ke tabel 'obats' dengan foreign key 'metodepembayaran_id'.
     */
    public function obats()
    {
        return $this->hasMany(Obat::class, 'metodepembayaran_id');
    }
}
