<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_tiket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('harga_per_tiket')->default(100000);
            $table->timestamps();
        });

        // Insert satu baris default
        DB::table('pengaturan_tiket')->insert([
            'harga_per_tiket' => 100000,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_tiket');
    }
};
