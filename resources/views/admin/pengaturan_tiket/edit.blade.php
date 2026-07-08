@extends('adminlte::page')

@section('title', 'Pengaturan Harga Tiket')

@section('content_header')
    <h1 class="m-0">Pengaturan Harga Tiket Konser</h1>
@stop

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-ticket-alt mr-2"></i>Atur Harga Per Tiket</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaturan-tiket.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="harga_per_tiket" class="font-weight-bold">Harga Per Tiket (Rp)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number"
                                   class="form-control form-control-lg @error('harga_per_tiket') is-invalid @enderror"
                                   id="harga_per_tiket"
                                   name="harga_per_tiket"
                                   value="{{ old('harga_per_tiket', $pengaturan->harga_per_tiket) }}"
                                   min="1000"
                                   required>
                            @error('harga_per_tiket')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Harga ini akan otomatis ditampilkan di form pembelian tiket dan dikalikan dengan jumlah tiket.</small>
                    </div>

                    <div class="alert alert-info mt-3 mb-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Harga saat ini: <strong>Rp {{ number_format($pengaturan->harga_per_tiket, 0, ',', '.') }}</strong> per tiket
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="fas fa-save mr-2"></i> Simpan Harga
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
