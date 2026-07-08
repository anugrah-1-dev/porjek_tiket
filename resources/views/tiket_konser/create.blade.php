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
            background: #0b1929;
            background-image:
                radial-gradient(ellipse 80% 50% at 20% 10%, rgba(26,74,120,.55) 0%, transparent 60%),
                radial-gradient(ellipse 60% 40% at 80% 80%, rgba(10,35,65,.7) 0%, transparent 60%);
            min-height: 100vh;
        }

        /* ────────────────────────────────────────
           TOP HEADER BAR
        ──────────────────────────────────────── */
        .page-header {
            background: rgba(255,255,255,.03);
            border-bottom: 1px solid rgba(255,255,255,.07);
            padding: 1rem 0;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            color: rgba(255,255,255,.55);
            font-size: .82rem;
            text-decoration: none;
            transition: color .2s;
        }
        .back-link:hover { color: #FFA109; }
        .page-header-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
        }
        .page-header-sub {
            font-size: .75rem;
            color: rgba(255,255,255,.4);
            margin: 0;
        }

        /* ────────────────────────────────────────
           MAIN TWO-COLUMN LAYOUT
        ──────────────────────────────────────── */
        .page-body {
            max-width: 1060px;
            margin: 0 auto;
            padding: 2rem 1.25rem 3.5rem;
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 1.75rem;
            align-items: start;
        }

        /* ────────────────────────────────────────
           LEFT PANEL — CATEGORY INFO
        ──────────────────────────────────────── */
        .left-panel {
            position: sticky;
            top: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Category card */
        .kat-card {
            border-radius: 18px;
            padding: 1.4rem;
            border: 1px solid rgba(255,255,255,.1);
            overflow: hidden;
            position: relative;
        }
        .kat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 18px;
            background: inherit;
            z-index: 0;
        }
        .kat-card > * { position: relative; z-index: 1; }

        .kat-card-top {
            display: flex;
            align-items: center;
            gap: .9rem;
            margin-bottom: 1rem;
        }
        .kat-icon-big {
            width: 58px;
            height: 58px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            flex-shrink: 0;
        }
        .kat-name {
            font-size: .95rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.35;
            margin: 0 0 .35rem;
        }
        .kat-price-pill {
            font-size: .78rem;
            font-weight: 700;
            padding: .2rem .75rem;
            border-radius: 20px;
            display: inline-block;
        }
        .kat-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,.1);
            margin: .9rem 0;
        }
        .kat-benefits {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: .8rem;
            color: rgba(255,255,255,.65);
            display: flex;
            flex-direction: column;
            gap: .3rem;
        }
        .kat-benefits li { display: flex; align-items: flex-start; gap: .4rem; }
        .kat-benefits li .chk { flex-shrink: 0; margin-top: 2px; }

        /* Variants */
        .kat-umum   { background: linear-gradient(145deg,rgba(255,161,9,.2),rgba(255,161,9,.05)); }
        .kat-umum   .kat-icon-big   { background:rgba(255,161,9,.22); color:#FFC107; }
        .kat-umum   .kat-price-pill { background:rgba(255,161,9,.2);  color:#FFC107; }
        .kat-umum   .chk            { color:#FFC107; }
        .kat-vip    { background: linear-gradient(145deg,rgba(220,53,69,.25),rgba(220,53,69,.05)); }
        .kat-vip    .kat-icon-big   { background:rgba(220,53,69,.22); color:#ff7b87; }
        .kat-vip    .kat-price-pill { background:rgba(220,53,69,.2);  color:#ff7b87; }
        .kat-vip    .chk            { color:#ff7b87; }
        .kat-member { background: linear-gradient(145deg,rgba(40,167,69,.25),rgba(40,167,69,.05)); }
        .kat-member .kat-icon-big   { background:rgba(40,167,69,.22); color:#5dd879; }
        .kat-member .kat-price-pill { background:rgba(40,167,69,.2);  color:#5dd879; }
        .kat-member .chk            { color:#5dd879; }
        .kat-spesial{ background: linear-gradient(145deg,rgba(0,123,255,.25),rgba(0,64,133,.05)); }
        .kat-spesial .kat-icon-big  { background:rgba(0,123,255,.22); color:#74b9ff; }
        .kat-spesial .kat-price-pill{ background:rgba(0,123,255,.2);  color:#74b9ff; }
        .kat-spesial .chk           { color:#74b9ff; }
        .pill-gratis{ background:linear-gradient(135deg,#28a745,#20c997)!important; color:#fff!important; }

        /* Price summary box */
        .price-summary {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 14px;
            padding: 1rem 1.2rem;
        }
        .price-summary-label {
            font-size: .72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: rgba(255,255,255,.4);
            margin-bottom: .55rem;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: .85rem;
            color: rgba(255,255,255,.7);
            padding: .3rem 0;
        }
        .price-row.total {
            border-top: 1px solid rgba(255,255,255,.1);
            margin-top: .4rem;
            padding-top: .6rem;
            font-weight: 700;
            font-size: .95rem;
            color: #fff;
        }
        .price-val-total { color: #FFC107; font-size: 1rem; }

        /* Alert inside left panel */
        .left-alert {
            border-radius: 12px;
            padding: .75rem 1rem;
            font-size: .79rem;
            border: none;
        }

        /* ────────────────────────────────────────
           RIGHT PANEL — FORM
        ──────────────────────────────────────── */
        .form-card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 20px;
            overflow: hidden;
        }
        .form-section {
            padding: 1.5rem 1.75rem;
        }
        .form-section + .form-section {
            border-top: 1px solid rgba(255,255,255,.07);
        }
        .section-heading {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: rgba(255,255,255,.35);
            margin-bottom: 1.1rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }
        .section-heading::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,.08);
        }

        /* Form controls */
        .form-label {
            font-weight: 600;
            font-size: .82rem;
            color: rgba(255,255,255,.75);
            margin-bottom: .35rem;
        }
        .form-control, .form-select {
            background: rgba(255,255,255,.06) !important;
            border: 1px solid rgba(255,255,255,.13) !important;
            border-radius: 10px !important;
            color: #fff !important;
            font-size: .88rem;
            padding: .62rem .9rem;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .form-control::placeholder { color: rgba(255,255,255,.28); }
        .form-control:focus, .form-select:focus {
            border-color: rgba(255,161,9,.55) !important;
            box-shadow: 0 0 0 3px rgba(255,161,9,.12) !important;
            background: rgba(255,255,255,.09) !important;
            outline: none;
        }
        .form-select option { background: #112035; color: #fff; }
        .form-control.total-display {
            background: rgba(255,255,255,.07) !important;
            color: #5dd879 !important;
            font-weight: 700;
            cursor: default;
            pointer-events: none;
        }
        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* Bank detail */
        #bankDetail {
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1) !important;
            border-radius: 10px;
            padding: .85rem 1rem;
            margin-top: .6rem;
        }
        #bankDetailName  { color: #fff; font-weight: 700; font-size: .88rem; }
        #bankDetailOwner { color: rgba(255,255,255,.5); font-size: .75rem; }
        #bankDetailNumber{ color: #FFC107; font-size: .95rem; letter-spacing: 1.5px; font-weight: 700; margin-top: .15rem; }

        /* Misc */
        .alert        { border-radius: 10px; font-size: .8rem; }
        .form-text    { color: rgba(255,255,255,.4); font-size: .75rem; margin-top: .3rem; }
        .invalid-feedback { font-size: .76rem; }
        .text-danger  { color: #ff6b7a !important; }

        /* Submit */
        .btn-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .6rem;
            width: 100%;
            background: linear-gradient(135deg,#FFA109 0%,#e07400 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: .97rem;
            padding: .9rem 1.5rem;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 5px 18px rgba(255,161,9,.38);
        }
        .btn-submit:hover  { transform: translateY(-2px); box-shadow: 0 9px 26px rgba(255,161,9,.5); }
        .btn-submit:active { transform: translateY(0); }

        /* ────────────────────────────────────────
           RESPONSIVE — collapse to single column
        ──────────────────────────────────────── */
        @media (max-width: 768px) {
            .page-body {
                grid-template-columns: 1fr;
                padding: 1.25rem .9rem 3rem;
                gap: 1.1rem;
            }
            .left-panel { position: static; }
            .input-row  { grid-template-columns: 1fr; gap: .75rem; }
            .form-section { padding: 1.2rem 1.1rem; }
        }
    </style>
</head>

<body>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon:'success', title:'Berhasil!', text:{!! json_encode(session('success')) !!}, confirmButtonColor:'#FFA109' });
    });
</script>
@endif
@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({ icon:'error', title:'Oops!', html:{!! json_encode(implode('<br>', $errors->all())) !!} });
    });
</script>
@endif

{{-- ───── PHP Vars ───── --}}
@php
    $namaKategori = match($kategori) {
        'vip'     => $namaVip,
        'member'  => 'Member Aktif Brilliant English Course & BIE Plus',
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
    $katClass  = match($kategori) {
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

{{-- ───── TOP HEADER ───── --}}
<header class="page-header">
    <div style="max-width:1060px;margin:0 auto;padding:0 1.25rem;
                display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
        <a href="{{ route('landing') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>
        <div style="text-align:right;">
            <p class="page-header-title"><i class="fas fa-music" style="color:#FFA109;margin-right:.4rem;"></i>Pembelian Tiket Konser</p>
            <p class="page-header-sub">Brilliant English Course 2026</p>
        </div>
    </div>
</header>

{{-- ───── TWO-COLUMN BODY ───── --}}
<div class="page-body">

    {{-- ══ LEFT PANEL ══ --}}
    <aside class="left-panel">

        {{-- Category card --}}
        <div class="kat-card {{ $katClass }}">
            <div class="kat-card-top">
                <div class="kat-icon-big">
                    <i class="{{ $iconClass }}"></i>
                </div>
                <div>
                    <p class="kat-name">{{ $namaKategori }}</p>
                    @if ($isGratis)
                        <span class="kat-price-pill pill-gratis">GRATIS 🎉</span>
                    @else
                        <span class="kat-price-pill">Rp {{ number_format($hargaKategori, 0, ',', '.') }} / tiket</span>
                    @endif
                </div>
            </div>
            @if ($deskripsiKategori)
                <hr class="kat-divider">
                <ul class="kat-benefits">
                    @foreach (array_filter(array_map('trim', explode("\n", $deskripsiKategori))) as $benefit)
                        <li><i class="fas fa-check-circle chk" style="font-size:.7rem;"></i>{{ $benefit }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Price summary --}}
        <div class="price-summary">
            <p class="price-summary-label"><i class="fas fa-receipt me-1"></i> Ringkasan Harga</p>
            <div class="price-row">
                <span>Harga / tiket</span>
                <span>
                    @if ($isGratis) <span style="color:#5dd879;font-weight:700;">GRATIS</span>
                    @else Rp {{ number_format($hargaKategori, 0, ',', '.') }}
                    @endif
                </span>
            </div>
            <div class="price-row">
                <span>Jumlah tiket</span>
                <span id="summaryQty">1</span>
            </div>
            <div class="price-row total">
                <span>Total</span>
                <span class="price-val-total" id="summaryTotal">
                    @if ($isGratis) GRATIS
                    @else Rp {{ number_format($hargaPerTiket, 0, ',', '.') }}
                    @endif
                </span>
            </div>
        </div>

        {{-- Alert (gratis / spesial) --}}
        @if ($isGratis)
            <div class="alert alert-success left-alert">
                <i class="fas fa-gift me-1"></i>
                Tiket <strong>GRATIS</strong>! Upload bukti keanggotaan periode Juli–Agustus untuk konfirmasi.
            </div>
        @endif
        @if ($isSpesial)
            <div class="alert alert-warning left-alert">
                <i class="fas fa-exclamation-triangle me-1"></i>
                <strong>Syarat:</strong> Member aktif Brilliant minimal 1 bulan (periode 10 Juli–Agustus 2026). Wajib upload bukti keanggotaan.
            </div>
        @endif

    </aside>

    {{-- ══ RIGHT PANEL — FORM ══ --}}
    <div class="form-card">
        <form action="{{ route('tiket-konser.store') }}" method="POST" enctype="multipart/form-data" id="formTiket">
            @csrf
            <input type="hidden" name="kategori" value="{{ old('kategori', $kategori) }}">

            {{-- Section: Data Diri --}}
            <div class="form-section">
                <p class="section-heading"><i class="fas fa-user me-1"></i>Data Diri</p>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                           id="nama_lengkap" name="nama_lengkap"
                           value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap sesuai identitas">
                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="ttl" class="form-label">Tempat, Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('ttl') is-invalid @enderror"
                           id="ttl" name="ttl"
                           value="{{ old('ttl') }}" required placeholder="Contoh: Kediri, 01 Januari 2000">
                    @error('ttl')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-0">
                    <label for="no_hp" class="form-label">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                           id="no_hp" name="no_hp"
                           value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx">
                    @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Section: Jumlah & Total --}}
            <div class="form-section">
                <p class="section-heading"><i class="fas fa-ticket-alt me-1"></i>Jumlah Tiket</p>

                <div class="input-row">
                    <div>
                        <label for="jumlah_tiket" class="form-label">Jumlah Tiket <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah_tiket') is-invalid @enderror"
                               id="jumlah_tiket" name="jumlah_tiket"
                               value="{{ old('jumlah_tiket', 1) }}" min="1" max="100" required>
                        @error('jumlah_tiket')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="form-label">Total Harga</label>
                        <div class="form-control total-display" id="totalHargaDisplay">
                            Rp {{ number_format($hargaPerTiket, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section: Pembayaran (bukan spesial) --}}
            @if (!$isSpesial)
            <div class="form-section">
                <p class="section-heading"><i class="fas fa-university me-1"></i>Pembayaran</p>

                <div class="mb-3">
                    <label for="bank_id" class="form-label">Bank Tujuan Transfer <span class="text-danger">*</span></label>
                    <select class="form-select @error('bank_id') is-invalid @enderror"
                            id="bank_id" name="bank_id" required onchange="tampilDetailBank(this)">
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
                    <div id="bankDetail" style="display:none;">
                        <div style="display:flex;align-items:center;gap:.75rem;">
                            <i class="fas fa-university" style="color:#FFC107;font-size:1.2rem;flex-shrink:0;"></i>
                            <div>
                                <div id="bankDetailName"></div>
                                <div id="bankDetailOwner"></div>
                                <div id="bankDetailNumber"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-0">
                    <label for="bukti_pembayaran" class="form-label">
                        Foto Bukti Pembayaran / Transfer <span class="text-danger">*</span>
                    </label>
                    <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                           id="bukti_pembayaran" name="bukti_pembayaran"
                           accept="image/jpg,image/jpeg,image/png,image/webp" required>
                    <div class="form-text"><i class="fas fa-image me-1"></i> JPG / PNG / WEBP, maks 5 MB.</div>
                    @error('bukti_pembayaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            @endif

            {{-- Section: Bukti Member (member & spesial) --}}
            <div id="wrapBuktiMember" style="{{ in_array($kategori, ['member','spesial']) ? '' : 'display:none;' }}">
                <div class="form-section">
                    <p class="section-heading"><i class="fas fa-id-card me-1"></i>Keanggotaan</p>

                    <div class="mb-3">
                        <label for="periode_member" class="form-label">Periode Member Aktif <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('periode_member') is-invalid @enderror"
                               id="periode_member" name="periode_member"
                               value="{{ old('periode_member') }}"
                               placeholder="{{ $isSpesial ? 'Contoh: Juli 2026 - Agustus 2026' : 'Contoh: Januari 2025 - Januari 2026' }}">
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1" style="color:#74b9ff;"></i>
                            {{ $isSpesial ? 'Minimal 1 bulan, periode Juli–Agustus 2026.' : 'Masukkan periode aktif keanggotaan Anda.' }}
                        </div>
                        @error('periode_member')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-0">
                        <label for="bukti_member" class="form-label">
                            {{ $isSpesial ? 'Foto Kuitansi / Bukti Resmi Keanggotaan' : 'Foto Bukti Member Aktif' }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control @error('bukti_member') is-invalid @enderror"
                               id="bukti_member" name="bukti_member"
                               accept="image/jpg,image/jpeg,image/png,image/webp">
                        <div class="form-text">
                            <i class="fas fa-image me-1"></i>
                            {{ $isSpesial ? 'Kuitansi/dokumen resmi keanggotaan Juli–Agustus. Maks 5 MB.' : 'Kuitansi atau dokumen resmi member. Maks 5 MB.' }}
                        </div>
                        @error('bukti_member')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="form-section">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Kirim Pesanan
                </button>
            </div>

        </form>
    </div>

</div>{{-- end .page-body --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const hargaKategori = {{ $hargaKategori }};
    const isGratis      = {{ $isGratis ? 'true' : 'false' }};
    const kategoriAktif = '{{ $kategori }}';

    function formatRupiah(n) {
        return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateTotal() {
        const qty    = parseInt(document.getElementById('jumlah_tiket').value) || 0;
        const total  = qty * hargaKategori;
        const dispEl = document.getElementById('totalHargaDisplay');
        const sumQ   = document.getElementById('summaryQty');
        const sumT   = document.getElementById('summaryTotal');

        if (dispEl) dispEl.textContent = isGratis ? 'GRATIS' : formatRupiah(total);
        if (sumQ)   sumQ.textContent   = qty;
        if (sumT)   sumT.textContent   = isGratis ? 'GRATIS' : formatRupiah(total);
    }

    document.getElementById('jumlah_tiket').addEventListener('input', updateTotal);

    document.addEventListener('DOMContentLoaded', function () {
        updateTotal();

        const wrapMember  = document.getElementById('wrapBuktiMember');
        const inputMember = document.getElementById('bukti_member');
        if (wrapMember && inputMember) {
            const show = kategoriAktif === 'member' || kategoriAktif === 'spesial';
            wrapMember.style.display = show ? 'block' : 'none';
            inputMember.required     = show;
        }

        const bankSelect = document.getElementById('bank_id');
        if (bankSelect && bankSelect.value) tampilDetailBank(bankSelect);
    });

    function tampilDetailBank(select) {
        const opt    = select.options[select.selectedIndex];
        const detail = document.getElementById('bankDetail');
        if (!opt || !opt.value) { detail.style.display = 'none'; return; }
        document.getElementById('bankDetailName').textContent   = opt.getAttribute('data-name');
        document.getElementById('bankDetailOwner').textContent  = 'a.n. ' + opt.getAttribute('data-owner');
        document.getElementById('bankDetailNumber').textContent = opt.getAttribute('data-number');
        detail.style.display = 'block';
    }
</script>

</body>
</html>
