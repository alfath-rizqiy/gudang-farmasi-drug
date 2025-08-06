<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Supplier;
use App\Models\Kemasan;
use App\Models\AturanPakai;

class Obat extends Model
{
    // Mengaktifkan fitur factory untuk model ini
    use HasFactory;

    /**
     * Menentukan atribut yang dapat diisi secara massal.
     * Digunakan saat melakukan create/update agar hanya field ini yang bisa diisi.
     */
    protected $fillable = [
        'nama_obat', 
        'supplier_id', //yang kaya gini tu id relasi ke tabel tersebut
        'kemasan_id',
        'aturanpakai_id',
    ];

    /**
     * Relasi many-to-one ke model tersebut.
     * Setiap model obat memiliki satu model tsb.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function kemasan() {
        return $this->belongsTo(Kemasan::class);
    }

    //pake 'aturanpakai_id' biar laravelnya baca, soalnya ini ga pake underscore kaya bawaan laravel
    public function aturanpakai() {
        return $this->belongsTo(AturanPakai::class, 'aturanpakai_id');
    }
}
