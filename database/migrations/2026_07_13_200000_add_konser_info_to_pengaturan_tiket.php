<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->date('tanggal_event')->nullable()->after('gambar_poster');
            $table->string('lokasi_event')->nullable()->after('tanggal_event');
            $table->string('nama_artis')->nullable()->after('lokasi_event');
            $table->text('deskripsi_artis')->nullable()->after('nama_artis');
            $table->string('gambar_artis')->nullable()->after('deskripsi_artis');
            $table->text('fasilitas_venue')->nullable()->after('gambar_artis');
            $table->text('deskripsi_section_konser')->nullable()->after('fasilitas_venue');
        });

        // Set default values for existing row
        \DB::table('pengaturan_tiket')->update([
            'tanggal_event'            => '2026-08-21',
            'lokasi_event'             => 'Kampung Inggris, Pare',
            'nama_artis'               => 'For Revenge',
            'deskripsi_artis'          => 'Band pop-punk asal Bandung yang terkenal dengan lagu-lagu hits seperti "Selamat Pagi", "Termentahkan", dan "Hari Bersamamu".',
            'fasilitas_venue'          => "Parkir Luas\nToilet Bersih\nFood Court\nMushola\nP3K\nSound System Professional",
            'deskripsi_section_konser'  => 'Saksikan penampilan spektakuler di panggung megah Brilliant English Course. Dapatkan pengalaman konser terbaik dengan fasilitas lengkap!',
        ]);
    }

    public function down(): void
    {
        Schema::table('pengaturan_tiket', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_event',
                'lokasi_event',
                'nama_artis',
                'deskripsi_artis',
                'gambar_artis',
                'fasilitas_venue',
                'deskripsi_section_konser',
            ]);
        });
    }
};
