<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->string('nama_kategori_member')->default('Tiket - WARGA PARE')->after('harga_member');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->dropColumn('nama_kategori_member');
        });
    }
};
