<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasKonser extends Model
{
    use HasFactory;

    protected $table = 'fasilitas_konser';
    protected $fillable = ['pengaturan_tiket_id', 'nama', 'image_path', 'urutan'];

    public function pengaturanTiket()
    {
        return $this->belongsTo(PengaturanTiket::class, 'pengaturan_tiket_id');
    }
}
