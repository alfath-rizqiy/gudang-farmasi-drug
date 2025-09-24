<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AturanPakai;

class AturanPakaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Supplier
        DB::table('aturan_pakais')->insert([
            ['frekuensi_pemakaian' => '1x sehari', 
             'waktu_pemakaian' => 'Pagi', 
             'deskripsi' => 'Diminum sekali sehari'
            ],

            ['frekuensi_pemakaian' => '2x sehari', 
             'waktu_pemakaian' => 'Pagi & Malam', 
             'deskripsi' => 'Diminum dua kali sehari'
            ],

            ['frekuensi_pemakaian' => '3x sehari', 
             'waktu_pemakaian' => 'Pagi, Siang, Malam', 
              'deskripsi' => 'Diminum tiga kali sehari'
            ],

            ['frekuensi_pemakaian' => '4x sehari', 
             'waktu_pemakaian' => 'Setiap 6 jam', 
             'deskripsi' => 'Diminum setiap 6 jam'
            ],

            ['frekuensi_pemakaian' => 'Sebelum makan', 
             'waktu_pemakaian' => '30 menit sebelum makan', 
              'deskripsi' => 'Obat diminum sebelum makan'
            ],

            ['frekuensi_pemakaian' => 'Sesudah makan', 
             'waktu_pemakaian' => '5 menit setelah makan', 
              'deskripsi' => 'Obat diminum setelah makan'
            ],

            ['frekuensi_pemakaian' => 'Saat diperlukan', 
             'waktu_pemakaian' => 'Jika terasa gejala', 
             'deskripsi' => 'Obat diminum sesuai kebutuhan'
            ], 

            ['frekuensi_pemakaian' => 'Malam hari', 
             'waktu_pemakaian' => 'Sebelum tidur', 
             'deskripsi' => 'Obat diminum sebelum tidur'
            ],

            ['frekuensi_pemakaian' => 'Pagi dan sore', 
             'waktu_pemakaian' => 'Pagi & Sore', 
             'deskripsi' => 'Diminum dua kali sehari'
            ],

            ['frekuensi_pemakaian' => 'Setiap 12 jam', 
             'waktu_pemakaian' => 'Pagi & Malam', 
             'deskripsi' => 'Diminum tiap 12 jam'
            ],

            ['frekuensi_pemakaian' => 'Setiap 2 hari', 
             'waktu_pemakaian' => 'Sore', 
             'deskripsi' => 'Diminum dua hari sekali'
            ],

            ['frekuensi_pemakaian' => 'Sekali seminggu', 
             'waktu_pemakaian' => 'Hari Minggu', 
             'deskripsi' => 'Diminum seminggu sekali'
            ],

            ['frekuensi_pemakaian' => 'Setiap 8 jam', 
             'waktu_pemakaian' => 'Pagi, Siang, Malam', 
             'deskripsi' => 'Obat diminum tiap 8 jam'
            ],

            ['frekuensi_pemakaian' => 'Tiap 6 jam', 
             'waktu_pemakaian' => '24 jam penuh', 
             'deskripsi' => 'Diminum tiap 6 jam sekali'
            ],

            ['frekuensi_pemakaian' => 'Sesuai resep dokter', 
             'waktu_pemakaian' => 'Kapan saja', 
             'deskripsi' => 'Ikuti resep dokter'
            ]
        ]);
    }
}
