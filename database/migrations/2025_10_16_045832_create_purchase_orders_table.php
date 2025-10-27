<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_po')->unique(); // contoh: POD25102300001
            $table->date('tgl_po');               // tanggal pembuatan PO
            $table->date('tgl_kirim')->nullable(); // tanggal kirim barang
            $table->string('metode_pembayaran', 50)->nullable(); // Cash / Tempo / L/C
            $table->date('tgl_jatuh_tempo')->nullable(); // tanggal jatuh tempo pembayaran
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->enum('status', ['OPEN', 'CLOSED'])->default('OPEN');
            $table->decimal('total', 20, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
