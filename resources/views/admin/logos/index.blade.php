@extends('adminlte::page')

@section('title', 'Manajemen Logo')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">Daftar Logo</h1>
        <a href="{{ route('admin.logos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Logo
        </a>
    </div>
@stop

@section('content')
    @if (session('alert'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: '{{ session('alert')['icon'] }}',
                    title: '{{ session('alert')['title'] }}',
                    text: '{{ session('alert')['text'] }}',
                    timer: 2500,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif

    <div class="row">
        <div class="col-12">
            <x-adminlte-card theme="lightblue" theme-mode="outline" title="List Logo">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead class="bg-lightblue text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Logo</th>
                                <th>Key</th>
                                <th>Gambar</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logos as $index => $logo)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-left"><strong>{{ $logo->name }}</strong></td>
                                    <td><code>{{ $logo->key }}</code></td>
                                    <td>
                                        @if ($logo->image_path)
                                            <img src="{{ asset('storage/' . $logo->image_path) }}" alt="{{ $logo->name }}" style="height: 60px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">Belum ada gambar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('admin.logos.edit', $logo->id) }}"
                                                class="btn btn-warning btn-action mr-1" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.logos.destroy', $logo->id) }}" method="POST"
                                                onsubmit="confirmDelete(event)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-action" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data logo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('css')
    <style>
        .btn-action {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
    </style>
@stop

@section('js')
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target;
            Swal.fire({
                title: 'Hapus Logo?',
                text: 'Data tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }
    </script>
@stop
