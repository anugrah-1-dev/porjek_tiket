@extends('adminlte::page')

@section('title', 'Pendaftar Program Offline')

@section('content_header')
    <h1>Pendaftaran Program Offline</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>TRX ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Program</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftar as $key => $data)
                        <tr>
                            <td>{{ $pendaftar->firstItem() + $key }}</td>
                            <td>{{ $data->trx_id }}</td>
                            <td>{{ $data->nama_lengkap }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->no_hp }}</td>
                            <td>{{ $data->program->nama ?? '-' }}</td>
                            <td>{{ $data->period->date ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $data->status === 'pending' ? 'warning' : ($data->status === 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.pendaftaran.offline.show', $data->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <form action="{{ route('admin.pendaftaran.offline.destroy', $data->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center">Belum ada pendaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $pendaftar->links() }}
        </div>
    </div>
@endsection
