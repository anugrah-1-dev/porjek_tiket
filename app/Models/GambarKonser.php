<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarKonser extends Model
{
    protected $table = 'gambar_konser';

    protected $fillable = [
        'pengaturan_tiket_id',
        'image_path',
        'caption',
        'urutan',
    ];

    public function pengaturanTiket()
    {
        return $this->belongsTo(PengaturanTiket::class, 'pengaturan_tiket_id');
    }
}
