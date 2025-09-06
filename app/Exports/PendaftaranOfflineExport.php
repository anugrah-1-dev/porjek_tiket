<?php

namespace App\Exports;

use App\Models\PendaftaranProgramOffline;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PendaftaranOfflineExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithDrawings
{
    protected $pendaftarans;
    protected $row_height = 80;
    protected $image_column_width = 25;

    public function __construct($startDate, $endDate, $programBahasa = null)
    {
        $query = PendaftaranProgramOffline::with(['program', 'period', 'transport', 'bank'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        // filter program_bahasa kalau dipilih
        if ($programBahasa) {
            $query->whereHas('program', function ($q) use ($programBahasa) {
                $q->where('program_bahasa', $programBahasa);
            });
        }

        $this->pendaftarans = $query->get();
    }



    public function collection()
    {
        // Mengembalikan data yang sudah diambil di constructor
        return $this->pendaftarans;
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Lengkap',
            'Email',
            'No HP',
            'Asal Kota',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Gender',
            'No Wali',
            'Nama Program',
            'Tanggal Periode',
            'Transportasi',
            'Ukuran Seragam',
            'Tipe Pembayaran',
            'Bank Tujuan',
            'Bukti Pembayaran',
            'Status',
            'Subtotal',
            'Akomodasi Tipe',
            'Akomodasi Harga',
        ];
    }


    public function map($pendaftaran): array
    {
        $periodText = '-';
        if ($pendaftaran->period) {
            $tanggalMulai   = $pendaftaran->period->tanggal_mulai ?? $pendaftaran->period->date;
            $tanggalSelesai = $pendaftaran->period->tanggal_selesai ?? $pendaftaran->period->date;
            $startDate = \Carbon\Carbon::parse($tanggalMulai);
            $endDate   = \Carbon\Carbon::parse($tanggalSelesai);
            $periodText = $startDate->isSameDay($endDate)
                ? $startDate->translatedFormat('d F Y')
                : $startDate->translatedFormat('d M Y') . ' - ' . $endDate->translatedFormat('d M Y');
        }

        return [
            $pendaftaran->trx_id,
            $pendaftaran->nama_lengkap,
            $pendaftaran->email,
            $pendaftaran->no_hp,
            $pendaftaran->asal_kota,
            $pendaftaran->tempat_lahir ?? '-',
            $pendaftaran->tanggal_lahir ? \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->translatedFormat('d M Y') : '-',
            ucfirst($pendaftaran->gender ?? '-'),
            $pendaftaran->no_wali,
            $pendaftaran->program->nama ?? '-',
            $periodText,
            $pendaftaran->transport->name ?? '-',
            strtoupper($pendaftaran->ukuran_seragam ?? '-'),
            ucfirst($pendaftaran->payment_type),
            $pendaftaran->payment_type == 'transfer' ? ($pendaftaran->bank->name ?? '-') : '-',
            $pendaftaran->payment_type == 'tunai' ? 'Tunai / Cash' : '',
            $pendaftaran->status,
            number_format($pendaftaran->subtotal, 0, ',', '.'),
            $pendaftaran->akomodasi_tipe ?? '-',
            number_format($pendaftaran->akomodasi_harga, 0, ',', '.'),
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $columnWidthInPixels = $this->image_column_width * 7.5;

        foreach ($this->pendaftarans as $key => $pendaftaran) {
            // Tambahkan gambar hanya jika pembayaran transfer + ada bukti
            if ($pendaftaran->payment_type !== 'transfer' || !$pendaftaran->bukti_pembayaran) {
                continue;
            }

            $pathToFile = public_path('storage/' . $pendaftaran->bukti_pembayaran);
            if (!file_exists($pathToFile)) {
                continue;
            }

            $drawing = new Drawing();
            $drawing->setName('Bukti Pembayaran');
            $drawing->setDescription($pendaftaran->nama_lengkap);
            $drawing->setPath($pathToFile);
            $drawing->setCoordinates('L' . ($key + 2));

            // Atur ukuran gambar sesuai tinggi baris
            list($originalWidth, $originalHeight) = getimagesize($pathToFile);
            $newHeight = $this->row_height - 10;
            $drawing->setHeight($newHeight);

            $newWidth = ($originalWidth / $originalHeight) * $newHeight;
            $drawing->setOffsetX(($columnWidthInPixels - $newWidth) / 2);
            $drawing->setOffsetY(($this->row_height - $newHeight) / 2);

            $drawings[] = $drawing;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getDelegate()->getHighestRow();
                $highestColumn = $sheet->getDelegate()->getHighestColumn();
                $cellRange = 'A1:' . $highestColumn . $highestRow;

                // Style umum
                $sheet->getStyle($cellRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A1:' . $highestColumn . '1')->getFont()->setBold(true);
                $sheet->getStyle('A1:' . $highestColumn . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);

                // Per baris
                foreach ($this->pendaftarans as $key => $pendaftaran) {
                    $rowNumber = $key + 2;
                    $rowDimension = $sheet->getDelegate()->getRowDimension($rowNumber);

                    if (
                        $pendaftaran->payment_type === 'transfer'
                        && $pendaftaran->bukti_pembayaran
                        && file_exists(public_path('storage/' . $pendaftaran->bukti_pembayaran))
                    ) {

                        $rowDimension->setRowHeight($this->row_height);
                    } else {
                        $rowDimension->setRowHeight(25);
                    }

                    // Tengahkan tulisan "Tunai / Cash"
                    if ($pendaftaran->payment_type === 'tunai') {
                        $sheet->getStyle('L' . $rowNumber)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }

                // Lebar kolom A–K auto, L fixed, M auto
                foreach (range('A', 'K') as $col) {
                    $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
                $sheet->getDelegate()->getColumnDimension('L')->setWidth($this->image_column_width);
                $sheet->getDelegate()->getColumnDimension('M')->setAutoSize(true);

                // Border semua sel
                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                    ]
                ]);
            },
        ];
    }
}
