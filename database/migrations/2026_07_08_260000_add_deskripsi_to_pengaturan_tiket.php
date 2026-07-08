<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->text('deskripsi_umum')->nullable()->after('nama_kategori_umum');
            $table->text('deskripsi_vip')->nullable()->after('nama_kategori_vip');
            $table->text('deskripsi_member')->nullable()->after('deskripsi_vip');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->dropColumn(['deskripsi_umum', 'deskripsi_vip', 'deskripsi_member']);
        });
    }
};
