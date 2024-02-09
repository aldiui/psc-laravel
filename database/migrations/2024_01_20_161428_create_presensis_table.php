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
        Schema::create('presensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            $table->time('clock_in');
            $table->string('lokasi_in');
            $table->text('alasan_in')->nullable();
            $table->string('status_in')->default("0");
            $table->time('clock_out')->nullable();
            $table->string('lokasi_out')->nullable();
            $table->text('alasan_out')->nullable();
            $table->string('status_out')->default("0");
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
