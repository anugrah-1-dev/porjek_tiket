<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanTiket extends Model
{
    protected $table = 'pengaturan_tiket';

    protected $fillable = [
        'harga_per_tiket',
    ];

    /**
     * Ambil baris pengaturan (selalu baris pertama / satu-satunya).
     */
    public static function get(): self
    {
        return static::firstOrCreate([], ['harga_per_tiket' => 100000]);
    }
}
