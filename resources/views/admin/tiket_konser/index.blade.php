@extends('adminlte::page')

@section('title', 'Data Tiket Konser')

@section('content_header')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
    <h1 class="m-0">Data Pemesan Tiket Konser</h1>
    <div class="input-group input-group-sm" style="width: 250px;">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama / HP...">
        <span class="input-group-append">
            <button type="button" class="btn btn-default btn-flat">
                <i class="fas fa-search"></i>
            </button>
        </span>
    </div>
</div>
@stop

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-ticket-alt mr-2"></i>Daftar Pemesan</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="tiketTable" class="table table-hover table-bordered mb-0">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>ID Transaksi</th>
                        <th>Nama Lengkap</th>
                        <th>No HP</th>
                        <th>Kategori</th>
                        <th>Jml</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tgl Pesan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tikets as $index => $tiket)
                        <tr>
                            <td>{{ $tikets->firstItem() + $index }}</td>
                            <td><code>{{ $tiket->trx_id }}</code></td>
                            <td>{{ $tiket->nama_lengkap }}</td>
                            <td>{{ $tiket->no_hp }}</td>
                            <td>
                                @if ($tiket->kategori === 'member')
                                    <span class="badge badge-success">Member</span>
                                @elseif ($tiket->kategori === 'vip')
                                    <span class="badge badge-danger">VIP</span>
                                @elseif ($tiket->kategori === 'spesial')
                                    <span class="badge badge-primary">Spesial</span>
                                @else
                                    <span class="badge badge-warning">{{ $tiket->kategori }}</span>
                                @endif
                            </td>
                            <td>{{ $tiket->jumlah_tiket }}</td>
                            <td>Rp {{ number_format($tiket->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @if ($tiket->status === 'diterima')
                                    <span class="badge badge-success">Diterima</span>
                                @elseif ($tiket->status === 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $tiket->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.tiket-konser.show', $tiket->id) }}"
                                       class="btn btn-info" title="Detail & Ubah Status">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.tiket-konser.destroy', $tiket->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus data ini?');"
                                          class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Belum ada data pemesan tiket.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $tikets->links() }}
    </div>
</div>
@stop

@section('js')
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#tiketTable tbody tr').forEach(function (row) {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
</script>
@stop
