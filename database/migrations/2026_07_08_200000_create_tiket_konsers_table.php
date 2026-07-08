<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket_konsers', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['umum', 'member']);
            $table->string('nama_lengkap');
            $table->string('ttl');
            $table->string('no_hp');
            $table->unsignedInteger('jumlah_tiket');
            $table->unsignedBigInteger('total_harga');
            $table->string('bukti_pembayaran'); // path: tiket_konser/filename.jpg
            $table->string('bukti_member')->nullable(); // path: tiket_konser/filename.jpg
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket_konsers');
    }
};
