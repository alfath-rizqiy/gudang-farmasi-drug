<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MetodePembayaran;

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =============================
// METODE PEMBAYARAN (15 data)
// =============================
DB::table('metode_pembayarans')->insert([
    [
        'nama_metode' => 'Cash',
        'deskripsi'   => 'Bayar tunai di tempat',
    ],
    [
        'nama_metode' => 'Transfer BCA',
        'deskripsi'   => 'Bayar via Bank BCA',
    ],
    [
        'nama_metode' => 'Transfer BRI',
        'deskripsi'   => 'Bayar via Bank BRI',
    ],
    [
        'nama_metode' => 'Transfer Mandiri',
        'deskripsi'   => 'Bayar via Bank Mandiri',
    ],
    [
        'nama_metode' => 'Transfer BNI',
        'deskripsi'   => 'Bayar via Bank BNI',
    ],
    [
        'nama_metode' => 'Gopay',
        'deskripsi'   => 'Bayar menggunakan Gopay',
    ],
    [
        'nama_metode' => 'OVO',
        'deskripsi'   => 'Bayar menggunakan OVO',
    ],
    [
        'nama_metode' => 'Dana',
        'deskripsi'   => 'Bayar menggunakan Dana',
    ],
    [
        'nama_metode' => 'ShopeePay',
        'deskripsi'   => 'Bayar menggunakan ShopeePay',
    ],
    [
        'nama_metode' => 'Kartu Kredit',
        'deskripsi'   => 'Bayar dengan kartu kredit',
    ],
    [
        'nama_metode' => 'Debit BCA',
        'deskripsi'   => 'Bayar debit BCA',
    ],
    [
        'nama_metode' => 'Debit Mandiri',
        'deskripsi'   => 'Bayar debit Mandiri',
    ],
    [
        'nama_metode' => 'QRIS',
        'deskripsi'   => 'Bayar via QRIS',
    ],
    [
        'nama_metode' => 'COD',
        'deskripsi'   => 'Bayar di tempat (COD)',
    ],
    [
        'nama_metode' => 'Kartu Debit Lain',
        'deskripsi'   => 'Bayar debit bank lain',
    ],
]);

    }
}
