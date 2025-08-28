<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Supplier
        DB::table('suppliers')->insert([
            [
                'nama_supplier' => 'Kimia Farma',
                'telepon'       => '085893432877',
                'email'         => 'kimiafarma@gmail.com',
                'alamat'        => 'Bandung'
            ],
            [
                'nama_supplier' => 'Apotek Ku',
                'telepon'       => '085893432827',
                'email'         => 'apotekku01@gmail.com',
                'alamat'        => 'Bandung'
            ],
            [
                'nama_supplier' => 'Mandiri Medika',
                'telepon'       => '082134567890',
                'email'         => 'mandirimedika@gmail.com',
                'alamat'        => 'Jakarta'
            ],
            [
                'nama_supplier' => 'Sehat Sentosa',
                'telepon'       => '081245678912',
                'email'         => 'sehatsentosa@gmail.com',
                'alamat'        => 'Surabaya'
            ],
            [
                'nama_supplier' => 'Farmasi Jaya',
                'telepon'       => '082145678933',
                'email'         => 'farmasijaya@gmail.com',
                'alamat'        => 'Semarang'
            ],
            [
                'nama_supplier' => 'Apotek Sejahtera',
                'telepon'       => '081356789024',
                'email'         => 'apoteksejahtera@gmail.com',
                'alamat'        => 'Yogyakarta'
            ],
            [
                'nama_supplier' => 'Medika Utama',
                'telepon'       => '085267890123',
                'email'         => 'medikautama@gmail.com',
                'alamat'        => 'Bandar Lampung'
            ],
            [
                'nama_supplier' => 'Prima Farma',
                'telepon'       => '082378901245',
                'email'         => 'primafarma@gmail.com',
                'alamat'        => 'Makassar'
            ],
            [
                'nama_supplier' => 'Apotek Nusantara',
                'telepon'       => '083489012356',
                'email'         => 'apoteknusantara@gmail.com',
                'alamat'        => 'Medan'
            ],
            [
                'nama_supplier' => 'Obat Kita',
                'telepon'       => '081490123467',
                'email'         => 'obatkita@gmail.com',
                'alamat'        => 'Denpasar'
            ],
            [
                'nama_supplier' => 'Apotek Bersama',
                'telepon'       => '085601234578',
                'email'         => 'apotekbersama@gmail.com',
                'alamat'        => 'Palembang'
            ],
            [
                'nama_supplier' => 'Sehat Abadi',
                'telepon'       => '082712345689',
                'email'         => 'sehatabadi@gmail.com',
                'alamat'        => 'Pontianak'
            ],
            [
                'nama_supplier' => 'Medika Nusantara',
                'telepon'       => '083823456790',
                'email'         => 'medikanusantara@gmail.com',
                'alamat'        => 'Manado'
            ],
            [
                'nama_supplier' => 'Apotek Global',
                'telepon'       => '081934567801',
                'email'         => 'apotekglobal@gmail.com',
                'alamat'        => 'Balikpapan'
            ],
            [
                'nama_supplier' => 'Citra Medika',
                'telepon'       => '085945678912',
                'email'         => 'citramedika@gmail.com',
                'alamat'        => 'Padang'
            ],
        ]);
    }
}
