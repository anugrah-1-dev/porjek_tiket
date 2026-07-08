<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Tiket Konser - Brilliant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('asset/img/logo25.jpeg') }}" type="image/png">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f4f6f9; }
        .form-card { border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.1); }
        .form-label { font-weight: 600; }
        .harga-info { background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 12px 16px; }
        .kategori-badge { font-size: 0.95rem; }
    </style>
</head>

<body>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: {!! json_encode(session('success')) !!},
            confirmButtonColor: '#FFA109',
        });
    });
</script>
@endif

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            html: {!! json_encode(implode('<br>', $errors->all())) !!},
        });
    });
</script>
@endif

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="text-center mb-4">
                <a href="{{ route('landing') }}" class="text-decoration-none text-muted">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                </a>
                <h2 class="fw-bold mt-2" style="color:#FFA109;">Pembelian Tiket Konser</h2>
                <p class="text-muted">Isi formulir di bawah ini untuk memesan tiket.</p>
            </div>

            <div class="card form-card border-0">
                <div class="card-body p-4">

                    {{-- Kategori Terpilih (Read-only) --}}
                    <div class="mb-4">
                        <label class="form-label d-block">Kategori Tiket</label>
                        @if ($kategori === 'member')
                            <span class="badge bg-success px-3 py-2 fs-6">
                                <i class="fas fa-id-card me-1"></i> Member Aktif Brilliant
                            </span>
                        @else
                            <span class="badge bg-warning text-dark px-3 py-2 fs-6">
                                <i class="fas fa-ticket-alt me-1"></i> Umum
                            </span>
                        @endif
                    </div>

                    <div class="harga-info mb-4">
                        <i class="fas fa-info-circle text-warning me-1"></i>
                        Harga per tiket:
                        <span id="infoHargaUmum" {{ old('kategori', $kategori) === 'umum' ? '' : 'style=display:none' }}>
                            Umum — <strong>Rp {{ number_format($hargaUmum, 0, ',', '.') }}</strong>
                        </span>
                        <span id="infoHargaMember" {{ old('kategori', $kategori) === 'member' ? '' : 'style=display:none' }}>
                            Member Aktif — <strong>Rp {{ number_format($hargaMember, 0, ',', '.') }}</strong>
                        </span>
                    </div>

                    <form action="{{ route('tiket-konser.store') }}" method="POST" enctype="multipart/form-data"
                          id="formTiket">
                        @csrf
                        <input type="hidden" name="kategori" id="inputKategori" value="{{ old('kategori', $kategori) }}">

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                   id="nama_lengkap" name="nama_lengkap"
                                   value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama lengkap Anda">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ttl" class="form-label">Tempat, Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('ttl') is-invalid @enderror"
                                   id="ttl" name="ttl"
                                   value="{{ old('ttl') }}" required placeholder="Contoh: Kediri, 01 Januari 2000">
                            @error('ttl')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                   id="no_hp" name="no_hp"
                                   value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_tiket" class="form-label">Jumlah Tiket <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah_tiket') is-invalid @enderror"
                                   id="jumlah_tiket" name="jumlah_tiket"
                                   value="{{ old('jumlah_tiket', 1) }}" min="1" max="100" required>
                            @error('jumlah_tiket')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Harga</label>
                            <div class="form-control bg-light fw-bold text-success" id="totalHargaDisplay">
                                Rp {{ number_format($hargaPerTiket, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bukti_pembayaran" class="form-label">
                                Foto Bukti Pembayaran / Transfer <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                                   id="bukti_pembayaran" name="bukti_pembayaran"
                                   accept="image/jpg,image/jpeg,image/png,image/webp" required>
                            <div class="form-text">Format: JPG, JPEG, PNG, WEBP. Maks 5 MB.</div>
                            @error('bukti_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Bukti member — ditampilkan hanya jika kategori = member --}}
                        <div class="mb-3" id="wrapBuktiMember" style="display:none;">
                            <label for="bukti_member" class="form-label">
                                Foto Bukti Member Aktif <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control @error('bukti_member') is-invalid @enderror"
                                   id="bukti_member" name="bukti_member"
                                   accept="image/jpg,image/jpeg,image/png,image/webp">
                            <div class="form-text">Contoh: kuitansi atau dokumen resmi member. Maks 5 MB.</div>
                            @error('bukti_member')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-warning fw-bold py-2" style="font-size:1.05rem;">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Pesanan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const hargaUmum   = {{ $hargaUmum }};
    const hargaMember = {{ $hargaMember }};
    const kategori    = "{{ $kategori }}";

    function getHargaAktif() {
        return kategori === 'member' ? hargaMember : hargaUmum;
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateTotal() {
        const jumlah = parseInt(document.getElementById('jumlah_tiket').value) || 0;
        document.getElementById('totalHargaDisplay').textContent = formatRupiah(jumlah * getHargaAktif());
    }

    function initFormState() {
        const wrap  = document.getElementById('wrapBuktiMember');
        const input = document.getElementById('bukti_member');
        const infoUmum   = document.getElementById('infoHargaUmum');
        const infoMember = document.getElementById('infoHargaMember');

        if (kategori === 'member') {
            wrap.style.display       = 'block';
            input.required           = true;
            infoUmum.style.display   = 'none';
            infoMember.style.display = '';
        } else {
            wrap.style.display       = 'none';
            input.required           = false;
            infoUmum.style.display   = '';
            infoMember.style.display = 'none';
        }
        updateTotal();
    }

    document.getElementById('jumlah_tiket').addEventListener('input', updateTotal);

    document.addEventListener('DOMContentLoaded', function () {
        initFormState();
    });
</script>

</body>
</html>
