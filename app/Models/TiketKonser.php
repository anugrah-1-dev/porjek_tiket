<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketKonser extends Model
{
    use HasFactory;

    protected $table = 'tiket_konsers';

    protected $fillable = [
        'trx_id',
        'kategori',
        'nama_lengkap',
        'ttl',
        'no_hp',
        'jumlah_tiket',
        'total_harga',
        'bank_id',
        'bukti_pembayaran',
        'bukti_member',
        'periode_member',
    ];

    public function bank()
    {
        return $this->belongsTo(Banks::class, 'bank_id');
    }
}
