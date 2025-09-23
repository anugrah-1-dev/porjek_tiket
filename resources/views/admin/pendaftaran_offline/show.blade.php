@extends('adminlte::page')

@section('title', 'Detail Pendaftaran Offline')

@section('content_header')
    <h1><i class="fas fa-file-alt me-2"></i> Detail Pendaftaran Offline</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="mb-0">#{{ $pendaftaran->trx_id }}</h3>
        <span class="badge bg-success">Terkonfirmasi</span>
    </div>

    <div class="card-body">
        {{-- Informasi Pelanggan --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="info-box bg-gradient-primary">
                    <span class="info-box-icon"><i class="fas fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Informasi Pelanggan</span>
                        <div class="row mt-2">
                            <div class="col-12">
                                <p class="mb-1"><strong>Nama:</strong> {{ $pendaftaran->nama_lengkap }}</p>
                                <p class="mb-1">
                                    <strong>No. Telepon:</strong>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pendaftaran->no_hp) }}"
                                       target="_blank" class="text-success">
                                        {{ $pendaftaran->no_hp }} <i class="fab fa-whatsapp ms-1"></i>
                                    </a>
                                </p>
                                <p class="mb-0"><strong>Email:</strong> {{ $pendaftaran->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box bg-gradient-info">
                    <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Informasi Pendaftaran</span>
                        <div class="row mt-2">
                            <div class="col-12">
                                <p class="mb-1"><strong>Tanggal Daftar:</strong> {{ $pendaftaran->created_at->format('d/m/Y H:i') }}</p>
                                <p class="mb-1"><strong>Status:</strong> Terkonfirmasi</p>
                                <p class="mb-0"><strong>ID Transaksi:</strong> {{ $pendaftaran->trx_id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Gabungan Semua Layanan --}}
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list-alt me-2"></i> Detail Layanan yang Dipilih</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="bg-gradient-primary text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Jenis Layanan</th>
                                <th width="25%">Nama Paket</th>
                                <th width="15%">Jumlah</th>
                                <th width="15%">Harga Satuan</th>
                                <th width="20%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                                $total_keseluruhan = 0;
                            @endphp

                            {{-- Layanan Catering --}}
                            @forelse ($pendaftaran->caterings as $catering)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="fas fa-utensils me-1"></i> Catering
                                        </span>
                                    </td>
                                    <td>{{ $catering->cateringPackage->nama_paket }}</td>
                                    <td>x{{ $catering->jumlah_porsi }} porsi</td>
                                    <td>Rp {{ number_format($catering->harga,0,',','.') }}</td>
                                    <td class="font-weight-bold">Rp {{ number_format($catering->jumlah_porsi * $catering->harga,0,',','.') }}</td>
                                </tr>
                                @php $total_keseluruhan += $catering->jumlah_porsi * $catering->harga; @endphp
                            @empty
                            @endforelse

                            {{-- Layanan Laundry --}}
                            @forelse ($pendaftaran->laundries as $laundry)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            <i class="fas fa-tshirt me-1"></i> Laundry
                                        </span>
                                    </td>
                                    <td>{{ $laundry->laundryPackage->nama_paket }}</td>
                                    <td>x{{ $laundry->jumlah }} item</td>
                                    <td>Rp {{ number_format($laundry->harga,0,',','.') }}</td>
                                    <td class="font-weight-bold">Rp {{ number_format($laundry->jumlah * $laundry->harga,0,',','.') }}</td>
                                </tr>
                                @php $total_keseluruhan += $laundry->jumlah * $laundry->harga; @endphp
                            @empty
                            @endforelse

                            {{-- Layanan Holiday --}}
                            @forelse ($pendaftaran->holidays as $holiday)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-umbrella-beach me-1"></i> Holiday
                                        </span>
                                    </td>
                                    <td>{{ $holiday->holidayPackage->nama_paket }}</td>
                                    <td>x{{ $holiday->jumlah_peserta }} orang</td>
                                    <td>Rp {{ number_format($holiday->harga,0,',','.') }}</td>
                                    <td class="font-weight-bold">Rp {{ number_format($holiday->jumlah_peserta * $holiday->harga,0,',','.') }}</td>
                                </tr>
                                @php $total_keseluruhan += $holiday->jumlah_peserta * $holiday->harga; @endphp
                            @empty
                            @endforelse

                            {{-- Jika tidak ada layanan --}}
                            @if($no == 1)
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        <i class="fas fa-info-circle me-2"></i>Tidak ada layanan yang dipilih
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot class="bg-gradient-success text-white">
                            <tr>
                                <th colspan="5" class="text-end">TOTAL KESELURUHAN</th>
                                <th class="h4">Rp {{ number_format($total_keseluruhan,0,',','.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Catatan Khusus --}}
        @if ($pendaftaran->catatan)
            <div class="card card-warning card-outline mt-3">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-sticky-note me-2"></i> Catatan Khusus</h3>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $pendaftaran->catatan }}</p>
                </div>
            </div>
        @endif

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.pendaftaran.offline.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>

            <div>
                <a href="https://wa.me/+62{{ preg_replace('/[^0-9]/', '', $pendaftaran->no_hp) }}"
                   target="_blank" class="btn btn-success">
                    <i class="fab fa-whatsapp me-2"></i> Hubungi Peserta via WhatsApp
                </a>
                {{-- <button class="btn btn-primary ms-2">
                    <i class="fas fa-print me-2"></i> Cetak Detail
                </button> --}}
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: 0.5rem;
            min-height: 120px;
            margin-bottom: 0;
        }
        .info-box .info-box-content {
            padding: 15px;
        }
        .table th {
            border-top: none;
        }
        .badge {
            font-size: 0.85em;
            padding: 0.4em 0.6em;
        }
        .card-outline {
            border-top: 3px solid;
        }
        .card-primary.card-outline {
            border-top-color: #007bff;
        }
        .card-warning.card-outline {
            border-top-color: #ffc107;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Tambahkan efek hover pada tabel
            $('table tbody tr').hover(
                function() {
                    $(this).addClass('bg-light');
                },
                function() {
                    $(this).removeClass('bg-light');
                }
            );
        });
    </script>
@stop
