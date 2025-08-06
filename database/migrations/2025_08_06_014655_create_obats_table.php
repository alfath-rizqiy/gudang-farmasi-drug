<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->timestamps();

            // Supplier id akan koneksi ke id supplier dengan menggunakan Foreign Key, id akan masuk ke Obat statusnya value id lalu akan menjadi nama_supplier, sehingga yang muncul itu nama bukan id
          $table->unsignedBigInteger('supplier_id');
          $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict');

          // Relasi ke kategori
          $table->unsignedBigInteger('kategori_id');
          $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('restrict');

           // Relasi ke metode pembayaran (jika satu obat hanya punya satu metode)
          $table->unsignedBigInteger('metodepembayaran_id');
          $table->foreign('metodepembayaran_id')->references('id')->on('metode_pembayarans')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};