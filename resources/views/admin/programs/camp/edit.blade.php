@extends('adminlte::page')

@section('title', 'Edit Program Camp')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Program Camp</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Form Edit Program Camp</h3>
                </div>
                <form action="{{ route('admin.programs.camp.update', $program->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Informasi Dasar -->
                        <div class="section-header mb-4">
                            <h4><i class="fas fa-info-circle mr-2"></i>Informasi Dasar</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input name="nama" label="Nama Program" placeholder="Masukkan nama program"
                                    value="{{ old('nama', $program->nama) }}" fgroup-class="mb-3" />
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-input name="slug" label="Slug" placeholder="program-camp-slug"
                                    value="{{ old('slug', $program->slug) }}" fgroup-class="mb-3" />
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-select name="kategori" label="Kategori" fgroup-class="mb-3">
                                    <option value="" {{ old('kategori', $program->kategori) ? '' : 'selected' }} disabled>Pilih Kategori</option>
                                    <option value="Putra" {{ old('kategori', $program->kategori) == 'Putra' ? 'selected' : '' }}>Putra</option>
                                    <option value="Putri" {{ old('kategori', $program->kategori) == 'Putri' ? 'selected' : '' }}>Putri</option>
                                    <option value="Campuran" {{ old('kategori', $program->kategori) == 'Campuran' ? 'selected' : '' }}>Campuran</option>
                                </x-adminlte-select>
                            </div>
                        </div> --}}

                        <!-- Harga -->
                        <div class="section-header mb-4">
                            <h4><i class="fas fa-tags mr-2"></i>Harga</h4>
                        </div>
                        <div class="row">
                            @foreach ([
                                'harga_perhari' => 'Per Hari',
                                'harga_satu_minggu' => '1 Minggu',
                                'harga_dua_minggu' => '2 Minggu',
                                'harga_tiga_minggu' => '3 Minggu',
                                'harga_satu_bulan' => '1 Bulan',
                                'harga_dua_bulan' => '2 Bulan',
                                'harga_tiga_bulan' => '3 Bulan',
                                'harga_enam_bulan' => '6 Bulan',
                                'harga_satu_tahun' => '1 Tahun',
                            ] as $field => $label)
                                <div class="col-md-4 col-sm-6">
                                    <x-adminlte-input name="{{ $field }}" label="Harga {{ $label }}"
                                        type="number" min="0" placeholder="0" fgroup-class="mb-3"
                                        value="{{ old($field, $program->$field) }}" />
                                </div>
                            @endforeach
                        </div>

                        <!-- Fasilitas -->
                        <div class="section-header mb-4">
                            <h4><i class="fas fa-list-ul mr-2"></i>Fasilitas</h4>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <x-adminlte-textarea name="fasilitas" label="Fasilitas"
                                    placeholder="Pisahkan dengan koma (contoh: WiFi, Makan 3x, Transportasi)"
                                    rows="4" fgroup-class="mb-3">
                                    {{ old('fasilitas', $program->fasilitas) }}
                                </x-adminlte-textarea>
                            </div>
                        </div>

                        <!-- Thumbnail -->
                        <div class="section-header mb-4">
                            <h4><i class="fas fa-image mr-2"></i>Thumbnail</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                @if ($program->thumbnail)
                                    <div class="form-group">
                                        <label>Thumbnail Saat Ini</label>
                                        <div class="mb-2 p-2 border rounded">
                                            <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                                class="img-fluid img-thumbnail"
                                                style="max-height: 200px;"
                                                alt="Current Thumbnail">
                                        </div>
                                    </div>
                                @endif
                                <x-adminlte-input-file name="thumbnail" label="Ganti Thumbnail (opsional)"
                                    accept="image/*" fgroup-class="mb-3" />
                                <div class="preview-container mt-2">
                                    <img id="preview-thumbnail" class="img-fluid img-thumbnail d-none"
                                        style="max-height: 200px;"
                                        alt="Thumbnail Preview">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <x-adminlte-button label="Batal" theme="outline-danger" icon="fas fa-times"
                            onclick="window.history.back()" class="mr-2" />
                        <x-adminlte-button label="Perbarui" theme="primary" icon="fas fa-save" type="submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .section-header {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        .section-header h4 {
            color: #444;
            font-weight: 600;
        }
        .img-thumbnail {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .preview-container {
            border: 2px dashed #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Preview thumbnail sebelum upload
        document.querySelector('input[name="thumbnail"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview-thumbnail');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            } else {
                preview.src = '';
                preview.classList.add('d-none');
            }
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@stop
