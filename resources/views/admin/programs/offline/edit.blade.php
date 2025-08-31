@extends('adminlte::page')

@section('title', 'Edit Program Offline')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Program Offline: {{ $offline->nama }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Program Offline</h3>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ups!</strong> Ada kesalahan dalam input:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.offline.update', $offline->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama Program</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama', $offline->nama) }}">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="program_bahasa">Program Bahasa</label>
                                    <select class="form-control @error('program_bahasa') is-invalid @enderror"
                                        id="program_bahasa" name="program_bahasa" required>
                                        <option value="" disabled selected>-- Pilih Bahasa --</option>
                                        <option value="inggris"
                                            {{ old('program_bahasa', $offline->program_bahasa) == 'inggris' ? 'selected' : '' }}>
                                            Bahasa Inggris</option>
                                        <option value="jerman"
                                            {{ old('program_bahasa', $offline->program_bahasa) == 'jerman' ? 'selected' : '' }}>
                                            Bahasa Jerman</option>
                                        <option value="mandarin"
                                            {{ old('program_bahasa', $offline->program_bahasa) == 'mandarin' ? 'selected' : '' }}>
                                            Bahasa Mandarin</option>
                                        <option value="arab"
                                            {{ old('program_bahasa', $offline->program_bahasa) == 'arab' ? 'selected' : '' }}>
                                            Bahasa Arab</option>
                                    </select>
                                    @error('program_bahasa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slug">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name="slug" value="{{ old('slug', $offline->slug) }}">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lama_program">Lama Program</label>
                                    <input type="text" class="form-control @error('lama_program') is-invalid @enderror"
                                        id="lama_program" name="lama_program"
                                        value="{{ old('lama_program', $offline->lama_program) }}">
                                    @error('lama_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                                        id="kategori" name="kategori" value="{{ old('kategori', $offline->kategori) }}">
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="harga">Harga (Rp)</label>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                        id="harga" name="harga" value="{{ old('harga', $offline->harga) }}">
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                        id="lokasi" name="lokasi" value="{{ old('lokasi', $offline->lokasi) }}">
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jadwal_mulai">Jadwal Mulai</label>
                                    <input type="date" class="form-control @error('jadwal_mulai') is-invalid @enderror"
                                        id="jadwal_mulai" name="jadwal_mulai"
                                        value="{{ old('jadwal_mulai', $offline->jadwal_mulai) }}">
                                    @error('jadwal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jadwal_selesai">Jadwal Selesai</label>
                                    <input type="date" class="form-control @error('jadwal_selesai') is-invalid @enderror"
                                        id="jadwal_selesai" name="jadwal_selesai"
                                        value="{{ old('jadwal_selesai', $offline->jadwal_selesai) }}">
                                    @error('jadwal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kuota">Kuota</label>
                                    <input type="number" class="form-control @error('kuota') is-invalid @enderror"
                                        id="kuota" name="kuota" value="{{ old('kuota', $offline->kuota) }}">
                                    @error('kuota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_active">Status Program</label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" id="is_active"
                                        name="is_active">
                                        <option value="1"
                                            {{ old('is_active', $offline->is_active) == 1 ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $offline->is_active) == 0 ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="thumbnail">Thumbnail Program (Gambar)</label>
                                    <div class="custom-file">
                                        <input type="file"
                                            class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail" name="thumbnail" accept="image/*">
                                        <label class="custom-file-label" for="thumbnail">Pilih file</label>
                                    </div>
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Format: JPG, PNG, GIF. Maksimal 2MB.
                                    </small>

                                    @if ($offline->thumbnail)
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="hapus_thumbnail"
                                                value="1" id="hapus_thumbnail">
                                            <label class="form-check-label" for="hapus_thumbnail">Hapus thumbnail saat
                                                disimpan</label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="features_program">Fitur Program (Pisahkan dengan Enter)</label>
                                    <textarea class="form-control @error('features_program') is-invalid @enderror" id="features_program"
                                        name="features_program" rows="4">{{ old('features_program', is_array(json_decode($offline->features_program)) ? implode("\n", json_decode($offline->features_program)) : $offline->features_program) }}</textarea>

                                    @error('features_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Gunakan emoji ✅ untuk menandai fitur. Setiap fitur pada baris baru.
                                    </small>
                                </div>
                            </div>
                        </div>

                        @if ($offline->thumbnail)
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="thumbnail-preview-container">
                                        <p class="font-weight-bold">Thumbnail Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $offline->thumbnail) }}" class="img-thumbnail"
                                            id="currentThumbnail" width="200">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="newThumbnailPreview" class="mt-2" style="display:none;">
                                        <p class="font-weight-bold">Pratinjau Thumbnail Baru:</p>
                                        <img id="previewImage" class="img-thumbnail" src="#"
                                            alt="Pratinjau thumbnail" width="200">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.offline.index') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .img-thumbnail {
            max-height: 200px;
            object-fit: cover;
        }

        .custom-file-label::after {
            content: "Browse";
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Preview uploaded image
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('newThumbnailPreview').style.display = 'block';
                }
                reader.readAsDataURL(file);

                // Update custom file label
                const fileName = file.name;
                const label = document.querySelector('.custom-file-label');
                label.textContent = fileName;
            }
        });

        // Auto generate slug from nama
        document.getElementById('nama').addEventListener('input', function() {
            const nama = this.value;
            const slug = nama.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '') // Remove invalid chars
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/-+/g, '-'); // Replace multiple - with single -

            document.getElementById('slug').value = slug;
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
@stop
