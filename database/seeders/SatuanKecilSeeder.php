<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SatuanKecil;

class SatuanKecilSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('satuan_kecils')->insert([
            [
                'nama_satuankecil' => 'Tablet',
                'deskripsi'        => 'Satuan terkecil dalam bentuk tablet',
            ],
            [
                'nama_satuankecil' => 'Kapsul',
                'deskripsi'        => 'Satuan terkecil dalam bentuk kapsul',
            ],
            [
                'nama_satuankecil' => 'Botol 60 ml',
                'deskripsi'        => 'Botol sirup cair ukuran 60 ml',
            ],
            [
                'nama_satuankecil' => 'Botol 100 ml',
                'deskripsi'        => 'Botol sirup cair ukuran 100 ml',
            ],
            [
                'nama_satuankecil' => 'Ampul 1 ml',
                'deskripsi'        => 'Ampul injeksi ukuran 1 ml',
            ],
            [
                'nama_satuankecil' => 'Ampul 2 ml',
                'deskripsi'        => 'Ampul injeksi ukuran 2 ml',
            ],
            [
                'nama_satuankecil' => 'Strip 10 tablet',
                'deskripsi'        => 'Strip berisi 10 tablet',
            ],
            [
                'nama_satuankecil' => 'Tube 15 gr',
                'deskripsi'        => 'Tube salep dengan berat 15 gr',
            ],
            [
                'nama_satuankecil' => 'Tube 30 gr',
                'deskripsi'        => 'Tube salep dengan berat 30 gr',
            ],
            [
                'nama_satuankecil' => 'Sachet 5 gr',
                'deskripsi'        => 'Sachet serbuk dosis 5 gr',
            ],
            [
                'nama_satuankecil' => 'Sachet 10 gr',
                'deskripsi'        => 'Sachet serbuk dosis 10 gr',
            ],
            [
                'nama_satuankecil' => 'Vial 5 ml',
                'deskripsi'        => 'Vial injeksi ukuran 5 ml',
            ],
            [
                'nama_satuankecil' => 'Vial 10 ml',
                'deskripsi'        => 'Vial injeksi ukuran 10 ml',
            ],
            [
                'nama_satuankecil' => 'Suppositoria',
                'deskripsi'        => 'Obat padat untuk penggunaan rektal',
            ],
            [
                'nama_satuankecil' => 'Drop 5 ml',
                'deskripsi'        => 'Botol tetes obat cair 5 ml',
            ],
        ]);
    }
}
