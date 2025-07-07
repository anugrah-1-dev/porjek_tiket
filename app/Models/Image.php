<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['galeri_id', 'path'];

    /**
     * Mendefinisikan relasi many-to-one ke model Galeri.
     * Sebuah gambar dimiliki oleh satu galeri.
     */
    public function galeri()
    {
        return $this->belongsTo(Galeri::class);
    }
}
