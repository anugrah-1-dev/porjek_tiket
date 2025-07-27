<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendaftaranProgramOffline extends Model
{
    use SoftDeletes;

    protected $table = 'pendaftaran_program_offline';

    protected $fillable = [
        'trx_id',
        'nama_lengkap',
        'email',
        'no_hp',
        'asal_kota',
        'no_wali',
        'program_id',
        'period_id',
        'transport_id',
        'bukti_pembayaran',
        'status',
        'bank_id', // ✅ digunakan untuk relasi bank
    ];

    // Relasi ke program offline
    public function program()
    {
        return $this->belongsTo(ProgramOffline::class, 'program_id');
    }

    // Relasi ke periode
    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }

    // Relasi ke transportasi
    public function transport()
    {
        return $this->belongsTo(Transports::class, 'transport_id');
    }

    // ✅ Relasi ke bank (fix nama model)
    public function bank()
    {
        return $this->belongsTo(\App\Models\Banks::class, 'bank_id');
    }
}
