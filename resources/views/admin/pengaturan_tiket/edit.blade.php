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
                <h3 class="card-title"><i class="fas fa-ticket-alt mr-2"></i>Pengaturan Tiket Konser</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaturan-tiket.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <h6 class="text-muted border-bottom pb-1 mb-3 mt-2">Kategori 1</h6>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nama_kategori_umum" class="font-weight-bold">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama_kategori_umum') is-invalid @enderror"
                                   id="nama_kategori_umum" name="nama_kategori_umum"
                                   value="{{ old('nama_kategori_umum', $pengaturan->nama_kategori_umum) }}" required>
                            @error('nama_kategori_umum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="harga_umum" class="font-weight-bold">Harga (Rp)</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="number" class="form-control @error('harga_umum') is-invalid @enderror"
                                       id="harga_umum" name="harga_umum"
                                       value="{{ old('harga_umum', $pengaturan->harga_umum) }}" min="1000" required>
                                @error('harga_umum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_umum" class="font-weight-bold">Deskripsi / Benefit <small class="text-muted">(tiap baris = 1 poin)</small></label>
                        <textarea class="form-control" id="deskripsi_umum" name="deskripsi_umum" rows="3"
                                  placeholder="Contoh: Kursi reguler&#10;Akses venue umum">{{ old('deskripsi_umum', $pengaturan->deskripsi_umum) }}</textarea>
                    </div>

                    <h6 class="text-muted border-bottom pb-1 mb-3 mt-3">Kategori VIP</h6>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nama_kategori_vip" class="font-weight-bold">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama_kategori_vip') is-invalid @enderror"
                                   id="nama_kategori_vip" name="nama_kategori_vip"
                                   value="{{ old('nama_kategori_vip', $pengaturan->nama_kategori_vip) }}" required>
                            @error('nama_kategori_vip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="harga_vip" class="font-weight-bold">Harga (Rp)</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="number" class="form-control @error('harga_vip') is-invalid @enderror"
                                       id="harga_vip" name="harga_vip"
                                       value="{{ old('harga_vip', $pengaturan->harga_vip) }}" min="1000" required>
                                @error('harga_vip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_vip" class="font-weight-bold">Deskripsi / Benefit VIP <small class="text-muted">(tiap baris = 1 poin)</small></label>
                        <textarea class="form-control" id="deskripsi_vip" name="deskripsi_vip" rows="4"
                                  placeholder="Contoh: Kursi VIP baris depan&#10;Meet & greet dengan artis&#10;Merchandise eksklusif&#10;Akses area backstage">{{ old('deskripsi_vip', $pengaturan->deskripsi_vip) }}</textarea>
                    </div>

                    <h6 class="text-muted border-bottom pb-1 mb-3 mt-3">Kategori Member Aktif Brilliant</h6>
                    <div class="form-group">
                        <label for="harga_member" class="font-weight-bold">Harga Member (Rp)</label>
                        <div class="input-group" style="max-width:300px;">
                            <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                            <input type="number" class="form-control @error('harga_member') is-invalid @enderror"
                                   id="harga_member" name="harga_member"
                                   value="{{ old('harga_member', $pengaturan->harga_member) }}" min="1000" required>
                            @error('harga_member')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_member" class="font-weight-bold">Deskripsi / Benefit Member <small class="text-muted">(tiap baris = 1 poin)</small></label>
                        <textarea class="form-control" id="deskripsi_member" name="deskripsi_member" rows="3"
                                  placeholder="Contoh: Harga khusus member aktif&#10;Tunjukkan bukti keanggotaan">{{ old('deskripsi_member', $pengaturan->deskripsi_member) }}</textarea>
                    </div>

                    <h6 class="text-muted border-bottom pb-1 mb-3 mt-3">Member Spesial (Gratis - Juli-Agustus)</h6>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nama_kategori_spesial" class="font-weight-bold">Nama Kategori</label>
                            <input type="text" class="form-control @error('nama_kategori_spesial') is-invalid @enderror"
                                   id="nama_kategori_spesial" name="nama_kategori_spesial"
                                   value="{{ old('nama_kategori_spesial', $pengaturan->nama_kategori_spesial) }}" required>
                            @error('nama_kategori_spesial')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="harga_spesial" class="font-weight-bold">Harga (Rp) <small class="text-success">— 0 = GRATIS</small></label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                <input type="number" class="form-control @error('harga_spesial') is-invalid @enderror"
                                       id="harga_spesial" name="harga_spesial"
                                       value="{{ old('harga_spesial', $pengaturan->harga_spesial ?? 0) }}" min="0" required>
                                @error('harga_spesial')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_spesial" class="font-weight-bold">Deskripsi / Benefit <small class="text-muted">(tiap baris = 1 poin)</small></label>
                        <textarea class="form-control" id="deskripsi_spesial" name="deskripsi_spesial" rows="3"
                                  placeholder="Contoh: Tiket GRATIS untuk member Juli-Agustus&#10;Daftar 10 Juli - 31 Agustus&#10;Tunjukkan bukti keanggotaan periode ini">{{ old('deskripsi_spesial', $pengaturan->deskripsi_spesial) }}</textarea>
                    </div>

                    <h6 class="text-muted border-bottom pb-1 mb-3 mt-3">Poster Konser</h6>
                    <div class="form-group">
                        @if ($pengaturan->gambar_poster)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $pengaturan->gambar_poster) }}"
                                     alt="Poster" class="img-thumbnail" style="max-height:150px;">
                                <p class="text-muted small mt-1">Poster saat ini. Upload baru untuk mengganti.</p>
                            </div>
                        @endif
                        <label for="gambar_poster" class="font-weight-bold">Upload Poster (opsional)</label>
                        <input type="file" class="form-control-file @error('gambar_poster') is-invalid @enderror"
                               id="gambar_poster" name="gambar_poster" accept="image/*">
                        <small class="text-muted">Format JPG/PNG/WEBP, maks 5MB. Poster ini tampil saat website pertama dibuka.</small>
                        @error('gambar_poster')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg mt-3">
                        <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
