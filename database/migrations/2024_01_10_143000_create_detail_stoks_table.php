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
        Schema::create('detail_stoks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stok_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedInteger('qty');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('stok_id')->references('id')->on('stoks')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_stoks');
    }
};