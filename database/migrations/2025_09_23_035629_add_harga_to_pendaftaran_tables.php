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
        Schema::table('pendaftaran_catering', function (Blueprint $table) {
            $table->decimal('harga', 15, 2)->default(0)->after('jumlah_porsi');
        });

        Schema::table('pendaftaran_laundry', function (Blueprint $table) {
            $table->decimal('harga', 15, 2)->default(0)->after('jumlah');
        });

        Schema::table('pendaftaran_holiday', function (Blueprint $table) {
            $table->decimal('harga', 15, 2)->default(0)->after('jumlah_peserta');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_catering', function (Blueprint $table) {
            $table->dropColumn('harga');
        });

        Schema::table('pendaftaran_laundry', function (Blueprint $table) {
            $table->dropColumn('harga');
        });

        Schema::table('pendaftaran_holiday', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
};
