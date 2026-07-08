<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah enum 'spesial' ke kategori tiket
        DB::statement("ALTER TABLE tiket_konsers MODIFY COLUMN kategori ENUM('umum','member','vip','spesial') NOT NULL");

        // Tambah kolom kategori spesial ke pengaturan_tiket
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->string('nama_kategori_spesial')->default('Member Juli-Agustus')->after('deskripsi_member');
            $table->unsignedBigInteger('harga_spesial')->default(0)->after('nama_kategori_spesial');
            $table->text('deskripsi_spesial')->nullable()->after('harga_spesial');
        });

        DB::table('pengaturan_tiket')->update([
            'nama_kategori_spesial' => 'Member Juli-Agustus',
            'harga_spesial'         => 0,
        ]);
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE tiket_konsers MODIFY COLUMN kategori ENUM('umum','member','vip') NOT NULL");

        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->dropColumn(['nama_kategori_spesial', 'harga_spesial', 'deskripsi_spesial']);
        });
    }
};
