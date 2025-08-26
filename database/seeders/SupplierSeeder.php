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
            ]

            ]);
    }
}
