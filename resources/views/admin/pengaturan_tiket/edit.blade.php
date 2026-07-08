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
                        <label for="harga_umum" class="font-weight-bold">
                            <i class="fas fa-ticket-alt text-secondary mr-1"></i> Harga Tiket — Umum (Rp)
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number"
                                   class="form-control form-control-lg @error('harga_umum') is-invalid @enderror"
                                   id="harga_umum"
                                   name="harga_umum"
                                   value="{{ old('harga_umum', $pengaturan->harga_umum) }}"
                                   min="1000"
                                   required>
                            @error('harga_umum')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="harga_member" class="font-weight-bold">
                            <i class="fas fa-id-card text-success mr-1"></i> Harga Tiket — Member Aktif Brilliant (Rp)
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number"
                                   class="form-control form-control-lg @error('harga_member') is-invalid @enderror"
                                   id="harga_member"
                                   name="harga_member"
                                   value="{{ old('harga_member', $pengaturan->harga_member) }}"
                                   min="1000"
                                   required>
                            @error('harga_member')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 mb-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        Harga saat ini:<br>
                        <strong>Umum:</strong> Rp {{ number_format($pengaturan->harga_umum, 0, ',', '.') }} per tiket<br>
                        <strong>Member Aktif:</strong> Rp {{ number_format($pengaturan->harga_member, 0, ',', '.') }} per tiket
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
