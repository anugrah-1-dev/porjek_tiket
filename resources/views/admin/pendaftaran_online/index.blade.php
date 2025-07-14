@extends('adminlte::page')

@section('title', 'Pendaftar Program Online')

@section('content_header')
    <h1 class="mb-3">Daftar Pendaftar Program Online</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-hover text-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>TRX ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Kota</th>
                        <th>Program</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Tgl Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftar as $index => $data)
                        <tr>
                            <td>{{ $pendaftar->firstItem() + $index }}</td>
                            <td>{{ $data->trx_id }}</td>
                            <td>{{ $data->nama_lengkap }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->no_hp ?? '-' }}</td>
                            <td>{{ $data->asal_kota ?? '-' }}</td>
                            <td>{{ $data->program->nama ?? '-' }}</td>
                            <td>{{ $data->period->date ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $data->status == 'pending' ? 'warning' : ($data->status == 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.pendaftaran.online.show', $data->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.pendaftaran.online.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="11" class="text-center">Belum ada pendaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $pendaftar->links() }}
        </div>
    </div>
@endsection
