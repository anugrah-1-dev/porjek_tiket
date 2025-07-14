<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendaftaranProgramOnline extends Model
{
    use SoftDeletes;

    protected $table = 'pendaftaran_program_online';

    protected $fillable = [
        'trx_id',
        'nama_lengkap',
        'email',
        'no_hp',
        'asal_kota',
        'program_id',
        'period_id',
        'bukti_pembayaran',
        'status',
    ];

    // Relasi ke program online
    public function program()
    {
        return $this->belongsTo(ProgramOnline::class, 'program_id');
    }

    // Relasi ke periode
    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
}
