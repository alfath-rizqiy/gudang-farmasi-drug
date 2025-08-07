<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Supplier;
use App\Models\Kemasan;
use App\Models\AturanPakai;
use App\Models\SatuanKecil;
use App\Models\SatuanBesar;
use App\Models\Kategori;
use App\Models\MetodePembayaran;

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
        'supplier_id',
        'kemasan_id',
        'aturanpakai_id',
        'satuan_kecil_id',
        'satuan_besar_id',
        'kategori_id',
        'metodepembayaran_id',
    ];

    /**
     * Relasi ke tabel Supplier: setiap obat dimiliki oleh satu supplier.
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

    // Relasi ke tabel SatuanKecil (obat memiliki satu satuan kecil)
    public function satuankecil() {
        return $this->belongsTo(SatuanKecil::class, 'satuan_kecil_id');
    }

    // Relasi ke tabel SatuanBesar (obat memiliki satu satuan besar)
    public function satuanbesar() {
        return $this->belongsTo(SatuanBesar::class, 'satuan_besar_id');
    }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function metodepembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metodepembayaran_id');
    }
}
