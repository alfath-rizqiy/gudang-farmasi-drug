<?php

namespace App\Exports;

use App\Models\Kemasan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KemasanExport implements FromCollection, WithHeadings, WithStyles,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kemasan::all();
    }

    public function headings(): array
    {
        return[
            [' Data Kemasan' ],
            [
                'No',
                'Nama Kemasan',
                'Tanggal Produksi',
                'Tanggal Kadaluarsa',
                'Petunjuk Penyimpanan'
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
}
