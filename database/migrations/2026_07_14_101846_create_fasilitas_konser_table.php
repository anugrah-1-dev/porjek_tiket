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
        Schema::create('fasilitas_konser', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaturan_tiket_id')->constrained('pengaturan_tiket')->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->string('image_path');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas_konser');
    }
};
