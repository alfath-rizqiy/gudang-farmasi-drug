<?php

namespace App\Imports;

use App\Models\Obat;
use App\models\Supplier;
use App\models\Kategori;
use App\models\Kemasan;
use App\models\SatuanBesar;
use App\models\SatuanKecil;
use App\models\AturanPakai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
// use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;



class ObatImport implements ToModel, WithHeadingRow
{
    use Importable;

    protected $failures = [];
    protected $rowNumber = 1;

    public function model(array $row)
    {
        $this->rowNumber++;

        // cek nama serupa
        $exists = Obat::where('nama_obat', $row['nama_obat'])->first();

        if ($exists) {
            return null; // jika serupa lewatin ajah
        }

        // ====== VALIDASI MANUAL ======
        $this->validateColumn($row, 'nama_obat', 'Nama obat wajib diisi.');
        $this->validateColumn($row, 'supplier', 'Supplier wajib diisi.');
        $this->validateColumn($row, 'kategori', 'Kategori wajib diisi.');
        $this->validateColumn($row, 'kemasan', 'Kemasan wajib diisi.');
        $this->validateColumn($row, 'satuan_kecil', 'Satuan kecil wajib diisi.');
        $this->validateColumn($row, 'satuan_besar', 'Satuan besar wajib diisi.');
        $this->validateColumn($row, 'aturan_pakai', 'Aturan pakai wajib diisi.');

        // Jika kolom ada tapi tidak ditemukan di tabel referensi
        $this->checkExist($row, 'supplier', Supplier::class, 'nama_supplier', 'Supplier tidak ditemukan.');
        $this->checkExist($row, 'kategori', Kategori::class, 'nama_kategori', 'Kategori tidak ditemukan.');
        $this->checkExist($row, 'kemasan', Kemasan::class, 'nama_kemasan', 'Kemasan tidak ditemukan.');
        $this->checkExist($row, 'satuan_kecil', SatuanKecil::class, 'nama_satuankecil', 'Satuan kecil tidak ditemukan.');
        $this->checkExist($row, 'satuan_besar', SatuanBesar::class, 'nama_satuanbesar', 'Satuan besar tidak ditemukan.');
        $this->checkExist($row, 'aturan_pakai', AturanPakai::class, 'frekuensi_pemakaian', 'Aturan pakai tidak ditemukan.');

        // Jika ada error di baris ini, lewati
        if ($this->hasFailuresForRow($this->rowNumber)) return null;
        
        // Berdasarkan nama
        $supplier_id = Supplier::where('nama_supplier', $row['supplier'])->value('id');
        $kategori_id = Kategori::where('nama_kategori', $row['kategori'])->value('id');
        $kemasan_id = Kemasan::where('nama_kemasan', $row['kemasan'])->value('id');
        $satuan_kecil_id = SatuanKecil::where('nama_satuankecil', $row['satuan_kecil'])->value('id');
        $satuan_besar_id = SatuanBesar::where('nama_satuanbesar', $row['satuan_besar'])->value('id');
        $aturanpakai_id = AturanPakai::where('frekuensi_pemakaian', $row['aturan_pakai'])->value('id');

        return new Obat([
            'nama_obat'           => $row['nama_obat'],
            'supplier_id'         => $supplier_id,
            'kategori_id'         => $kategori_id,
            'kemasan_id'          => $kemasan_id,
            'satuan_kecil_id'     => $satuan_kecil_id,
            'satuan_besar_id'     => $satuan_besar_id,
            'aturanpakai_id'      => $aturanpakai_id,
            'deskripsi_obat'      => !empty($row['deskripsi']) ? $row['deskripsi'] : null,
        ]);
    }

    private function validateColumn($row, $column, $message)
    {
        if (empty($row[$column])) {
            $this->failures[] = new Failure($this->rowNumber, $column, [$message], $row);
        }
    }

    private function checkExist($row, $column, $model, $field, $message)
    {
        if (!empty($row[$column]) && !$model::where($field, $row[$column])->exists()) {
            $this->failures[] = new Failure($this->rowNumber, $column, [$message], $row);
        }
    }
    
    private function hasFailuresForRow($rowNumber)
    {
        foreach ($this->failures as $failure) {
            if ($failure->row() === $rowNumber) return true;
        }
        return false;
    }

    public function getFailures()
    {
        return $this->failures;
    }
    
}
