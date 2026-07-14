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
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->boolean('tampil_umum')->default(true)->after('status_umum');
            $table->boolean('tampil_vip')->default(true)->after('status_vip');
            $table->boolean('tampil_member')->default(true)->after('status_member');
            $table->boolean('tampil_spesial')->default(true)->after('status_spesial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->dropColumn(['tampil_umum', 'tampil_vip', 'tampil_member', 'tampil_spesial']);
        });
    }
};
