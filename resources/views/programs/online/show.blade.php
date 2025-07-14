<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $program->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }
        .program-detail {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }
        .table-custom th, .table-custom td {
            padding: 10px;
            border: 1px solid #ffa500;
        }
        .program-title h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
        }
    </style>
</head>
<body>

<div class="program-detail">
    <div class="program-title text-center mb-4">
        <h1>{{ $program->nama }}</h1>
    </div>

    @if ($program->thumbnail)
        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $program->thumbnail) }}" class="img-fluid rounded" alt="{{ $program->nama }}">
        </div>
    @endif

    <table class="table table-bordered table-custom mb-4">
        <tr>
            <th>Harga</th>
            <td>Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
        </tr>
        @if(isset($program->jadwal_mulai))
        <tr>
            <th>Jadwal</th>
            <td>
                {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M Y') }} -
                {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}
            </td>
        </tr>
        @endif
        <tr>
            <th>Fasilitas</th>
            <td>
                @if (is_string($program->features_program))
                    <ul>
                        @foreach(explode("\n", $program->features_program) as $fitur)
                            <li>{{ $fitur }}</li>
                        @endforeach
                    </ul>
                @else
                    <em>Tidak ada data fasilitas.</em>
                @endif
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                @if($program->is_active)
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-danger">Tidak Aktif</span>
                @endif
            </td>
        </tr>
    </table>

    <h4 class="mb-3">Form Pendaftaran</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{
        request()->routeIs('public.program.online.show')
            ? route('public.program.online.daftar', $program->slug)
            : route('public.program.offline.daftar', $program->slug)
    }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No. HP</label>
            <input type="text" name="no_hp" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Asal Kota</label>
            <input type="text" name="asal_kota" class="form-control">
        </div>

        @if(isset($periods))
        <div class="mb-3">
            <label>Periode</label>
            <select name="period_id" class="form-select" required>
                <option value="">Pilih Periode</option>
                @foreach($periods as $p)
                    <option value="{{ $p->id }}">
                        {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        @if(request()->routeIs('public.program.offline.show') && isset($transports))
        <div class="mb-3">
            <label>Transportasi</label>
            <select name="transport_id" class="form-select">
                <option value="">Pilih Transportasi</option>
                @foreach($transports as $transport)
                    <option value="{{ $transport->id }}">{{ $transport->nama }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="mb-3">
            <label>Bukti Pembayaran (opsional)</label>
            <input type="file" name="bukti_pembayaran" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
    </form>

    <a href="{{ url('/') }}" class="btn btn-link mt-4 d-block text-center">⬅ Kembali ke Beranda</a>
</div>

</body>
</html>
