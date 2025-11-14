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
       if (!Schema::hasTable('purchase_order_details')) {
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('obat_id');
            $table->string('jenis_obat')->nullable();
            $table->decimal('harga', 15, 2)->default(0);
            $table->integer('jumlah')->default(0);
            $table->string('satuan')->nullable();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('obat_id')->references('id')->on('obats')->onDelete('restrict');
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_details');
    }
};
