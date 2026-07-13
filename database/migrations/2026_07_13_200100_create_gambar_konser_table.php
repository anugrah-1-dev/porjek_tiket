<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_konser', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengaturan_tiket_id');
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('pengaturan_tiket_id')
                  ->references('id')
                  ->on('pengaturan_tiket')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_konser');
    }
};
