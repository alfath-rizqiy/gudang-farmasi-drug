<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SupplierExport implements FromCollection, WithHeadings, WithStyles,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Supplier::all();
    }

    public function headings(): array
    {
        return[
            [' Data Supplier'],
            [
                'No',
                'Nama Supplier',
                'Telepon',
                'Email',
                'Alamat'
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
