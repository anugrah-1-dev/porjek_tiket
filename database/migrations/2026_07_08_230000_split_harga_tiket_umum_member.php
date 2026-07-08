<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->unsignedBigInteger('harga_umum')->default(150000)->after('id');
            $table->unsignedBigInteger('harga_member')->default(100000)->after('harga_umum');
        });

        // Isi nilai awal
        DB::table('pengaturan_tiket')->update([
            'harga_umum'   => 150000,
            'harga_member' => 100000,
        ]);

        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->dropColumn('harga_per_tiket');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->unsignedBigInteger('harga_per_tiket')->default(100000)->after('id');
            $table->dropColumn(['harga_umum', 'harga_member']);
        });
    }
};
