<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketKonser extends Model
{
    use HasFactory;

    protected $table = 'tiket_konsers';

    protected $fillable = [
        'kategori',
        'nama_lengkap',
        'ttl',
        'no_hp',
        'jumlah_tiket',
        'total_harga',
        'bukti_pembayaran',
        'bukti_member',
    ];
}
