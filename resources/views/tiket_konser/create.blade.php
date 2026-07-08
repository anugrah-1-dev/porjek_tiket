<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Tiket Konser - Brilliant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('asset/img/logo25.jpeg') }}" type="image/png">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f1d2f 0%, #1a3a5c 60%, #0d2137 100%);
            min-height: 100vh;
            padding: 2rem 0 3rem;
        }

        /* ── Back link ── */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: rgba(255,255,255,.65);
            font-size: .85rem;
            text-decoration: none;
            transition: color .2s;
        }
        .back-link:hover { color: #FFA109; }

        /* ── Page title ── */
        .page-title { color: #FFA109; font-weight: 700; font-size: 1.7rem; }
        .page-subtitle { color: rgba(255,255,255,.5); font-size: .85rem; }

        /* ── Category hero card ── */
        .kat-hero {
            border-radius: 16px;
            padding: 1.25rem 1.4rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255,255,255,.12);
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        .kat-hero-icon {
            width: 52px;
            height: 52px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.45rem;
            flex-shrink: 0;
        }
        .kat-hero-body { flex: 1; min-width: 0; }
        .kat-hero-name {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 .2rem;
            line-height: 1.3;
        }
        .kat-hero-price {
            font-size: .82rem;
            font-weight: 700;
            padding: .18rem .7rem;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: .6rem;
        }
        .kat-hero-desc {
            font-size: .82rem;
            color: rgba(255,255,255,.6);
            margin: 0;
            list-style: none;
            padding: 0;
        }
        .kat-hero-desc li { padding: .1rem 0; }
        .kat-hero-desc li::before { content: "✓ "; color: currentColor; }

        /* Variants */
        .kat-umum  { background: linear-gradient(135deg,rgba(255,161,9,.18),rgba(255,161,9,.04)); }
        .kat-umum  .kat-hero-icon  { background:rgba(255,161,9,.2);  color:#FFC107; }
        .kat-umum  .kat-hero-price { background:rgba(255,161,9,.2);  color:#FFC107; }
        .kat-vip   { background: linear-gradient(135deg,rgba(220,53,69,.22),rgba(220,53,69,.04)); }
        .kat-vip   .kat-hero-icon  { background:rgba(220,53,69,.2);  color:#ff7b87; }
        .kat-vip   .kat-hero-price { background:rgba(220,53,69,.2);  color:#ff7b87; }
        .kat-member{ background: linear-gradient(135deg,rgba(40,167,69,.22),rgba(40,167,69,.04)); }
        .kat-member .kat-hero-icon { background:rgba(40,167,69,.2);  color:#5dd879; }
        .kat-member .kat-hero-price{ background:rgba(40,167,69,.2);  color:#5dd879; }
        .kat-spesial{ background: linear-gradient(135deg,rgba(0,123,255,.22),rgba(0,64,133,.04)); }
        .kat-spesial .kat-hero-icon { background:rgba(0,123,255,.2); color:#74b9ff; }
        .kat-gratis { background:linear-gradient(135deg,#28a745,#20c997); color:#fff; }

        /* ── Price info strip ── */
        .harga-strip {
            background: rgba(255,161,9,.1);
            border: 1px solid rgba(255,161,9,.3);
            border-radius: 10px;
            padding: .7rem 1rem;
            font-size: .85rem;
            color: rgba(255,255,255,.8);
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1.4rem;
        }
        .harga-strip strong { color: #FFC107; }

        /* ── Main form card ── */
        .form-card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 20px;
            padding: 1.8rem;
            backdrop-filter: blur(10px);
        }

        /* ── Form controls ── */
        .form-label {
            font-weight: 600;
            font-size: .85rem;
            color: rgba(255,255,255,.8);
            margin-bottom: .4rem;
        }
        .form-control, .form-select {
            background: rgba(255,255,255,.07) !important;
            border: 1px solid rgba(255,255,255,.15) !important;
            border-radius: 10px !important;
            color: #fff !important;
            font-size: .9rem;
            padding: .65rem .9rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control::placeholder { color: rgba(255,255,255,.35); }
        .form-control:focus, .form-select:focus {
            border-color: rgba(255,161,9,.6) !important;
            box-shadow: 0 0 0 3px rgba(255,161,9,.15) !important;
            background: rgba(255,255,255,.1) !important;
            outline: none;
        }
        .form-select option { background: #1a3a5c; color: #fff; }
        .form-control.bg-light {
            background: rgba(255,255,255,.08) !important;
            color: #5dd879 !important;
            font-weight: 700;
            cursor: default;
        }

        /* ── Bank detail card ── */
        #bankDetail {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.12) !important;
            border-radius: 10px;
            padding: .9rem 1rem;
        }
        #bankDetailName  { color: #fff; font-weight: 700; }
        #bankDetailOwner { color: rgba(255,255,255,.6); font-size: .82rem; }
        #bankDetailNumber{ color: #FFC107; font-size: 1.05rem; letter-spacing: 1.5px; font-weight: 700; }

        /* ── Alert boxes ── */
        .alert {
            border-radius: 10px;
            font-size: .82rem;
        }
        .form-text { color: rgba(255,255,255,.45); font-size: .78rem; }
        .invalid-feedback { font-size: .78rem; }

        /* ── Section divider ── */
        .section-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,.1);
            margin: 1.4rem 0;
        }

        /* ── Submit button ── */
        .btn-submit {
            background: linear-gradient(135deg,#FFA109,#ff7c00);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            padding: .85rem 1.5rem;
            width: 100%;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 6px 18px rgba(255,161,9,.4);
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(255,161,9,.5);
        }
        .btn-submit:active { transform: translateY(0); }
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

<div class="container" style="max-width:600px;">

    {{-- Back + title --}}
    <div class="text-center mb-4">
        <a href="{{ route('landing') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
        <h1 class="page-title mt-3 mb-1">
            <i class="fas fa-music me-2"></i>Pembelian Tiket Konser
        </h1>
        <p class="page-subtitle">Brilliant English Course 2026 — isi formulir di bawah ini</p>
    </div>

    {{-- Category hero --}}
    @php
        $namaKategori = match($kategori) {
            'vip'     => $namaVip,
            'member'  => 'Spesial Member Aktif Brilliant English Course & BIE Plus',
            'spesial' => 'Spesial Member Brilliant English Course & BIE Plus',
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
        $katClass = match($kategori) {
            'vip'     => 'kat-vip',
            'member'  => 'kat-member',
            'spesial' => 'kat-spesial',
            default   => 'kat-umum',
        };
        $iconClass = match($kategori) {
            'vip'     => 'fas fa-crown',
            'member'  => 'fas fa-id-card',
            'spesial' => 'fas fa-star',
            default   => 'fas fa-ticket-alt',
        };
        $isGratis  = ($hargaKategori == 0);
        $isSpesial = ($kategori === 'spesial');
    @endphp

    <div class="kat-hero {{ $katClass }}">
        <div class="kat-hero-icon">
            <i class="{{ $iconClass }}"></i>
        </div>
        <div class="kat-hero-body">
            <p class="kat-hero-name">{{ $namaKategori }}</p>
            @if ($isGratis)
                <span class="kat-hero-price kat-gratis">GRATIS 🎉</span>
            @else
                <span class="kat-hero-price">Rp {{ number_format($hargaKategori, 0, ',', '.') }} / tiket</span>
            @endif
            @if ($deskripsiKategori)
                <ul class="kat-hero-desc mt-1">
                    @foreach (array_filter(array_map('trim', explode("\n", $deskripsiKategori))) as $benefit)
                        <li>{{ $benefit }}</li>
                    @endforeach
                </ul>
            @endif
            @if ($isGratis)
                <div class="alert alert-success mt-2 mb-0 py-2 px-3" style="font-size:.8rem;">
                    <i class="fas fa-gift me-1"></i>
                    Selamat! Tiket <strong>GRATIS</strong>. Cukup upload bukti keanggotaan periode Juli–Agustus.
                </div>
            @endif
            @if ($isSpesial)
                <div class="alert alert-warning mt-2 mb-0 py-2 px-3" style="font-size:.8rem;">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    <strong>Syarat:</strong> Khusus member aktif Brilliant minimal 1 bulan (mulai dari periode 10 Juli–Agustus 2026). Bukti keanggotaan wajib diunggah.
                </div>
            @endif
        </div>
    </div>

    {{-- Harga strip --}}
    <div class="harga-strip">
        <i class="fas fa-info-circle" style="color:#FFA109;font-size:1rem;"></i>
        Harga per tiket:&nbsp;
        @if ($isGratis)
            <strong>GRATIS</strong>
        @else
            <strong>Rp {{ number_format($hargaKategori, 0, ',', '.') }}</strong>
        @endif
    </div>

    {{-- Form card --}}
    <div class="form-card">
        <form action="{{ route('tiket-konser.store') }}" method="POST" enctype="multipart/form-data" id="formTiket">
            @csrf
            <input type="hidden" name="kategori" id="inputKategori" value="{{ old('kategori', $kategori) }}">

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                       id="nama_lengkap" name="nama_lengkap"
                       value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama lengkap Anda">
                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="ttl" class="form-label">Tempat, Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('ttl') is-invalid @enderror"
                       id="ttl" name="ttl"
                       value="{{ old('ttl') }}" required placeholder="Contoh: Kediri, 01 Januari 2000">
                @error('ttl')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                       id="no_hp" name="no_hp"
                       value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx">
                @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="jumlah_tiket" class="form-label">Jumlah Tiket <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('jumlah_tiket') is-invalid @enderror"
                       id="jumlah_tiket" name="jumlah_tiket"
                       value="{{ old('jumlah_tiket', 1) }}" min="1" max="100" required>
                @error('jumlah_tiket')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Total Harga</label>
                <div class="form-control bg-light fw-bold" id="totalHargaDisplay">
                    Rp {{ number_format($hargaPerTiket, 0, ',', '.') }}
                </div>
            </div>

            {{-- Bank & bukti pembayaran (disembunyikan jika spesial/gratis) --}}
            @if (!$isSpesial)
            <hr class="section-divider">
            <div class="mb-3">
                <label for="bank_id" class="form-label">Bank Tujuan Transfer <span class="text-danger">*</span></label>
                <select class="form-select @error('bank_id') is-invalid @enderror"
                        id="bank_id" name="bank_id" required
                        onchange="tampilDetailBank(this)">
                    <option value="">— Pilih Bank —</option>
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
                @error('bank_id')<div class="invalid-feedback">{{ $message }}</div>@enderror

                <div id="bankDetail" class="mt-2" style="display:none;">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-university" style="color:#FFC107;font-size:1.3rem;"></i>
                        <div>
                            <div id="bankDetailName"></div>
                            <div><small id="bankDetailOwner"></small></div>
                            <div id="bankDetailNumber"></div>
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
                <div class="form-text"><i class="fas fa-image me-1"></i> Format: JPG, JPEG, PNG, WEBP. Maks 5 MB.</div>
                @error('bukti_pembayaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            @endif

            {{-- Bukti member — untuk kategori member & spesial --}}
            <div id="wrapBuktiMember" style="{{ in_array($kategori, ['member','spesial']) ? '' : 'display:none;' }}">
                <hr class="section-divider">

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
                        <i class="fas fa-info-circle me-1" style="color:#5dd879;"></i>
                        {{ $isSpesial
                            ? 'Masukkan periode keanggotaan aktif (minimal 1 bulan, Juli–Agustus 2026).'
                            : 'Masukkan periode aktif keanggotaan Anda.' }}
                    </div>
                    @error('periode_member')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

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
                        <i class="fas fa-image me-1"></i>
                        @if ($isSpesial)
                            Upload foto kuitansi pendaftaran atau dokumen resmi keanggotaan periode Juli–Agustus. Maks 5 MB.
                        @else
                            Contoh: kuitansi atau dokumen resmi member. Maks 5 MB.
                        @endif
                    </div>
                    @error('bukti_member')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane me-2"></i> Kirim Pesanan
                </button>
            </div>
        </form>
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
