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
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }
        .program-img img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .form-section {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="program-detail">
    <h1 class="text-center mb-4">{{ $program->nama }}</h1>

    @if ($program->thumbnail)
        <div class="program-img text-center">
            <img src="{{ asset('storage/' . $program->thumbnail) }}" alt="{{ $program->nama }}">
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Harga</th>
            <td>Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Jadwal</th>
            <td>{{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Kuota</th>
            <td>{{ $program->kuota }}</td>
        </tr>
        <tr>
            <th>Fasilitas</th>
            <td>
                @if (is_string($program->features_program) && !empty($program->features_program))
                    <ul>
                        @foreach (explode("\n", $program->features_program) as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                @else
                    <em>Tidak ada fasilitas tersedia.</em>
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

    <div class="form-section">
        <h3 class="mb-3">Form Pendaftaran</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('public.program.offline.daftar', $program->slug) }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label>No. HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
            </div>

            <div class="mb-3">
                <label>Asal Kota</label>
                <input type="text" name="asal_kota" class="form-control" value="{{ old('asal_kota') }}">
            </div>

            <div class="mb-3">
                <label>No. HP Wali</label>
                <input type="text" name="no_wali" class="form-control" value="{{ old('no_wali') }}">
            </div>

            <div class="mb-3">
                <label>Transportasi</label>
                <select name="transport_id" class="form-select">
                    <option value="">Pilih Transportasi</option>
                    @foreach($transports as $transport)
                        <option value="{{ $transport->id }}">{{ $transport->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Periode</label>
                <select name="period_id" class="form-select">
                    <option value="">Pilih Periode</option>
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}">
                            {{ \Carbon\Carbon::parse($period->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($period->tanggal_selesai)->format('d M Y') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Bukti Pembayaran (jika ada)</label>
                <input type="file" name="bukti_pembayaran" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
        </form>
    </div>
</div>

</body>
</html>
