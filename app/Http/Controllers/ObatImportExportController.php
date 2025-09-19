<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ObatExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ObatImport;
use Maatwebsite\Excel\Validators\ValidationException;

class ObatImportExportController extends Controller
{
    public function export()
    {
        $tanggal = now()->format('Y-m-d');
        $filename = "Data Obat {$tanggal}.xlsx";

        return Excel::download(new ObatExport, $filename, );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ], [
            'file.required' => 'File wajib diupload.',
            'file.mimes' => 'Format file harus .xlsx atau .xls.',
        ]);

        try {
            Excel::import(new ObatImport, $request->file('file'));
            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil diimport!'
            ]);
        } catch (ValidationException $e) {
            $failures = $e->failures();
            $messages = [];

            foreach ($failures as $failure) {
                $messages[] = "Baris {$failure->row()} kolom {$failure->attribute()}: " . implode(', ', $failure->errors());
            }

            return response()->json([
                'success' => false,
                'message' => implode('<br>', $messages)
            ], 422);
        }
    }
}
