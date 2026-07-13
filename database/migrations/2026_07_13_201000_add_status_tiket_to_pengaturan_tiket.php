<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->string('status_umum')->default('tersedia')->after('deskripsi_umum');
            $table->string('status_vip')->default('tersedia')->after('deskripsi_vip');
            $table->string('status_member')->default('tersedia')->after('deskripsi_member');
            $table->string('status_spesial')->default('tersedia')->after('deskripsi_spesial');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->dropColumn(['status_umum', 'status_vip', 'status_member', 'status_spesial']);
        });
    }
};
