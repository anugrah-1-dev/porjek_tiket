<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tiket_konsers', function (Blueprint $table) {
            // Periode member: contoh "Januari 2025 - Januari 2026" (isian bebas)
            $table->string('periode_member')->nullable()->after('bukti_member');
        });
    }

    public function down(): void
    {
        Schema::table('tiket_konsers', function (Blueprint $table) {
            $table->dropColumn('periode_member');
        });
    }
};
