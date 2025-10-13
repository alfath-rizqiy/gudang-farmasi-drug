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

        $import = new ObatImport();
        $import->import($request->file('file'));

        $failures = $import->getFailures();

        if (!empty($failures)) {
            $errors = [];

            foreach ($failures as $failure) {
                $attribute = $failure->attribute();
                $row = $failure->row();
                $message = $failure->errors()[0];

                $errors[$attribute][] = [
                    'row' => $row,
                    'message' => $message
                ];
            }

            return response()->json([
                'message' => 'Validasi gagal pada beberapa kolom.',
                'errors' => $errors
            ], 422);

            return response()->json([
                'message' => 'Data berhasil diimport!'
            ], 200);
        }
    }
}