@extends('adminlte::page')

@section('title', 'Detail Tiket Konser')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="m-0">Detail Pemesan Tiket</h1>
    <a href="{{ route('admin.tiket-konser.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>
@stop

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

{{-- CARD STATUS ACTION --}}
<div class="card card-outline card-primary mb-3">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tasks mr-2"></i>Status Verifikasi</h3>
    </div>
    <div class="card-body">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div class="mr-3">
                <strong>Status saat ini:</strong>
                @if ($tiket->status === 'diterima')
                    <span class="badge badge-success ml-2" style="font-size:.95rem;">&#10003; Diterima</span>
                @elseif ($tiket->status === 'ditolak')
                    <span class="badge badge-danger ml-2" style="font-size:.95rem;">&#10007; Ditolak</span>
                @else
                    <span class="badge badge-warning ml-2" style="font-size:.95rem;">&#9679; Pending</span>
                @endif
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <form action="{{ route('admin.tiket-konser.update-status', $tiket->id) }}" method="POST" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="diterima">
                    <button type="submit" class="btn btn-success btn-sm"
                            onclick="return confirm('Terima pesanan tiket ini?')">
                        <i class="fas fa-check mr-1"></i> Terima
                    </button>
                </form>
                <form action="{{ route('admin.tiket-konser.update-status', $tiket->id) }}" method="POST" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="pending">
                    <button type="submit" class="btn btn-warning btn-sm">
                        <i class="fas fa-clock mr-1"></i> Set Pending
                    </button>
                </form>
                <form action="{{ route('admin.tiket-konser.update-status', $tiket->id) }}" method="POST" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="ditolak">
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Tolak pesanan tiket ini?')">
                        <i class="fas fa-times mr-1"></i> Tolak
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user mr-2"></i>Data Pemesan</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th class="bg-light" width="40%">Kategori</th>
                        <td>
                            @if ($tiket->kategori === 'member')
                                <span class="badge badge-success">Member Aktif Brilliant</span>
                            @elseif ($tiket->kategori === 'vip')
                                <span class="badge badge-danger">VIP</span>
                            @else
                                <span class="badge badge-warning">{{ $tiket->kategori }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">ID Transaksi</th>
                        <td><code>{{ $tiket->trx_id }}</code></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Nama Lengkap</th>
                        <td>{{ $tiket->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">TTL</th>
                        <td>{{ $tiket->ttl }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">No HP</th>
                        <td>{{ $tiket->no_hp }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Jumlah Tiket</th>
                        <td>{{ $tiket->jumlah_tiket }} tiket</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Total Harga</th>
                        <td><strong>Rp {{ number_format($tiket->total_harga, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <th class="bg-light">Bank Tujuan</th>
                        <td>
                            @if ($tiket->bank)
                                <strong>{{ $tiket->bank->name }}</strong><br>
                                a.n. {{ $tiket->bank->owner }}<br>
                                {{ $tiket->bank->number }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">Tanggal Pesan</th>
                        <td>{{ $tiket->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-image mr-2"></i>Bukti Pembayaran</h3>
            </div>
            <div class="card-body text-center">
                @if ($tiket->bukti_pembayaran)
                    <a href="{{ asset('storage/' . $tiket->bukti_pembayaran) }}" target="_blank">
                        <img src="{{ asset('storage/' . $tiket->bukti_pembayaran) }}"
                             alt="Bukti Pembayaran"
                             class="img-fluid rounded shadow"
                             style="max-height: 350px;">
                    </a>
                    <p class="mt-2 text-muted small">Klik gambar untuk memperbesar</p>
                @else
                    <p class="text-muted">Belum ada bukti pembayaran.</p>
                @endif
            </div>
        </div>

        @if ($tiket->kategori === 'member')
        <div class="card card-outline card-success mt-3">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-id-card mr-2"></i>Bukti Member Aktif</h3>
            </div>
            <div class="card-body text-center">
                @if ($tiket->bukti_member)
                    <a href="{{ asset('storage/' . $tiket->bukti_member) }}" target="_blank">
                        <img src="{{ asset('storage/' . $tiket->bukti_member) }}"
                             alt="Bukti Member"
                             class="img-fluid rounded shadow"
                             style="max-height: 350px;">
                    </a>
                    <p class="mt-2 text-muted small">Klik gambar untuk memperbesar</p>
                @else
                    <p class="text-muted">Bukti member tidak ditemukan.</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@stop
