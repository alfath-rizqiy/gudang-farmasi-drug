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
        Schema::create('satuan_besars', function (Blueprint $table) {
            $table->id();
            $table->string('nama_satuanbesar');
            $table->text('deskripsi')->nullable();
            $table->string('jumlah_satuankecil')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satuan_besars');
    }
};