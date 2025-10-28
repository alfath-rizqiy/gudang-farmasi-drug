<?php

namespace App\Exports;

use App\Models\AturanPakai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AturanPakaiExport implements FromCollection, WithHeadings, WithStyles,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AturanPakai::all();
    }

    public function headings(): array
    {
        return[
            [ 'Data Aturan Pakai' ],
            [
                'No',
                'Frekuensi Pemakaian',
                'Waktu Pemakaian',
                'Deskripsi'
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
