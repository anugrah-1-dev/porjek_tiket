<?php

namespace App\Exports;

use App\Models\TiketKonser;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TiketKonserExport implements FromQuery, WithHeadings, WithMapping
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function query()
    {
        return TiketKonser::query()
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Lengkap',
            'No HP',
            'Kategori',
            'Jumlah Tiket',
            'Total Harga',
            'Status',
            'Tanggal Pesan',
        ];
    }

    public function map($tiket): array
    {
        return [
            $tiket->trx_id,
            $tiket->nama_lengkap,
            $tiket->no_hp,
            strtoupper($tiket->kategori),
            $tiket->jumlah_tiket,
            $tiket->total_harga,
            strtoupper($tiket->status),
            $tiket->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
