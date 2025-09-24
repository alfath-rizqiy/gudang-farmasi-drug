<?php

namespace App\Exports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ObatExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Obat::with([
        'supplier',
        'kategori',
        'kemasan',
        'aturanpakai',
        'satuanBesar',
        'satuanKecil',
        'metodepembayaran'
        ])->get()->map(function ($obat) {
            return [
            'id'                => $obat->id,
            'nama_obat'         => $obat->nama_obat,
            'supplier'          => $obat->supplier ? $obat->supplier->nama_supplier : '-',
            'kategori'          => $obat->kategori ? $obat->kategori->nama_kategori : '-',
            'kemasan'           => $obat->kemasan ? $obat->kemasan->nama_kemasan : '-',
            'aturanpakai'       => $obat->aturanpakai ? $obat->aturanpakai->frekuensi_pemakaian : '-',
            'satuan_kecil'      => $obat->satuanKecil ? $obat->satuanKecil->nama_satuankecil : '-',
            'satuan_besar'      => $obat->satuanBesar ? $obat->satuanBesar->nama_satuanbesar : '-',
            'metode_pembayaran' => $obat->metodepembayaran ? $obat->metodepembayaran->nama_metode : '-',
            'created_at'        => $obat->created_at,
            'foto'              => $obat->foto,
            ];
        });
    }

    public function headings(): array
    {
        return[
            ['Data Obat'],
            [
                'No',
                'Nama Obat',
                'Supplier',
                'kategori',
                'Kemasan',
                'Aturan Pakai',
                'Satuan Kecil',
                'Satuan Besar',
                'Metode Pembayaran',
                'Tanggal Masuk',
                'Foto'
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:I1');

        return [
            1 => [
                'font'      => ['bold' => true],
                'alignment' => ['horizontal' => 'center'],
            ],
            
            2 => [
                'font'      => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ],
        ];
    }

    public function drawings()
    {
    $drawings = [];
    $row = 3; // karena row 1 = judul, row 2 = header

    foreach ($this->obatData as $obat) {
        if ($obat->foto && file_exists(public_path('storage/' . $obat->foto))) {
            $drawing = new Drawing();
            $drawing->setName($obat->nama_obat);
            $drawing->setDescription("Foto " . $obat->nama_obat);
            $drawing->setPath(public_path('storage/' . $obat->foto)); // ✅ sama persis dengan data-foto
            $drawing->setHeight(60);
            $drawing->setCoordinates('J' . $row); // kolom Foto
            $drawings[] = $drawing;
        }
        $row++;
    }

    return $drawings;
    }

}
