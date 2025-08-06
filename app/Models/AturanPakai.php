<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AturanPakai extends Model{
    
// Mengaktifkan fitur factory untuk model ini   
use HasFactory;

/**
 * Menentukan atribut yang dapat diisi secara massal.
 * Digunakan saat melakukan create/update agar hanya field ini yang bisa diisi.
 */
protected $fillable = [
    'frekuensi_pemakaian', // Frekuensi penggunaan obat (misalnya: 3x sehari)
    'waktu_pemakaian', // Waktu penggunaan obat (misalnya: pagi, siang, malam)
    'deskripsi', // Deskripsi tambahan (opsional)
];

 /**
     * Relasi one-to-many dengan model Obat.
     * Satu aturan pakai bisa digunakan oleh banyak obat.
     * Foreign key di tabel obat: aturanpakai_id
     */
 public function obats()
    {
        return $this->hasMany(Obat::class,'aturanpakai_id') ; //pake 'aturanpakai_id' biar laravelnya baca, soalnya ini ga pake underscore kaya bawaan laravel
    }

}