<?php

namespace App\Exports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;

class ObatExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Untuk memunculkan data dengan inputan nama di Excel
        return Obat::with(['supplier', 'kategori', 'satuanBesar', 'satuanKecil'])->get()->map(function ($obat) {
        return [
            'Nama Obat'         => $obat->nama_obat,
            'Supplier'          => $obat->supplier ? $obat->supplier->nama_supplier : '-',
            'Kemasan'           => $obat->kemasan ? $obat->kemasan->nama_kemasan : '-',
            'Satuan Kecil'      => $obat->satuankecil ? $obat->satuanKecil->nama_satuankecil : '-',
            'Satuan Besar'      => $obat->satuanbesar ? $obat->satuanBesar->nama_satuanbesar : '-',
            'Aturan Pakai'      => $obat->aturanpakai ? $obat->aturanpakai->frekuensi_pemakaian : '-',
            'Kategori'          => $obat->kategori ? $obat->kategori->nama_kategori : '-',
            'Metode Pembayaran' => $obat->metodepembayaran ? $obat->metodepembayaran->nama_metode : '-',
            'Tanggal Masuk'     => $obat->created_at ? $obat->created_at->format('d F Y') : '-',
        ];
    });
    }
}
