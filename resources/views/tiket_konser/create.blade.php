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

                    {{-- Kategori terpilih (fixed, tidak bisa diubah) --}}
                    @php
                        $namaKategori = match($kategori) {
                            'vip'     => $namaVip,
                            'member'  => 'Spesial Member Brilliant English Course & BIE Plus',
                            'spesial' => 'Spesial Member Brilliant English Course & BIE Plus ( Bulan Juli - Agustus)',
                            default   => $namaUmum,
                        };
                        $hargaKategori = match($kategori) {
                            'vip'     => $hargaVip,
                            'member'  => $hargaMember,
                            'spesial' => $hargaSpesial,
                            default   => $hargaUmum,
                        };
                        $deskripsiKategori = match($kategori) {
                            'vip'     => $deskripsiVip,
                            'member'  => $deskripsiMember,
                            'spesial' => $deskripsiSpesial,
                            default   => $deskripsiUmum,
                        };
                        $badgeClass = match($kategori) {
                            'vip'     => 'danger',
                            'member'  => 'success',
                            'spesial' => 'primary',
                            default   => 'warning',
                        };
                        $iconClass = match($kategori) {
                            'vip'     => 'fas fa-crown',
                            'member'  => 'fas fa-id-card',
                            'spesial' => 'fas fa-star',
                            default   => 'fas fa-ticket-alt',
                        };
                        $isGratis = ($hargaKategori == 0);
                        $isSpesial = ($kategori === 'spesial');
                    @endphp

                    <div class="mb-4 p-3 border rounded-3 border-{{ $badgeClass }}" style="background:rgba(0,0,0,.02)">
                        <div class="d-flex align-items-center gap-3 mb-2 flex-wrap">
                            <span class="badge bg-{{ $badgeClass }} fs-6 px-3 py-2">
                                <i class="{{ $iconClass }} me-1"></i> {{ $namaKategori }}
                            </span>
                            @if ($isGratis)
                                <span class="fw-bold text-success" style="font-size:1.1rem;">
                                    🎉 GRATIS
                                </span>
                            @else
                                <span class="fw-bold" style="font-size:1.1rem;">
                                    Rp {{ number_format($hargaKategori, 0, ',', '.') }} / tiket
                                </span>
                            @endif
                        </div>
                        @if ($deskripsiKategori)
                            <ul class="mb-0 ps-3" style="font-size:.92rem;">
                                @foreach (array_filter(array_map('trim', explode("\n", $deskripsiKategori))) as $benefit)
                                    <li>{{ $benefit }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if ($isGratis)
                            <div class="alert alert-success mt-2 mb-0 py-2 px-3" style="font-size:.88rem;">
                                <i class="fas fa-gift me-1"></i>
                                Selamat! Kamu mendapatkan tiket <strong>GRATIS</strong>. Cukup upload bukti keanggotaan periode Juli-Agustus.
                            </div>
                        @endif
                        @if ($isSpesial)
                            <div class="alert alert-warning mt-2 mb-0 py-2 px-3" style="font-size:.88rem;">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                <strong>Syarat:</strong> Khusus member aktif Brilliant <strong>minimal 1 bulan</strong> (periode Juli–Agustus 2026). Bukti keanggotaan wajib diunggah.
                            </div>
                        @endif
                    </div>

                    <div class="harga-info mb-4">
                        <i class="fas fa-info-circle text-warning me-1"></i>
                        Harga per tiket:
                        @if ($isGratis)
                            <strong class="text-success">GRATIS</strong>
                        @else
                            <strong>Rp {{ number_format($hargaKategori, 0, ',', '.') }}</strong>
                        @endif
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

                        {{-- Pilih Bank & Bukti Pembayaran (disembunyikan jika GRATIS) --}}
                        @if (!$isSpesial)
                        <div class="mb-3">
                            <label for="bank_id" class="form-label">Bank Tujuan Transfer <span class="text-danger">*</span></label>
                            <select class="form-select @error('bank_id') is-invalid @enderror"
                                    id="bank_id" name="bank_id" required
                                    onchange="tampilDetailBank(this)">
                                <option value="">-- Pilih Bank --</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}"
                                            data-name="{{ $bank->name }}"
                                            data-owner="{{ $bank->owner }}"
                                            data-number="{{ $bank->number }}"
                                            {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->name }} — {{ $bank->owner }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bank_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="bankDetail" class="mt-2 p-3 border rounded bg-light" style="display:none;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-university text-warning fs-5"></i>
                                    <div>
                                        <div class="fw-bold" id="bankDetailName"></div>
                                        <div class="text-muted small">a.n. <span id="bankDetailOwner"></span></div>
                                        <div class="fw-semibold text-dark" id="bankDetailNumber" style="font-size:1.05rem;letter-spacing:1px;"></div>
                                    </div>
                                </div>
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
                        @endif

                        {{-- Bukti member — untuk kategori member & spesial --}}
                        <div id="wrapBuktiMember" style="{{ in_array($kategori, ['member','spesial']) ? '' : 'display:none;' }}">

                            {{-- Periode Member --}}
                            <div class="mb-3">
                                <label for="periode_member" class="form-label">
                                    Periode Member Aktif <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('periode_member') is-invalid @enderror"
                                       id="periode_member" name="periode_member"
                                       value="{{ old('periode_member') }}"
                                       placeholder="{{ $isSpesial ? 'Contoh: Juli 2026 - Agustus 2026' : 'Contoh: Januari 2025 - Januari 2026' }}">
                                <div class="form-text">
                                    <i class="fas fa-info-circle text-success me-1"></i>
                                    {{ $isSpesial
                                        ? 'Masukkan periode keanggotaan aktif kamu (minimal 1 bulan, Juli–Agustus 2026).'
                                        : 'Masukkan periode aktif keanggotaan Anda.' }}
                                </div>
                                @error('periode_member')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bukti Member --}}
                            <div class="mb-3">
                                <label for="bukti_member" class="form-label">
                                    @if ($isSpesial)
                                        Foto Kuitansi / Bukti Resmi Keanggotaan <span class="text-danger">*</span>
                                    @else
                                        Foto Bukti Member Aktif <span class="text-danger">*</span>
                                    @endif
                                </label>
                                <input type="file" class="form-control @error('bukti_member') is-invalid @enderror"
                                       id="bukti_member" name="bukti_member"
                                       accept="image/jpg,image/jpeg,image/png,image/webp">
                                <div class="form-text">
                                    @if ($isSpesial)
                                        Upload foto kuitansi pendaftaran atau dokumen resmi keanggotaan periode Juli–Agustus. Maks 5 MB.
                                    @else
                                        Contoh: kuitansi atau dokumen resmi member. Maks 5 MB.
                                    @endif
                                </div>
                                @error('bukti_member')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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
    const hargaKategori = {{ $hargaKategori }};
    const kategoriAktif = '{{ $kategori }}';

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateTotal() {
        const jumlah = parseInt(document.getElementById('jumlah_tiket').value) || 0;
        document.getElementById('totalHargaDisplay').textContent = formatRupiah(jumlah * hargaKategori);
    }

    document.getElementById('jumlah_tiket').addEventListener('input', updateTotal);

    document.addEventListener('DOMContentLoaded', function () {
        updateTotal();

        // Toggle bukti member (tampil untuk kategori 'member' dan 'spesial')
        const wrapMember = document.getElementById('wrapBuktiMember');
        const inputMember = document.getElementById('bukti_member');
        if (wrapMember && inputMember) {
            if (kategoriAktif === 'member' || kategoriAktif === 'spesial') {
                wrapMember.style.display = 'block';
                inputMember.required = true;
            } else {
                wrapMember.style.display = 'none';
                inputMember.required = false;
            }
        }

        // Tampilkan detail bank jika ada old value (validasi gagal)
        const bankSelect = document.getElementById('bank_id');
        if (bankSelect && bankSelect.value) tampilDetailBank(bankSelect);
    });

    function tampilDetailBank(select) {
        const opt    = select.options[select.selectedIndex];
        const detail = document.getElementById('bankDetail');
        if (!opt || !opt.value) { detail.style.display = 'none'; return; }
        document.getElementById('bankDetailName').textContent   = opt.getAttribute('data-name');
        document.getElementById('bankDetailOwner').textContent  = opt.getAttribute('data-owner');
        document.getElementById('bankDetailNumber').textContent = opt.getAttribute('data-number');
        detail.style.display = 'block';
    }
</script>

</body>
</html>
