<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kemasan extends Model{
    
// Mengaktifkan fitur factory untuk model ini    
use HasFactory;

/**
     * Menentukan atribut yang dapat diisi secara massal.
     * Digunakan saat melakukan create/update agar hanya field ini yang bisa diisi.
     */
protected $fillable = [
    'nama_kemasan',  // Nama jenis kemasan (misalnya: botol, strip, blister)
    'tanggal_produksi',  // Tanggal produksi obat
    'tanggal_kadaluarsa', // Tanggal kadaluarsa obat
    'petunjuk_penyimpanan', // Instruksi penyimpanan (misalnya: simpan di tempat sejuk)
];

/**
* Relasi one-to-many dengan model Obat.
* Satu kemasan bisa digunakan oleh banyak obat.
* Foreign key di tabel obat: kemasan_id
*/
 public function obats()
    {
        return $this->hasMany(Obat::class);
    }

}
