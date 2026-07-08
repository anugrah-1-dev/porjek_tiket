<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom status ke tiket_konsers
        Schema::table('tiket_konsers', function (Blueprint $table) {
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending')->after('trx_id');
        });

        // Ubah enum kategori agar include 'vip' (raw SQL untuk kompatibilitas)
        DB::statement("ALTER TABLE tiket_konsers MODIFY COLUMN kategori ENUM('umum', 'member', 'vip') NOT NULL");

        // Tambah kolom ke pengaturan_tiket
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->string('nama_kategori_umum')->default('Sales 1')->after('harga_member');
            $table->unsignedBigInteger('harga_vip')->default(350000)->after('nama_kategori_umum');
            $table->string('nama_kategori_vip')->default('VIP')->after('harga_vip');
            $table->string('gambar_poster')->nullable()->after('nama_kategori_vip');
        });

        // Update row existing pengaturan_tiket
        DB::table('pengaturan_tiket')->update([
            'nama_kategori_umum' => 'Sales 1',
            'harga_vip'          => 350000,
            'nama_kategori_vip'  => 'VIP',
        ]);
    }

    public function down(): void
    {
        Schema::table('tiket_konsers', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        DB::statement("ALTER TABLE tiket_konsers MODIFY COLUMN kategori ENUM('umum', 'member') NOT NULL");

        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->dropColumn(['nama_kategori_umum', 'harga_vip', 'nama_kategori_vip', 'gambar_poster']);
        });
    }
};
