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
        Schema::create('hargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->decimal('harga_pokok', 15, 2);
            $table->decimal('margin', 15, 2)->default(0);
            $table->decimal('ppn', 15, 2)->default(0); // ✅ Tambah kolom ppn
            $table->decimal('harga_jual', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hargas');
    }
};
