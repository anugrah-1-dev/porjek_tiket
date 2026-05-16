@extends('adminlte::page')

@section('title', 'Edit Logo')

@section('content_header')
    <h1 class="m-0">Edit Logo</h1>
@stop

@section('content')
    <x-adminlte-card title="Form Edit Logo" theme="lightblue" theme-mode="outline">
        <form action="{{ route('admin.logos.update', $logo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input name="name" label="Nama Logo" required value="{{ $logo->name }}" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input name="key" label="Key (Unik)" required value="{{ $logo->key }}" />
                    <small class="text-muted">Key digunakan navbar untuk mengambil logo yang tepat. Contoh: <code>default</code>, <code>bieplus</code></small>
                </div>

                <div class="col-md-12 mt-3">
                    <x-adminlte-input-file name="image_path" label="Ganti Gambar Logo (opsional)" id="imageInputEdit" />

                    @if ($logo->image_path)
                        <small class="form-text text-muted" id="currentLabel">Gambar saat ini:</small>
                        <img id="imagePreviewExisting" src="{{ asset('storage/' . $logo->image_path) }}"
                            alt="{{ $logo->name }}" class="img-thumbnail mt-2" style="max-height: 150px;">
                    @endif

                    <img id="imagePreviewNew" src="#" alt="Preview Baru" class="mt-2 d-none img-thumbnail"
                        style="max-height: 150px;">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('admin.logos.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </x-adminlte-card>
@stop

@section('js')
    <script>
        document.getElementById('imageInputEdit').addEventListener('change', function (event) {
            const previewNew = document.getElementById('imagePreviewNew');
            const previewExisting = document.getElementById('imagePreviewExisting');
            const currentLabel = document.getElementById('currentLabel');

            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewNew.src = e.target.result;
                    previewNew.classList.remove('d-none');
                    if (previewExisting) previewExisting.classList.add('d-none');
                    if (currentLabel) currentLabel.classList.add('d-none');
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    </script>
@stop
