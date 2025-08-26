<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =============================
        // KATEGORI (15 data)
        // =============================
        DB::table('kategoris')->insert([
            ['nama_kategori' => 'Antibiotik', 
             'deskripsi' => 'Obat untuk membunuh bakteri'
            ],

            ['nama_kategori' => 'Analgesik', 
             'deskripsi' => 'Obat pereda nyeri'
            ],

            ['nama_kategori' => 'Vitamin', 
             'deskripsi' => 'Suplemen vitamin harian'
            ],

            ['nama_kategori' => 'Antipiretik', 
             'deskripsi' => 'Obat penurun demam'
            ],

            ['nama_kategori' => 'Antihistamin', 
             'deskripsi' => 'Obat alergi'
            ],

            ['nama_kategori' => 'Antijamur', 
             'deskripsi' => 'Obat untuk infeksi jamur'
            ],

            ['nama_kategori' => 'Antivirus', 
             'deskripsi' => 'Obat melawan virus'
            ],

            ['nama_kategori' => 'Obat Batuk', 
             'deskripsi' => 'Meredakan batuk'
            ],

            ['nama_kategori' => 'Obat Pencernaan', 
             'deskripsi' => 'Obat masalah pencernaan'
            ],

            ['nama_kategori' => 'Obat Jantung', 
             'deskripsi' => 'Terapi penyakit jantung'
            ],

            ['nama_kategori' => 'Obat Mata', 
             'deskripsi' => 'Tetes mata dan salep'
            ],

            ['nama_kategori' => 'Obat Tidur', 
             'deskripsi' => 'Membantu tidur nyenyak'
            ],

            ['nama_kategori' => 'Obat Diabetes', 
             'deskripsi' => 'Mengontrol kadar gula'
            ],

            ['nama_kategori' => 'Obat Hipertensi', 
             'deskripsi' => 'Mengontrol tekanan darah'
            ],

            ['nama_kategori' => 'Obat Alergi', 
             'deskripsi' => 'Mengurangi gejala alergi'
            ], 
        ]);

    }
}
