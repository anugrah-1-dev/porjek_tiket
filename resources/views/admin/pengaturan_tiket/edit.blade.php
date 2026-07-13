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

<form action="{{ route('admin.pengaturan-tiket.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

<div class="row">
    {{-- ==================== KOLOM KIRI: PENGATURAN TIKET ==================== --}}
    <div class="col-md-6">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-ticket-alt mr-2"></i>Pengaturan Tiket Konser</h3>
            </div>
            <div class="card-body">

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
                              placeholder="Contoh: Tiket GRATIS untuk member Juli-Agustus&#10;Khusus member aktif minimal 1 bulan&#10;Daftar 10 Juli - 31 Agustus&#10;Tunjukkan bukti keanggotaan periode ini">{{ old('deskripsi_spesial', $pengaturan->deskripsi_spesial) }}</textarea>
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

            </div>
        </div>
    </div>

    {{-- ==================== KOLOM KANAN: INFO KONSER ==================== --}}
    <div class="col-md-6">

        {{-- Card: Info Event --}}
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Info Event Konser</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="deskripsi_section_konser" class="font-weight-bold">Deskripsi Section Konser <small class="text-muted">(ditampilkan di landing page)</small></label>
                    <textarea class="form-control" id="deskripsi_section_konser" name="deskripsi_section_konser" rows="3"
                              placeholder="Contoh: Saksikan penampilan spektakuler di panggung megah...">{{ old('deskripsi_section_konser', $pengaturan->deskripsi_section_konser) }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tanggal_event" class="font-weight-bold">Tanggal Event</label>
                        <input type="date" class="form-control @error('tanggal_event') is-invalid @enderror"
                               id="tanggal_event" name="tanggal_event"
                               value="{{ old('tanggal_event', optional($pengaturan->tanggal_event)->format('Y-m-d')) }}">
                        @error('tanggal_event')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lokasi_event" class="font-weight-bold">Lokasi Event</label>
                        <input type="text" class="form-control @error('lokasi_event') is-invalid @enderror"
                               id="lokasi_event" name="lokasi_event"
                               value="{{ old('lokasi_event', $pengaturan->lokasi_event) }}"
                               placeholder="Kampung Inggris, Pare">
                        @error('lokasi_event')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Info Artis --}}
        <div class="card card-outline card-purple">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-microphone-alt mr-2"></i>Info Artis / Lineup</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_artis" class="font-weight-bold">Nama Artis</label>
                    <input type="text" class="form-control @error('nama_artis') is-invalid @enderror"
                           id="nama_artis" name="nama_artis"
                           value="{{ old('nama_artis', $pengaturan->nama_artis) }}"
                           placeholder="For Revenge">
                    @error('nama_artis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="deskripsi_artis" class="font-weight-bold">Deskripsi Artis</label>
                    <textarea class="form-control" id="deskripsi_artis" name="deskripsi_artis" rows="3"
                              placeholder="Deskripsi singkat tentang artis...">{{ old('deskripsi_artis', $pengaturan->deskripsi_artis) }}</textarea>
                </div>
                <div class="form-group">
                    @if ($pengaturan->gambar_artis)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $pengaturan->gambar_artis) }}"
                                 alt="Foto Artis" class="img-thumbnail" style="max-height:120px;">
                            <p class="text-muted small mt-1">Foto artis saat ini.</p>
                        </div>
                    @endif
                    <label for="gambar_artis" class="font-weight-bold">Upload Foto Artis (opsional)</label>
                    <input type="file" class="form-control-file @error('gambar_artis') is-invalid @enderror"
                           id="gambar_artis" name="gambar_artis" accept="image/*">
                    <small class="text-muted">Format JPG/PNG/WEBP, maks 5MB.</small>
                    @error('gambar_artis')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Card: Gambar Konser (Multiple) --}}
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-images mr-2"></i>Gambar Konser (Stage, Venue, dll)</h3>
            </div>
            <div class="card-body">
                {{-- Existing images --}}
                @if ($pengaturan->gambarKonser && $pengaturan->gambarKonser->count() > 0)
                    <div class="row mb-3">
                        @foreach ($pengaturan->gambarKonser as $gambar)
                            <div class="col-md-4 col-6 mb-3 text-center">
                                <div class="position-relative" style="display:inline-block;">
                                    <img src="{{ asset('storage/' . $gambar->image_path) }}"
                                         alt="{{ $gambar->caption ?? 'Gambar Konser' }}"
                                         class="img-thumbnail" style="height:100px; object-fit:cover; width:100%;">
                                </div>
                                @if ($gambar->caption)
                                    <p class="small text-muted mt-1 mb-1">{{ $gambar->caption }}</p>
                                @endif
                                <form action="{{ route('admin.pengaturan-tiket.delete-gambar-konser', $gambar->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus gambar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="form-group">
                    <label for="gambar_konser" class="font-weight-bold">Upload Gambar Baru <small class="text-muted">(bisa pilih beberapa sekaligus)</small></label>
                    <input type="file" class="form-control-file @error('gambar_konser') is-invalid @enderror"
                           id="gambar_konser" name="gambar_konser[]" accept="image/*" multiple>
                    <small class="text-muted">Format JPG/PNG/WEBP, maks 5MB per gambar, maksimal 10 gambar.</small>
                    @error('gambar_konser')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    @error('gambar_konser.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Card: Fasilitas Venue --}}
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-map-marker-alt mr-2"></i>Fasilitas Venue</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="fasilitas_venue" class="font-weight-bold">Daftar Fasilitas <small class="text-muted">(tiap baris = 1 fasilitas)</small></label>
                    <textarea class="form-control" id="fasilitas_venue" name="fasilitas_venue" rows="6"
                              placeholder="Parkir Luas&#10;Toilet Bersih&#10;Food Court&#10;Mushola&#10;P3K&#10;Sound System Professional">{{ old('fasilitas_venue', $pengaturan->fasilitas_venue) }}</textarea>
                    <small class="text-muted">Fasilitas ini akan ditampilkan di section info konser landing page.</small>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-12 text-center mb-4">
        <button type="submit" class="btn btn-warning btn-lg">
            <i class="fas fa-save mr-2"></i> Simpan Semua Pengaturan
        </button>
    </div>
</div>

</form>
@stop
