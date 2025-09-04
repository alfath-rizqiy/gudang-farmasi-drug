<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SatuanBesar;

class SatuanBesarSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('satuan_besars')->insert([
            [
                'nama_satuanbesar'   => 'Box Tablet 100',
                'deskripsi'          => 'Berisi 10 strip, masing-masing 10 tablet',
                'jumlah_satuankecil' => 10,
            ],
            [
                'nama_satuanbesar'   => 'Box Kapsul 100',
                'deskripsi'          => 'Berisi 10 strip kapsul, masing-masing 10 kapsul',
                'jumlah_satuankecil' => 10,
            ],
            [
                'nama_satuanbesar'   => 'Kardus Sirup 60 ml',
                'deskripsi'          => 'Kardus berisi 50 botol sirup 60 ml',
                'jumlah_satuankecil' => 50,
            ],
            [
                'nama_satuanbesar'   => 'Kardus Sirup 100 ml',
                'deskripsi'          => 'Kardus berisi 40 botol sirup 100 ml',
                'jumlah_satuankecil' => 40,
            ],
            [
                'nama_satuanbesar'   => 'Box Ampul 1 ml',
                'deskripsi'          => 'Box berisi 100 ampul injeksi 1 ml',
                'jumlah_satuankecil' => 100,
            ],
            [
                'nama_satuanbesar'   => 'Box Ampul 2 ml',
                'deskripsi'          => 'Box berisi 100 ampul injeksi 2 ml',
                'jumlah_satuankecil' => 100,
            ],
            [
                'nama_satuanbesar'   => 'Box Strip Tablet',
                'deskripsi'          => 'Box berisi 20 strip tablet',
                'jumlah_satuankecil' => 20,
            ],
            [
                'nama_satuanbesar'   => 'Box Salep 15 gr',
                'deskripsi'          => 'Box berisi 30 tube salep 15 gr',
                'jumlah_satuankecil' => 30,
            ],
            [
                'nama_satuanbesar'   => 'Box Salep 30 gr',
                'deskripsi'          => 'Box berisi 30 tube salep 30 gr',
                'jumlah_satuankecil' => 30,
            ],
            [
                'nama_satuanbesar'   => 'Kardus Sachet 5 gr',
                'deskripsi'          => 'Kardus berisi 100 sachet serbuk 5 gr',
                'jumlah_satuankecil' => 100,
            ],
            [
                'nama_satuanbesar'   => 'Kardus Sachet 10 gr',
                'deskripsi'          => 'Kardus berisi 100 sachet serbuk 10 gr',
                'jumlah_satuankecil' => 100,
            ],
            [
                'nama_satuanbesar'   => 'Box Vial 5 ml',
                'deskripsi'          => 'Box berisi 50 vial injeksi 5 ml',
                'jumlah_satuankecil' => 50,
            ],
            [
                'nama_satuanbesar'   => 'Box Vial 10 ml',
                'deskripsi'          => 'Box berisi 50 vial injeksi 10 ml',
                'jumlah_satuankecil' => 50,
            ],
            [
                'nama_satuanbesar'   => 'Box Suppositoria',
                'deskripsi'          => 'Box berisi 25 suppositoria',
                'jumlah_satuankecil' => 25,
            ],
            [
                'nama_satuanbesar'   => 'Kardus Drop 5 ml',
                'deskripsi'          => 'Kardus berisi 60 botol tetes 5 ml',
                'jumlah_satuankecil' => 60,
            ],
        ]);
    }
}
