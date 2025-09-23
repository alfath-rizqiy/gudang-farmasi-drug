<?php

namespace App\Imports;

use App\Models\Obat;
use App\models\Supplier;
use App\models\Kategori;
use App\models\Kemasan;
use App\models\SatuanBesar;
use App\models\SatuanKecil;
use App\models\AturanPakai;
use App\models\MetodePembayaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;


class ObatImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        if (!array_filter($row)) {
            return null;
        }
        
        // Berdasarkan nama
        $supplier_id = Supplier::where('nama_supplier', $row['supplier'])->value('id');
        $kategori_id = Kategori::where('nama_kategori', $row['kategori'])->value('id');
        $kemasan_id = Kemasan::where('nama_kemasan', $row['kemasan'])->value('id');
        $satuan_kecil_id = SatuanKecil::where('nama_satuankecil', $row['satuan_kecil'])->value('id');
        $satuan_besar_id = SatuanBesar::where('nama_satuanbesar', $row['satuan_besar'])->value('id');
        $aturanpakai_id = AturanPakai::where('frekuensi_pemakaian', $row['aturan_pakai'])->value('id');
        $metodepembayaran_id = MetodePembayaran::where('nama_metode', $row['metode_pembayaran'])->value('id');

        return new Obat([
            'nama_obat'           => $row['nama_obat'],
            'supplier_id'         => $supplier_id,
            'kategori_id'         => $kategori_id,
            'kemasan_id'          => $kemasan_id,
            'satuan_kecil_id'     => $satuan_kecil_id,
            'satuan_besar_id'     => $satuan_besar_id,
            'aturanpakai_id'      => $aturanpakai_id,
            'metodepembayaran_id' => $metodepembayaran_id,
        ]);
    }

    /** 
     * return @int
    */
    
    public function startRow(): int
    {
        return 1;
    }

     public function rules(): array
    {
        return [
            '*.nama_obat' => 'required|string|max:255|unique:obats,nama_obat',
            '*.supplier'  => 'required|exists:suppliers,nama_supplier',
            '*.kategori'  => 'required|exists:kategoris,nama_kategori',
            '*.kemasan'  => 'required|exists:kemasans,nama_kemasan',
            '*.satuan_kecil'  => 'required|exists:satuan_kecils,nama_satuankecil',
            '*.satuan_besar'  => 'required|exists:satuan_besars,nama_satuanbesar',
            '*.aturan_pakai'  => 'required|exists:aturan_pakais,frekuensi_pemakaian',
            '*.metode_pembayaran'  => 'required|exists:metode_pembayarans,nama_metode',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nama_obat.required' => 'Nama obat wajib diisi.',
            '*.nama_obat.unique'   => 'Nama obat sudah ada di database.',

            '*.supplier.required'  => 'Supplier wajib diisi.',
            '*.supplier.exists'  => 'Supplier tidak ditemukan di tabel, silahkan cek kembali tabelnya.',

            '*.kategori.required'  => 'Kategori wajib diisi.',
            '*.kategori.exists'  => 'Kategori tidak ditemukan di tabel, silahkan cek kembali tabelnya.',

            '*.kemasan.required'  => 'Kemasan wajib diisi.',
            '*.kemasan.exists'  => 'Kemasan tidak ditemukan di tabel, silahkan cek kembali tabelnya.',

            '*.satuan_kecil.required'  => 'Satuan kecil wajib diisi.',
            '*.satuan_kecil.exists'  => 'Satuan kecil tidak ditemukan di tabel, silahkan cek kembali tabelnya.',

            '*.satuan_besar.required'  => 'Satuan besar wajib diisi.',
            '*.satuan_besar.exists'  => 'Satuan besar tidak ditemukan di tabel, silahkan cek kembali tabelnya.',
            
            '*.aturan_pakai.required'  => 'Aturan pakai wajib diisi.',
            '*.aturan_pakai.exists'  => 'Aturan pakai tidak ditemukan di tabel, silahkan cek kembali tabelnya.',

            '*.metode_pembayaran.required'  => 'Metode pembayaran wajib diisi.',
            '*.metode_pembayaran.exists'  => 'Metode pembayaran tidak ditemukan di tabel, silahkan cek kembali tabelnya.',
        ];
    }
    
}
