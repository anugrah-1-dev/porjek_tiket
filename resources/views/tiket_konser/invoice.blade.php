<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Tiket Konser - #{{ $tiket->id }}</title>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 16px;
            font-size: 12px;
            background: #f0f0f0;
        }

        .action-buttons {
            text-align: center;
            margin-bottom: 14px;
            padding: 12px;
            background: #fff;
            border-bottom: 1px solid #ddd;
            border-radius: 6px;
        }
        .btn {
            display: inline-block;
            padding: 8px 18px;
            margin: 0 6px;
            background-color: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            font-size: 13px;
        }
        .btn-warning { background-color: #FFA109; }
        .btn-secondary { background-color: #6c757d; }
        .btn-success { background-color: #25D366; color: #fff; text-decoration: none; }
        .btn:hover { opacity: 0.9; }

        .invoice-container {
            max-width: 780px;
            margin: auto;
            padding: 20px 24px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,0.12);
            background-color: #fff;
            position: relative;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(200,200,200,0.12);
            z-index: 0;
            white-space: nowrap;
            pointer-events: none;
        }

        /* Header */
        .inv-header {
            display: table;
            width: 100%;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }
        .inv-header-left, .inv-header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .inv-header-right { text-align: right; }
        .inv-title {
            font-size: 26px;
            font-weight: bold;
            color: #333;
            line-height: 1;
        }
        .inv-header-left h2 { margin: 0 0 4px; font-size: 18px; color: #FFA109; }
        .inv-header-left p { margin: 2px 0; color: #555; font-size: 11px; line-height: 1.5; }
        .inv-header-right p { margin: 3px 0; font-size: 11px; }

        /* Status badge */
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .status-pending { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }

        /* Info pelanggan */
        .inv-info {
            display: table;
            width: 100%;
            border-top: 2px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 8px 0;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        .inv-info-left, .inv-info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            font-size: 11px;
            line-height: 1.7;
            padding: 0 4px;
        }
        .inv-info-right { text-align: right; }

        /* Items table */
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            font-size: 11px;
        }
        .invoice-items th {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding: 5px 6px;
        }
        .invoice-items td {
            padding: 5px 6px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .invoice-items tr:last-child td { border-bottom: none; }

        /* Summary */
        .summary-table {
            width: 42%;
            float: right;
            border-collapse: collapse;
            font-size: 11px;
            position: relative;
            z-index: 1;
        }
        .summary-table td { padding: 3px 6px; }
        .summary-table .total-row {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 13px;
        }

        /* Kategori badge */
        .kategori-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }
        .kategori-umum   { background:#fff3cd; color:#856404; border:1px solid #ffc107; }
        .kategori-member { background:#d4edda; color:#155724; border:1px solid #28a745; }

        /* Notice box */
        .notice-box {
            clear: both;
            padding: 8px 12px;
            background: linear-gradient(135deg, #fff8e8, #fff3cd);
            border: 1.5px solid #FFA109;
            border-radius: 8px;
            margin-top: 12px;
            margin-bottom: 8px;
        }
        .notice-box p { margin: 0 0 3px; font-size: 10px; line-height: 1.6; }
        .notice-box .notice-title { font-size: 11px; font-weight: bold; color: #7d4a00; margin-bottom: 4px; }

        /* Footer */
        .inv-footer {
            clear: both;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 10px;
            color: #666;
            position: relative;
            z-index: 1;
            text-align: center;
        }
        .inv-footer .closing {
            margin-top: 6px;
            font-size: 12px;
            font-weight: bold;
            color: #FFA109;
            font-style: italic;
        }

        .text-right  { text-align: right; }
        .text-center { text-align: center; }

        /* Print */
        @media print {
            body { background: none; margin: 0; padding: 0; font-size: 11px; }
            .action-buttons { display: none !important; }
            .invoice-container { box-shadow: none; border: none; padding: 10px 14px; max-width: 100%; }
            .watermark { color: rgba(200,200,200,0.18) !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .invoice-items th { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .notice-box { background: #fff8e8 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .kategori-umum, .kategori-member { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .invoice-container { page-break-inside: avoid; }
            @page { size: A4 portrait; margin: 10mm 12mm; }
        }
    </style>
</head>
<body>

    <div class="action-buttons">
        <a href="{{ route('landing') }}" class="btn btn-secondary">&#8592; Kembali ke Beranda</a>
        <button onclick="window.print()" class="btn">&#128438; Print Invoice</button>
        <button onclick="window.print()" class="btn btn-warning">&#11015; Download PDF</button>
        @if ($cs && $cs->nomor)
        @php
            $noWa   = preg_replace('/[^0-9]/', '', $cs->nomor);
            $noWa   = preg_replace('/^0/', '62', $noWa);
            $namaKat = match($tiket->kategori) {
                'vip'     => 'VIP',
                'member'  => 'Member Aktif',
                'spesial' => 'Member Spesial (Gratis)',
                default   => 'Umum',
            };
            $pesanWa = "Halo Admin Brilliant, saya ingin konfirmasi pembelian tiket konser.\n\n"
                . "No. Transaksi : *{$tiket->trx_id}*\n"
                . "Nama          : {$tiket->nama_lengkap}\n"
                . "Kategori      : {$namaKat}\n"
                . "Jumlah Tiket  : {$tiket->jumlah_tiket} tiket\n"
                . "Total Harga   : Rp " . number_format($tiket->total_harga, 0, ',', '.') . "\n\n"
                . "Mohon segera diverifikasi. Terima kasih!";
        @endphp
        <a href="https://wa.me/{{ $noWa }}?text={{ urlencode($pesanWa) }}"
           target="_blank"
           class="btn btn-success"
           style="display:inline-flex;align-items:center;gap:6px;">
            <img src="{{ asset('asset/wa/WhatsApp.svg') }}" alt="WhatsApp" style="width:18px;height:18px;">
            Konfirmasi ke Admin (WA)
        </a>
        @endif
    </div>

    <div class="invoice-container" id="invoice-content">
        <div class="watermark">BRILLIANT</div>

        {{-- HEADER --}}
        <div class="inv-header">
            <div class="inv-header-left">
                <h2>BRILLIANT</h2>
                <p>
                    Pusat Pembelajaran Bahasa Asing<br>
                    Kampung Inggris Pare<br>
                </p>
            </div>
            <div class="inv-header-right">
                <div class="inv-title">INVOICE</div>
                <p><strong>Nomor Transaksi:</strong> {{ $tiket->trx_id }}</p>
                <p><strong>Tanggal:</strong> {{ $tiket->created_at->format('d F Y') }}</p>
                <p><strong>Status:</strong>
                @if ($tiket->status === 'diterima')
                    <span class="status-badge status-success">DITERIMA</span>
                @elseif ($tiket->status === 'ditolak')
                    <span class="status-badge status-failed">DITOLAK</span>
                @else
                    <span class="status-badge status-pending">MENUNGGU VERIFIKASI</span>
                @endif
                </p>
            </div>
        </div>

        {{-- INFO PEMESAN --}}
        <div class="inv-info">
            <div class="inv-info-left">
                <strong>PEMESAN:</strong><br>
                {{ $tiket->nama_lengkap }}<br>
                TTL: {{ $tiket->ttl }}<br>
                No HP: {{ $tiket->no_hp }}
            </div>
            <div class="inv-info-right">
                <strong>BANK TUJUAN TRANSFER:</strong><br>
                @if ($tiket->bank)
                    {{ $tiket->bank->name }}<br>
                    a.n. {{ $tiket->bank->owner }}<br>
                    <strong>{{ $tiket->bank->number }}</strong>
                @else
                    -
                @endif
                <br><br>
                <strong>Waktu Pesan:</strong><br>
                {{ $tiket->created_at->format('d/m/Y H:i') }} WIB
            </div>
        </div>

        {{-- TABEL ITEM --}}
        <table class="invoice-items">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>Deskripsi</th>
                    <th class="text-right" width="15%">Harga Satuan</th>
                    <th class="text-right" width="10%">Qty</th>
                    <th class="text-right" width="20%">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <strong>Tiket Konser Brilliant</strong><br>
                        <small>Kategori: {{ $tiket->kategori === 'member' ? 'Member Aktif Brilliant' : 'Umum' }}</small>
                    </td>
                    <td class="text-right">Rp {{ number_format($hargaPerTiket, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $tiket->jumlah_tiket }}</td>
                    <td class="text-right">Rp {{ number_format($tiket->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        {{-- SUMMARY --}}
        <table class="summary-table">
            <tr>
                <td>Subtotal</td>
                <td class="text-right">Rp {{ number_format($tiket->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($tiket->total_harga, 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        {{-- NOTICE --}}
        <div class="notice-box">
            <div class="notice-title">&#8505; Informasi Penting</div>
            <p>&#x2022; Invoice ini merupakan bukti pemesanan tiket yang perlu diverifikasi terlebih dahulu.</p>
            <p>&#x2022; Bukti pembayaran Anda telah kami terima dan sedang dalam proses verifikasi.</p>
            <p>&#x2022; Simpan halaman invoice ini sebagai bukti pemesanan Anda.</p>
            @if ($tiket->kategori === 'member')
            <p>&#x2022; Bukti member aktif Anda juga telah dikirim dan akan diverifikasi bersama bukti pembayaran.</p>
            @endif
        </div>

        {{-- FOOTER --}}
        <div class="inv-footer">
            <p>Dokumen ini dicetak secara otomatis oleh sistem Brilliant English Course.</p>
            <div class="closing">Terima kasih telah memesan tiket konser Brilliant! &#127926;</div>
        </div>

    </div>

    <script>
        // Tombol Download PDF = trigger print dialog (user pilih Save as PDF)
        // Sudah ditangani oleh window.print() di tombol Download PDF
    </script>

</body>
</html>
