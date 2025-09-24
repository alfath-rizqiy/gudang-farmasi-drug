<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kemasan;

class KemasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kemasans')->insert([
            [
                'nama_kemasan' => 'Strip 10 Tablet',
                'tanggal_produksi' => '2024-01-10',
                'tanggal_kadaluarsa' => '2026-01-10',
                'petunjuk_penyimpanan' => 'Simpan di tempat sejuk'
            ],
            [
                'nama_kemasan' => 'Botol 60 ml',
                'tanggal_produksi' => '2024-02-15',
                'tanggal_kadaluarsa' => '2025-02-15',
                'petunjuk_penyimpanan' => 'Hindari sinar matahari'
            ],
            [
                'nama_kemasan' => 'Botol 100 ml',
                'tanggal_produksi' => '2024-03-05',
                'tanggal_kadaluarsa' => '2025-03-05',
                'petunjuk_penyimpanan' => 'Kocok sebelum digunakan'
            ],
            [
                'nama_kemasan' => 'Box 12 Sachet',
                'tanggal_produksi' => '2024-04-20',
                'tanggal_kadaluarsa' => '2025-04-20',
                'petunjuk_penyimpanan' => 'Simpan di tempat kering'
            ],
            [
                'nama_kemasan' => 'Box 6 Strip',
                'tanggal_produksi' => '2024-05-12',
                'tanggal_kadaluarsa' => '2026-05-12',
                'petunjuk_penyimpanan' => 'Jauhkan dari anak-anak'
            ],
            [
                'nama_kemasan' => 'Tube 15 gr',
                'tanggal_produksi' => '2024-06-01',
                'tanggal_kadaluarsa' => '2025-06-01',
                'petunjuk_penyimpanan' => 'Tutup rapat setelah digunakan'
            ],
            [
                'nama_kemasan' => 'Tube 30 gr',
                'tanggal_produksi' => '2024-07-15',
                'tanggal_kadaluarsa' => '2025-07-15',
                'petunjuk_penyimpanan' => 'Simpan suhu ruang'
            ],
            [
                'nama_kemasan' => 'Box 3 Ampul',
                'tanggal_produksi' => '2024-08-10',
                'tanggal_kadaluarsa' => '2025-08-10',
                'petunjuk_penyimpanan' => 'Simpan dalam lemari pendingin'
            ],
            [
                'nama_kemasan' => 'Vial 10 ml',
                'tanggal_produksi' => '2024-09-05',
                'tanggal_kadaluarsa' => '2025-09-05',
                'petunjuk_penyimpanan' => 'Hanya untuk injeksi'
            ],
            [
                'nama_kemasan' => 'Jar 50 gr',
                'tanggal_produksi' => '2024-10-01',
                'tanggal_kadaluarsa' => '2025-10-01',
                'petunjuk_penyimpanan' => 'Simpan suhu ruang'
            ],
            [
                'nama_kemasan' => 'Jar 100 gr',
                'tanggal_produksi' => '2024-10-15',
                'tanggal_kadaluarsa' => '2025-10-15',
                'petunjuk_penyimpanan' => 'Gunakan sendok bersih'
            ],
            [
                'nama_kemasan' => 'Box 10 Kapsul',
                'tanggal_produksi' => '2024-11-01',
                'tanggal_kadaluarsa' => '2026-11-01',
                'petunjuk_penyimpanan' => 'Jauhkan dari panas'
            ],
            [
                'nama_kemasan' => 'Box 20 Tablet',
                'tanggal_produksi' => '2024-12-01',
                'tanggal_kadaluarsa' => '2026-12-01',
                'petunjuk_penyimpanan' => 'Jauhkan dari panas'
            ]
        ]);
    }
}
