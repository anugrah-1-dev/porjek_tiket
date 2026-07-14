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
        'status_umum',
        'tampil_umum',
        'harga_vip',
        'nama_kategori_vip',
        'deskripsi_vip',
        'status_vip',
        'tampil_vip',
        'nama_kategori_member',
        'deskripsi_member',
        'status_member',
        'tampil_member',
        'nama_kategori_spesial',
        'harga_spesial',
        'deskripsi_spesial',
        'status_spesial',
        'tampil_spesial',
        'gambar_poster',
        'tanggal_event',
        'lokasi_event',
        'nama_artis',
        'deskripsi_artis',
        'gambar_artis',
        'fasilitas_venue',
        'deskripsi_section_konser',
        'status_tampil_konser',
    ];

    protected $casts = [
        'tanggal_event' => 'date',
    ];

    /**
     * Ambil baris pengaturan (selalu baris pertama / satu-satunya).
     */
    public static function get(): self
    {
        return static::firstOrCreate([], [
            'nama_kategori_umum'    => 'Tiket - Presale 1',
            'harga_umum'            => 150000,
            'status_umum'           => 'tersedia',
            'deskripsi_umum'        => '',
            'tampil_umum'           => true,
            
            'nama_kategori_vip'     => 'Tiket - Presale 2',
            'harga_vip'             => 210000,
            'status_vip'            => 'sold_out',
            'deskripsi_vip'         => '',
            'tampil_vip'            => true,
            
            'nama_kategori_member'  => 'Tiket - WARGA PARE',
            'harga_member'          => 275000,
            'status_member'         => 'coming_soon',
            'deskripsi_member'      => 'KHUSUS WARGA BER-KTP KECAMATAN PARE',
            'tampil_member'         => true,
            
            'nama_kategori_spesial' => 'Tiket - VIP',
            'harga_spesial'         => 350000,
            'status_spesial'        => 'tersedia',
            'deskripsi_spesial'     => "Kaos Eksklusif (Briliant Kampung Inggris Pare Hari Ini)\nAir Mineral & Snack\nFast Track",
            'tampil_spesial'        => true,
            
            'status_tampil_konser'  => true,
        ]);
    }

    /**
     * Relasi ke gambar-gambar konser (stage, venue, suasana, dll).
     */
    public function gambarKonser()
    {
        return $this->hasMany(GambarKonser::class, 'pengaturan_tiket_id')->orderBy('urutan');
    }
}
