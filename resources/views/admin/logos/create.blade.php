@extends('adminlte::page')

@section('title', 'Tambah Logo')

@section('content_header')
    <h1 class="m-0">Tambah Logo</h1>
@stop

@section('content')
    <x-adminlte-card title="Form Tambah Logo" theme="lightblue" theme-mode="outline">
        <form action="{{ route('admin.logos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nama Logo" placeholder="contoh: Logo Default" required
                        value="{{ old('name') }}" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="key" label="Key (Unik)" placeholder="contoh: default" required
                        value="{{ old('key') }}" />
                    <small class="text-muted">Key digunakan navbar untuk mengambil logo yang tepat. Contoh: <code>default</code>, <code>bieplus</code></small>
                </div>

                <div class="col-md-12 mt-3">
                    <x-adminlte-input-file name="image_path" label="Upload Gambar Logo" id="imageInput" />
                    <img id="imagePreview" src="#" alt="Preview" class="mt-2 d-none img-thumbnail"
                        style="max-height: 150px;">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop

@section('js')
    <script>
        document.getElementById('imageInput').addEventListener('change', function (event) {
            const preview = document.getElementById('imagePreview');
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    </script>
@stop
