<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanTiket extends Model
{
    protected $table = 'pengaturan_tiket';

    protected $fillable = [
        'harga_umum',
        'harga_member',
        'nama_kategori_umum',
        'deskripsi_umum',
        'harga_vip',
        'nama_kategori_vip',
        'deskripsi_vip',
        'deskripsi_member',
        'nama_kategori_spesial',
        'harga_spesial',
        'deskripsi_spesial',
        'gambar_poster',
    ];

    /**
     * Ambil baris pengaturan (selalu baris pertama / satu-satunya).
     */
    public static function get(): self
    {
        return static::firstOrCreate([], [
            'harga_umum'            => 150000,
            'harga_member'          => 100000,
            'nama_kategori_umum'    => 'Sales 1',
            'harga_vip'             => 350000,
            'nama_kategori_vip'     => 'VIP',
            'nama_kategori_spesial' => 'Member Juli-Agustus',
            'harga_spesial'         => 0,
        ]);
    }
}
