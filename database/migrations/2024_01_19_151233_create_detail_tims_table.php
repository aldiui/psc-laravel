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
        Schema::create('detail_tims', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tim_id');
            $table->unsignedBigInteger('user_id');
            $table->string('posisi');
            $table->timestamps();

            $table->foreign('tim_id')->references('id')->on('tims')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_tims');
    }
};
