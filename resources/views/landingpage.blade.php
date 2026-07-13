<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brilliant English Course</title>

    <link rel="stylesheet" href="{{ asset('css/landingpagenew.css') }}?v={{ filemtime(public_path('css/landingpagenew.css')) }}">
    <script src="{{ asset('js/gallery.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <link rel="icon" href="{{ asset('asset/img/logo25.jpeg') }}" type="image/png">

</head>

<body>

    @include('navbar.navbar')

    @if ($pengaturanTiket->gambar_poster)
        <div id="pamflet-popup" class="pamflet-popup" style="display:none;">
            <div class="pamflet-content position-relative">
                <button id="closePamflet" class="btn-close-custom" aria-label="Close">&times;</button>
                <img src="{{ asset('storage/' . $pengaturanTiket->gambar_poster) }}" alt="Poster Konser"
                    class="img-fluid rounded shadow mb-2">
            </div>
        </div>
    @elseif ($programsgambar)
        <div id="pamflet-popup" class="pamflet-popup" style="display:none;">
            <div class="pamflet-content position-relative">
                <button id="closePamflet" class="btn-close-custom" aria-label="Close">&times;</button>
                <img src="{{ asset('uploads/programs/' . $programsgambar->gambar) }}" alt="{{ $programsgambar->judul }}"
                    class="img-fluid rounded shadow mb-2">
            </div>
        </div>
    @endif

    <style>
        .pamflet-popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 15px;
            /* biar ada jarak di pinggir hp kecil */
        }

        .pamflet-content {
            /* background: #fff; */
            padding: 12px;
            /* agak tipis biar nggak jauh dari poster */
            border-radius: 12px;
            text-align: center;
            width: 450px;
            /* lebih kecil dari 595px */
            height: 620px;
            /* lebih kecil dari 842px */
            max-width: 100%;
            max-height: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        .pamflet-content img {
            max-width: 100%;
            max-height: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
        }

        .btn-close-custom {
            position: absolute;
            top: 5px;
            right: 19px;
            background: none;
            border: none;
            font-size: 38px;
            font-weight: bold;
            color: #444;
            cursor: pointer;
            line-height: 1;
        }

        .btn-close-custom:hover {
            color: red;
        }

        /* === POPUP TIKET KONSER === */
        .tiket-popup-backdrop {
            background: rgba(0, 0, 0, 0.78);
            backdrop-filter: blur(5px);
        }
        .tiket-popup-box {
            max-width: 640px !important;
            padding: 2rem !important;
            max-height: 92vh;
            overflow-y: auto;
        }
        .tiket-popup-head-wrap {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.12);
        }
        .tiket-popup-head-wrap h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 0.25rem 0;
        }
        .tiket-popup-head-wrap p {
            color: rgba(255,255,255,0.55);
            font-size: 0.82rem;
            margin: 0;
        }
        .tiket-kategori-grid {
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }
        .tiket-kategori-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 1.1rem;
            border-radius: 14px;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .tiket-kategori-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.4);
        }
        .tiket-kat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .tiket-kat-info { flex: 1; min-width: 0; }
        .tiket-kat-info h4 {
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
            margin: 0 0 0.3rem 0;
            line-height: 1.35;
        }
        .tiket-kat-harga {
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0.18rem 0.65rem;
            border-radius: 20px;
            display: inline-block;
        }
        .tiket-kat-arrow {
            color: rgba(255,255,255,0.35);
            font-size: 0.85rem;
            flex-shrink: 0;
            transition: color 0.2s, transform 0.2s;
        }
        .tiket-kategori-card:hover .tiket-kat-arrow {
            color: rgba(255,255,255,0.9);
            transform: translateX(3px);
        }
        /* Umum */
        .tiket-umum-card  { background: linear-gradient(135deg, rgba(255,161,9,0.18) 0%, rgba(255,161,9,0.04) 100%); }
        .tiket-umum-card  .tiket-kat-icon  { background: rgba(255,161,9,0.2);  color: #FFC107; }
        .tiket-umum-card  .tiket-kat-harga { background: rgba(255,161,9,0.2);  color: #FFC107; }
        /* VIP */
        .tiket-vip-card   { background: linear-gradient(135deg, rgba(220,53,69,0.22) 0%, rgba(220,53,69,0.04) 100%); }
        .tiket-vip-card   .tiket-kat-icon  { background: rgba(220,53,69,0.2);  color: #ff7b87; }
        .tiket-vip-card   .tiket-kat-harga { background: rgba(220,53,69,0.2);  color: #ff7b87; }
        /* Member */
        .tiket-member-card { background: linear-gradient(135deg, rgba(40,167,69,0.22) 0%, rgba(40,167,69,0.04) 100%); }
        .tiket-member-card .tiket-kat-icon  { background: rgba(40,167,69,0.2); color: #5dd879; }
        .tiket-member-card .tiket-kat-harga { background: rgba(40,167,69,0.2); color: #5dd879; }
        /* Spesial */
        .tiket-spesial-card { background: linear-gradient(135deg, rgba(0,123,255,0.22) 0%, rgba(0,64,133,0.04) 100%); }
        .tiket-spesial-card .tiket-kat-icon  { background: rgba(0,123,255,0.2); color: #74b9ff; }
        .tiket-gratis-badge { background: linear-gradient(135deg, #28a745, #20c997) !important; color: #fff !important; }
        @media (max-width: 480px) {
            .tiket-popup-box { padding: 1.1rem !important; }
            .tiket-popup-head-wrap h2 { font-size: 1.2rem; }
            .tiket-kat-info h4 { font-size: 0.82rem; }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pamfletPopup = document.getElementById("pamflet-popup");
            const closePamfletBtn = document.getElementById("closePamflet");
            if (!pamfletPopup || !closePamfletBtn) return;

            if (!sessionStorage.getItem("pamfletShown")) {
                pamfletPopup.style.display = "flex";
            }

            closePamfletBtn.addEventListener("click", function() {
                pamfletPopup.style.display = "none";
                sessionStorage.setItem("pamfletShown", "true");
            });
        });
    </script>


    <section class="carousel" id="carousel">
        <div class="carousel-container">
            <div class="slides">
                <img src="{{ asset('asset/img/BIE01.JPG') }}" class="slide" alt="Slide 1">
            </div>
            <div class="carousel-overlay"></div>

            <div class="carousel-text">
                <h1 data-aos="fade-left" data-aos-delay="200" style="color: #FFA109FF;">
                    BRILLIANT <span style="color: #C99C4FFF;">ENGLISH COURSE</span>
                </h1>
                <p data-aos="fade-right" data-aos-delay="200" style="color: #ECECEBFF;">
                    Tingkatkan kemampuan Bahasa Inggris Anda secara efektif dengan metode pembelajaran inovatif dan
                    lingkungan belajar yang mendukung di Brilliant English Course. Nikmati fasilitas asrama nyaman dan
                    program terstruktur yang dirancang khusus untuk membantu Anda meraih prestasi maksimal. Bergabunglah
                    sekarang dan wujudkan potensi terbaik Anda bersama kami!
                </p>

                <a href="https://www.celestix.id/event/brilliant-kampung-inggris-pare-hari-ini/501" target="_blank" rel="noopener noreferrer" class="cta-button" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-ticket-alt" style="margin-right:8px;"></i>BELI TIKET KONSER
                </a>
            </div>
        </div>

        <!-- Popup Tiket Konser: Pilih Kategori -->
<div id="tiketPopup" class="popup1-overlay tiket-popup-backdrop">
    <div class="popup1-content tiket-popup-box">

        <div class="tiket-popup-head-wrap">
            <div>
                <h2><i class="fas fa-music" style="color:#FFA109;margin-right:8px;"></i>Pilih Kategori Tiket</h2>
                <p>Konser Brilliant English Course 2026</p>
            </div>
            <button id="closeTiketPopupBtn" class="close1-button" style="margin-top:-4px;">&times;</button>
        </div>

        <div class="tiket-kategori-grid">

            {{-- Umum --}}
            <a href="{{ route('tiket-konser.create', ['kategori' => 'umum']) }}" class="tiket-kategori-card tiket-umum-card">
                <div class="tiket-kat-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="tiket-kat-info">
                    <h4>{{ $pengaturanTiket->nama_kategori_umum }}</h4>
                    <span class="tiket-kat-harga">Rp {{ number_format($pengaturanTiket->harga_umum, 0, ',', '.') }}</span>
                </div>
                <i class="fas fa-chevron-right tiket-kat-arrow"></i>
            </a>

            {{-- VIP --}}
            <a href="{{ route('tiket-konser.create', ['kategori' => 'vip']) }}" class="tiket-kategori-card tiket-vip-card">
                <div class="tiket-kat-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="tiket-kat-info">
                    <h4>{{ $pengaturanTiket->nama_kategori_vip }}</h4>
                    <span class="tiket-kat-harga">Rp {{ number_format($pengaturanTiket->harga_vip, 0, ',', '.') }}</span>
                </div>
                <i class="fas fa-chevron-right tiket-kat-arrow"></i>
            </a>

            {{-- Member --}}
            <a href="{{ route('tiket-konser.create', ['kategori' => 'member']) }}" class="tiket-kategori-card tiket-member-card">
                <div class="tiket-kat-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="tiket-kat-info">
                    <h4>Member Aktif Brilliant English Course &amp; BIE Plus</h4>
                    <span class="tiket-kat-harga">Rp {{ number_format($pengaturanTiket->harga_member, 0, ',', '.') }}</span>
                </div>
                <i class="fas fa-chevron-right tiket-kat-arrow"></i>
            </a>

            {{-- Spesial --}}
            <a href="{{ route('tiket-konser.create', ['kategori' => 'spesial']) }}" class="tiket-kategori-card tiket-spesial-card">
                <div class="tiket-kat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="tiket-kat-info">
                    <h4>Spesial Member Brilliant English Course &amp; BIE Plus</h4>
                    <span class="tiket-kat-harga tiket-gratis-badge">GRATIS 🎉</span>
                </div>
                <i class="fas fa-chevron-right tiket-kat-arrow"></i>
            </a>

        </div>
    </div>
</div>

    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const openPopupButton = document.getElementById('openPopupBtn');
            const tiketPopup = document.getElementById('tiketPopup');
            const closeTiketPopupBtn = document.getElementById('closeTiketPopupBtn');

            if (!openPopupButton || !tiketPopup) return;

            function showPopup(popup) { popup.classList.add('show'); }
            function hidePopup(popup) { popup.classList.remove('show'); }

            openPopupButton.addEventListener('click', function (e) {
                e.preventDefault();
                showPopup(tiketPopup);
            });

            if (closeTiketPopupBtn) {
                closeTiketPopupBtn.addEventListener('click', function () {
                    hidePopup(tiketPopup);
                });
            }

            tiketPopup.addEventListener('click', function (event) {
                if (event.target === tiketPopup) hidePopup(tiketPopup);
            });
        });
    </script>


    {{-- ====================================================================
         SECTION INFO KONSER — tepat di bawah Hero, sebelum Tentang Kami
         ==================================================================== --}}
    <section class="konser-section" id="info-konser">
        <div class="container">

            {{-- Section Header --}}
            <div class="konser-section-header" data-aos="fade-up">
                <span class="konser-label"><i class="fas fa-music"></i> LIVE EVENT</span>
                <h2 class="konser-section-title">KONSER BRILLIANT 2026</h2>
                @if ($pengaturanTiket->deskripsi_section_konser)
                    <p class="konser-section-desc">{{ $pengaturanTiket->deskripsi_section_konser }}</p>
                @endif
            </div>

            {{-- ===== BARIS 1: Gambar Konser (Carousel) + Info Artis + Countdown ===== --}}
            <div class="konser-hero-grid">

                {{-- Gambar Konser Carousel --}}
                @if ($pengaturanTiket->gambarKonser && $pengaturanTiket->gambarKonser->count() > 0)
                <div class="konser-carousel-wrapper" data-aos="fade-right" data-aos-delay="200">
                    <div class="konser-carousel" id="konserCarousel">
                        <div class="konser-carousel-track" id="konserTrack">
                            @foreach ($pengaturanTiket->gambarKonser as $gk)
                                <div class="konser-slide">
                                    <img src="{{ asset('storage/' . $gk->image_path) }}"
                                         alt="{{ $gk->caption ?? 'Konser Brilliant' }}">
                                    @if ($gk->caption)
                                        <div class="konser-slide-caption">{{ $gk->caption }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if ($pengaturanTiket->gambarKonser->count() > 1)
                            <button class="konser-nav-btn konser-prev" id="konserPrev">&#8592;</button>
                            <button class="konser-nav-btn konser-next" id="konserNext">&#8594;</button>
                            <div class="konser-dots" id="konserDots">
                                @foreach ($pengaturanTiket->gambarKonser as $idx => $gk)
                                    <span class="konser-dot {{ $idx === 0 ? 'active' : '' }}" data-index="{{ $idx }}"></span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Info Artis + Countdown --}}
                <div class="konser-info-panel" data-aos="fade-left" data-aos-delay="300">

                    {{-- Artis Card --}}
                    @if ($pengaturanTiket->nama_artis)
                    <div class="artis-card">
                        <div class="artis-card-header">
                            <i class="fas fa-microphone-alt"></i>
                            <span>ARTIST / LINEUP</span>
                        </div>
                        <div class="artis-card-body">
                            @if ($pengaturanTiket->gambar_artis)
                                <div class="artis-img-wrap">
                                    <img src="{{ asset('storage/' . $pengaturanTiket->gambar_artis) }}"
                                         alt="{{ $pengaturanTiket->nama_artis }}">
                                </div>
                            @endif
                            <div class="artis-text">
                                <h3 class="artis-name">{{ $pengaturanTiket->nama_artis }}</h3>
                                @if ($pengaturanTiket->deskripsi_artis)
                                    <p class="artis-desc">{{ $pengaturanTiket->deskripsi_artis }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Event Details --}}
                    <div class="event-details-card">
                        @if ($pengaturanTiket->tanggal_event)
                        <div class="event-detail-row">
                            <div class="event-detail-icon"><i class="far fa-calendar-alt"></i></div>
                            <div>
                                <span class="event-detail-label">Tanggal</span>
                                <span class="event-detail-value">{{ $pengaturanTiket->tanggal_event->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                        @endif
                        @if ($pengaturanTiket->lokasi_event)
                        <div class="event-detail-row">
                            <div class="event-detail-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <span class="event-detail-label">Lokasi</span>
                                <span class="event-detail-value">{{ $pengaturanTiket->lokasi_event }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Countdown Timer --}}
                    @if ($pengaturanTiket->tanggal_event && $pengaturanTiket->tanggal_event->isFuture())
                    <div class="countdown-card">
                        <div class="countdown-label"><i class="fas fa-hourglass-half"></i> HITUNG MUNDUR</div>
                        <div class="countdown-grid" id="konserCountdown"
                             data-target="{{ $pengaturanTiket->tanggal_event->format('Y-m-d') }}T00:00:00">
                            <div class="countdown-item">
                                <span class="countdown-num" id="cdDays">--</span>
                                <span class="countdown-unit">Hari</span>
                            </div>
                            <div class="countdown-sep">:</div>
                            <div class="countdown-item">
                                <span class="countdown-num" id="cdHours">--</span>
                                <span class="countdown-unit">Jam</span>
                            </div>
                            <div class="countdown-sep">:</div>
                            <div class="countdown-item">
                                <span class="countdown-num" id="cdMins">--</span>
                                <span class="countdown-unit">Menit</span>
                            </div>
                            <div class="countdown-sep">:</div>
                            <div class="countdown-item">
                                <span class="countdown-num" id="cdSecs">--</span>
                                <span class="countdown-unit">Detik</span>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- ===== BARIS 2: Kategori Tiket ===== --}}
            <div class="konser-tiket-section" data-aos="fade-up" data-aos-delay="200">
                <h3 class="konser-sub-title"><i class="fas fa-ticket-alt"></i> KATEGORI TIKET</h3>
                <div class="konser-tiket-grid">

                    {{-- Umum --}}
                    <div class="konser-tiket-card kt-umum">
                        <div class="kt-accent"></div>
                        <div class="kt-header">
                            <div class="kt-icon"><i class="fas fa-ticket-alt"></i></div>
                            <h4>{{ $pengaturanTiket->nama_kategori_umum }}</h4>
                        </div>
                        <div class="kt-price">Rp {{ number_format($pengaturanTiket->harga_umum, 0, ',', '.') }}</div>
                        @if ($pengaturanTiket->deskripsi_umum)
                            <ul class="kt-benefits">
                                @foreach (explode("\n", $pengaturanTiket->deskripsi_umum) as $benefit)
                                    @if (trim($benefit))
                                        <li><i class="fas fa-check"></i> {{ trim($benefit) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                        @if (($pengaturanTiket->status_umum ?? 'tersedia') == 'tersedia')
                            <div class="kt-btn kt-btn-umum" style="cursor:default; pointer-events:none;">Tersedia</div>
                        @elseif (($pengaturanTiket->status_umum ?? 'tersedia') == 'sold_out')
                            <div class="kt-btn kt-btn-umum" style="cursor:default; pointer-events:none; opacity:0.6;">Sold Out</div>
                        @else
                            <div class="kt-btn kt-btn-umum" style="cursor:default; pointer-events:none; opacity:0.6;">Coming Soon</div>
                        @endif
                    </div>

                    {{-- VIP --}}
                    <div class="konser-tiket-card kt-vip">
                        <div class="kt-accent"></div>
                        <div class="kt-badge">POPULER</div>
                        <div class="kt-header">
                            <div class="kt-icon"><i class="fas fa-crown"></i></div>
                            <h4>{{ $pengaturanTiket->nama_kategori_vip }}</h4>
                        </div>
                        <div class="kt-price">Rp {{ number_format($pengaturanTiket->harga_vip, 0, ',', '.') }}</div>
                        @if ($pengaturanTiket->deskripsi_vip)
                            <ul class="kt-benefits">
                                @foreach (explode("\n", $pengaturanTiket->deskripsi_vip) as $benefit)
                                    @if (trim($benefit))
                                        <li><i class="fas fa-check"></i> {{ trim($benefit) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                        @if (($pengaturanTiket->status_vip ?? 'tersedia') == 'tersedia')
                            <div class="kt-btn kt-btn-vip" style="cursor:default; pointer-events:none;">Tersedia</div>
                        @elseif (($pengaturanTiket->status_vip ?? 'tersedia') == 'sold_out')
                            <div class="kt-btn kt-btn-vip" style="cursor:default; pointer-events:none; opacity:0.6;">Sold Out</div>
                        @else
                            <div class="kt-btn kt-btn-vip" style="cursor:default; pointer-events:none; opacity:0.6;">Coming Soon</div>
                        @endif
                    </div>

                    {{-- Member --}}
                    <div class="konser-tiket-card kt-member">
                        <div class="kt-accent"></div>
                        <div class="kt-header">
                            <div class="kt-icon"><i class="fas fa-id-card"></i></div>
                            <h4>{{ $pengaturanTiket->nama_kategori_member ?? 'Tiket - WARGA PARE' }}</h4>
                        </div>
                        <div class="kt-price">Rp {{ number_format($pengaturanTiket->harga_member, 0, ',', '.') }}</div>
                        @if ($pengaturanTiket->deskripsi_member)
                            <ul class="kt-benefits">
                                @foreach (explode("\n", $pengaturanTiket->deskripsi_member) as $benefit)
                                    @if (trim($benefit))
                                        <li><i class="fas fa-check"></i> {{ trim($benefit) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                        @if (($pengaturanTiket->status_member ?? 'tersedia') == 'tersedia')
                            <div class="kt-btn kt-btn-member" style="cursor:default; pointer-events:none;">Tersedia</div>
                        @elseif (($pengaturanTiket->status_member ?? 'tersedia') == 'sold_out')
                            <div class="kt-btn kt-btn-member" style="cursor:default; pointer-events:none; opacity:0.6;">Sold Out</div>
                        @else
                            <div class="kt-btn kt-btn-member" style="cursor:default; pointer-events:none; opacity:0.6;">Coming Soon</div>
                        @endif
                    </div>

                    {{-- Spesial --}}
                    <div class="konser-tiket-card kt-spesial">
                        <div class="kt-accent"></div>
                        <div class="kt-header">
                            <div class="kt-icon"><i class="fas fa-star"></i></div>
                            <h4>{{ $pengaturanTiket->nama_kategori_spesial }}</h4>
                        </div>
                        <div class="kt-price">Rp {{ number_format($pengaturanTiket->harga_spesial, 0, ',', '.') }}</div>
                        @if ($pengaturanTiket->deskripsi_spesial)
                            <ul class="kt-benefits">
                                @foreach (explode("\n", $pengaturanTiket->deskripsi_spesial) as $benefit)
                                    @if (trim($benefit))
                                        <li><i class="fas fa-check"></i> {{ trim($benefit) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif
                        @if (($pengaturanTiket->status_spesial ?? 'tersedia') == 'tersedia')
                            <div class="kt-btn kt-btn-spesial" style="cursor:default; pointer-events:none;">Tersedia</div>
                        @elseif (($pengaturanTiket->status_spesial ?? 'tersedia') == 'sold_out')
                            <div class="kt-btn kt-btn-spesial" style="cursor:default; pointer-events:none; opacity:0.6;">Sold Out</div>
                        @else
                            <div class="kt-btn kt-btn-spesial" style="cursor:default; pointer-events:none; opacity:0.6;">Coming Soon</div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- ===== BARIS 3: Fasilitas Venue ===== --}}
            @if ($pengaturanTiket->fasilitas_venue)
            <div class="konser-fasilitas-section" data-aos="fade-up" data-aos-delay="300">
                <h3 class="konser-sub-title"><i class="fas fa-concierge-bell"></i> FASILITAS VENUE</h3>
                <div class="fasilitas-grid">
                    @php
                        $fasilitasIcons = [
                            'parkir'         => 'fas fa-parking',
                            'toilet'         => 'fas fa-restroom',
                            'food'           => 'fas fa-utensils',
                            'mushola'        => 'fas fa-mosque',
                            'p3k'            => 'fas fa-first-aid',
                            'sound'          => 'fas fa-volume-up',
                            'lighting'       => 'fas fa-lightbulb',
                            'security'       => 'fas fa-shield-alt',
                            'wifi'           => 'fas fa-wifi',
                            'atm'            => 'fas fa-credit-card',
                            'smoking'        => 'fas fa-smoking',
                            'charging'       => 'fas fa-charging-station',
                            'merchandise'    => 'fas fa-tshirt',
                            'photo'          => 'fas fa-camera',
                        ];
                        $defaultIcon = 'fas fa-check-circle';
                    @endphp
                    @foreach (explode("\n", $pengaturanTiket->fasilitas_venue) as $fasilitas)
                        @if (trim($fasilitas))
                            @php
                                $fasLower = strtolower(trim($fasilitas));
                                $matchedIcon = $defaultIcon;
                                foreach ($fasilitasIcons as $keyword => $icon) {
                                    if (str_contains($fasLower, $keyword)) {
                                        $matchedIcon = $icon;
                                        break;
                                    }
                                }
                            @endphp
                            <div class="fasilitas-item">
                                <div class="fasilitas-icon"><i class="{{ $matchedIcon }}"></i></div>
                                <span>{{ trim($fasilitas) }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </section>

    {{-- ===== Konser Carousel + Countdown JavaScript ===== --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== KONSER IMAGE CAROUSEL =====
        (function() {
            const track = document.getElementById('konserTrack');
            const prevBtn = document.getElementById('konserPrev');
            const nextBtn = document.getElementById('konserNext');
            const dotsContainer = document.getElementById('konserDots');
            if (!track) return;

            const slides = track.querySelectorAll('.konser-slide');
            const total = slides.length;
            if (total <= 1) return;

            let current = 0;
            let autoTimer;

            function goTo(idx) {
                current = ((idx % total) + total) % total;
                track.style.transform = 'translateX(-' + (current * 100) + '%)';
                // Update dots
                if (dotsContainer) {
                    dotsContainer.querySelectorAll('.konser-dot').forEach(function(d, i) {
                        d.classList.toggle('active', i === current);
                    });
                }
            }

            if (prevBtn) prevBtn.addEventListener('click', function() { goTo(current - 1); resetAuto(); });
            if (nextBtn) nextBtn.addEventListener('click', function() { goTo(current + 1); resetAuto(); });
            if (dotsContainer) {
                dotsContainer.querySelectorAll('.konser-dot').forEach(function(dot) {
                    dot.addEventListener('click', function() {
                        goTo(parseInt(this.dataset.index));
                        resetAuto();
                    });
                });
            }

            function startAuto() { autoTimer = setInterval(function() { goTo(current + 1); }, 4000); }
            function resetAuto() { clearInterval(autoTimer); startAuto(); }

            track.parentElement.addEventListener('mouseenter', function() { clearInterval(autoTimer); });
            track.parentElement.addEventListener('mouseleave', startAuto);

            startAuto();
        })();

        // ===== COUNTDOWN TIMER =====
        (function() {
            var container = document.getElementById('konserCountdown');
            if (!container) return;

            var target = new Date(container.dataset.target).getTime();

            function update() {
                var now = new Date().getTime();
                var diff = target - now;

                if (diff <= 0) {
                    document.getElementById('cdDays').textContent = '0';
                    document.getElementById('cdHours').textContent = '0';
                    document.getElementById('cdMins').textContent = '0';
                    document.getElementById('cdSecs').textContent = '0';
                    return;
                }

                var days  = Math.floor(diff / (1000 * 60 * 60 * 24));
                var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var mins  = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                var secs  = Math.floor((diff % (1000 * 60)) / 1000);

                document.getElementById('cdDays').textContent  = String(days).padStart(2, '0');
                document.getElementById('cdHours').textContent = String(hours).padStart(2, '0');
                document.getElementById('cdMins').textContent  = String(mins).padStart(2, '0');
                document.getElementById('cdSecs').textContent  = String(secs).padStart(2, '0');
            }

            update();
            setInterval(update, 1000);
        })();
    });
    </script>


    {{-- ✅ Section "Tentang Kami" dengan animasi --}}
    <section class="about-us-section" id="tentang" data-aos="fade-up">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <h2 class="about-section-title" data-aos="fade-up">TENTANG KAMI</h2>

            <div class="about-grid">
                <div class="about-intro" data-aos="fade-left" data-aos-delay="200">
                    <h2>Brilliant International Education PLUS</h2>
                    <p>
                        Berlokasi di jantung Kampung Inggris Pare, Brilliant International Education PLUS menyediakan
                        pengalaman belajar yang berkualitas di
                        Brilliant International Education PLUS serta nikmati tempat tinggal atau CAMP dengan kenyamanan,
                        fasilitas lengkap, dan lokasi
                        strategis untuk mendukung pengalaman belajar terbaik Anda di Kampung Inggris Pare. Nikmati
                        tempat di mana potensi Anda menjadi lebih gemilang!
                    </p>
                </div>

                <div class="features-grid" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon"><i class="fas fa-comments"></i></div>
                        <h3>Lingkungan Imersif 24/7</h3>
                        <p>Dengan sistem asrama (camp) berbasis "English Area", Anda akan terbiasa berpikir dan
                            berbicara dalam bahasa Inggris setiap hari. Metode ini terbukti mempercepat kelancaran Anda
                            secara signifikan.</p>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="500">
                        <div class="icon"><i class="fas fa-lightbulb"></i></div>
                        <h3>Metode Belajar Praktis</h3>
                        <p>Kami fokus pada 80% praktik dan 20% teori. Kelas interaktif, simulasi dunia nyata, dan materi
                            yang relevan membuat proses belajar menjadi efektif, anti-bosan, dan menyenangkan.</p>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="600">
                        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <h3>Tutor Profesional & Suportif</h3>
                        <p>Tutor kami bukan hanya pengajar, tapi juga mentor yang ramah dan berpengalaman. Mereka siap
                            membimbing Anda langkah demi langkah untuk mencapai target belajar Anda.</p>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="700">
                        <div class="icon"><i class="fas fa-book-open-reader"></i></div>
                        <h3>Program Terstruktur & Komunitas</h3>
                        <p>Pilih program yang sesuai tujuan Anda, mulai dari Speaking, TOEFL, hingga IELTS. Bergabunglah
                            dengan komunitas pembelajar yang solid dan saling mendukung untuk sukses bersama.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="registration-flow-section" id="alur-pendaftaran">
        <div class="container">
            <section class="registration-flow-section" id="alur-pendaftaran">
                <div class="container">
                    <h2 class="registration-section-title">ALUR PENDAFTARAN</h2>
                    <p class="registration-section-subtitle">Langkah-langkah mudah untuk bergabung dengan Brilliant
                        English Course</p>

                    <div class="flow-steps">
                        <div class="flow-step" data-aos="fade-up" data-aos-delay="100">
                            <div class="step-number">1</div>
                            <div class="step-content">
                                <h3>Pilih Program</h3>
                                <p>Pilih program yang sesuai dengan tujuan kamu agar mendapatkan hasil yang maksimal.
                                    Ingat! Kamu gak bakal bisa tiba-tiba jago ngomong Inggris dalam satu malam. Kami
                                    bukan dukun.</p>
                            </div>
                        </div>

                        <div class="flow-step" data-aos="fade-up" data-aos-delay="200">
                            <div class="step-number">2</div>
                            <div class="step-content">
                                <h3>Isi Formulir</h3>
                                <p>Isi beberapa formulir yang diperlukan dengan benar untuk melakukan pendaftaran pada
                                    program yang telah dipilih sebelumnya.</p>
                            </div>
                        </div>

                        <div class="flow-step" data-aos="fade-up" data-aos-delay="300">
                            <div class="step-number">3</div>
                            <div class="step-content">
                                <h3>Lakukan Pembayaran</h3>
                                <p>Lakukan pembayaran beserta bukti pembayaran setelah melakukan pengisian formulir.
                                    Harga pembayaran berbeda-beda tergantung dari program mana yang dipilih.</p>
                            </div>
                        </div>

                        <div class="flow-step" data-aos="fade-up" data-aos-delay="400">
                            <div class="step-number">4</div>
                            <div class="step-content">
                                <h3>Validasi Pembayaran</h3>
                                <p>Setelah melakukan pembayaran, tunggu beberapa jam hingga pihak dari kampung inggris
                                    pusat menyelesaikan validasi pembayaran yang telah dilakukan sebelumnya.</p>
                            </div>
                        </div>

                        <div class="flow-step" data-aos="fade-up" data-aos-delay="500">
                            <div class="step-number">5</div>
                            <div class="step-content">
                                <h3>Tunggu Pemberitahuan</h3>
                                <p>Setelah validasi pembayaran selesai dilakukan oleh pihak kampung inggris pusat, kami
                                    akan mengirimkan pemberitahuan terhadap Anda melalui media sosial WhatsApp.</p>
                            </div>
                        </div>

                        <div class="flow-step" data-aos="fade-up" data-aos-delay="600">
                            <div class="step-number">6</div>
                            <div class="step-content">
                                <h3>Datang ke Brilliant English Course</h3>
                                <p>Berangkat menuju Brilliant English Course sesuai periode yang telah dipilih
                                    sebelumnya.</p>
                            </div>
                        </div>

                        <div class="flow-step" data-aos="fade-up" data-aos-delay="700">
                            <div class="step-number">7</div>
                            <div class="step-content">
                                <h3>Ikuti Aturan</h3>
                                <p>Ikuti Aturan yang berlaku dan pulang dengan hasil yang memuaskan dengan mendapatkan
                                    akses ke materi pembelajaran.</p>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </section>


    <div class="container">
        @foreach ($programs->where('status', 'aktif') as $index => $program)
            {{-- Container utama diberi animasi 'fade-up' --}}
            <div class="program-detail @if ($index % 2 == 0) layout-left @else layout-right @endif"
                data-aos="fade-up">

                <div class="program-content-container">

                    {{-- Kartu teks diberi animasi berdasarkan posisi genap/ganjil --}}
                    <div class="card-info" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}"
                        data-aos-delay="200">
                        <div class="content-text content-structured">
                            <h3
                                style="font-weight: bold; text-align: center; font-family: 'Poppins', 'Times New Roman', serif;">
                                {{ $program->judul }}
                            </h3>
                            <p class="description" style="text-align: justify;">
                                {!! nl2br(e($program->deskripsi)) !!}
                            </p>
                            <div class="benefits-container">
                                <p class="benefits-title"><strong>Keunggulan Program:</strong></p>
                                <div class="benefits-grid">
                                    @php
                                        $benefits = explode("\n", $program->keunggulan);
                                    @endphp
                                    @foreach ($benefits as $item)
                                        @if (trim($item) != '')
                                            <div class="benefit-item">
                                                <i class="fas fa-check-circle"></i> {{ trim($item) }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Gambar diberi animasi berdasarkan posisi genap/ganjil --}}
                    <div class="content-image card-image"
                        data-aos="{{ $index % 2 == 0 ? 'fade-left' : 'fade-right' }}" data-aos-delay="200">
                        <img src="{{ asset('uploads/programs/' . $program->gambar) }}" alt="{{ $program->judul }}"
                            onclick="openLightbox(this)">
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    {{--
    <div class="wave-divider4">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill4"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div> --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const filterButtons = document.querySelectorAll('.filter-btn');
            const programItems = document.querySelectorAll('.program-item');
            const noProgramMessage = document.getElementById('no-program-message');

            function filterItems(filterValue) {
                let visibleCount = 0;
                programItems.forEach(item => {
                    if (item.dataset.filter === filterValue) {
                        item.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                if (visibleCount === 0) {
                    noProgramMessage.style.display = 'block';
                } else {
                    noProgramMessage.style.display = 'none';
                }
            }

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {

                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const filterValue = this.dataset.filter;
                    filterItems(filterValue);
                });
            });

            const initialActiveButton = document.querySelector('.filter-btn.active');
            if (initialActiveButton) {
                filterItems(initialActiveButton.dataset.filter);
            } else {
                // Jika tidak ada yang aktif, tampilkan yang pertama secara default
                if (filterButtons.length > 0) {
                    filterButtons[0].classList.add('active');
                    filterItems(filterButtons[0].dataset.filter);
                }
            }
        });
    </script>



    <link rel="stylesheet" href="{{ asset('css/program.css') }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.program-tabs .tab-button');
            const contents = document.querySelectorAll('.program-detail');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const targetId = tab.dataset.tab;

                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    contents.forEach(content => content.classList.remove('active'));
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                });
            });
        });
    </script>
    {{-- <div class="wave-divider7">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill7"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div> --}}

        <section id="galeri" class="gallery">
            <div class="container" data-aos="fade-up">
                <h2 class="section-title">GALERI</h2>
                <p class="section-subtitle text-center mb-4" style="color: #ffffff;">
                    Dokumentasi kegiatan dan momen-momen seru bersama Brilliant International Education PLUS Dan Brilliant English Course.
                </p>

                <div class="gallery-carousel-outer" id="bie-carousel">
                        <button class="carousel-nav-btn carousel-prev" id="bie-prev">&#8592;</button>
                        <div class="gallery-carousel-wrap" id="bie-wrap">
                            <div class="gallery-carousel-track" id="bie-track">
                        @php $index = 0; @endphp
                        @foreach ($galleries as $gallery)
                            @if ($gallery->images->isNotEmpty())
                                @php
                                    $firstMedia = $gallery->images->first();
                                    $thumbSrc = null;
                                    $isVideoThumb = false;
                                    if ($firstMedia->type === 'video') {
                                        if ($firstMedia->thumbnail_path) {
                                            $thumbSrc = asset('storage/' . $firstMedia->thumbnail_path);
                                        } elseif ($firstMedia->video_url) {
                                            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $firstMedia->video_url ?? '', $ytMatch);
                                            $thumbSrc = isset($ytMatch[1]) ? 'https://img.youtube.com/vi/' . $ytMatch[1] . '/mqdefault.jpg' : null;
                                        }
                                        $isVideoThumb = true;
                                    } else {
                                        $thumbSrc = asset('storage/' . $firstMedia->image_path);
                                    }
                                @endphp
                                <div class="gallery-frame" data-index="{{ $index }}"
                                    onclick="openGalleryModal({{ $gallery->id }})">
                                    @if ($thumbSrc)
                                        <img src="{{ $thumbSrc }}" alt="{{ $gallery->title }}" class="gallery-thumbnail">
                                    @elseif ($isVideoThumb)
                                        <div class="gallery-thumbnail d-flex align-items-center justify-content-center" style="background:#1e1e2e; height:240px;">
                                            <i class="fas fa-film" style="font-size:40px; color:#ccc;"></i>
                                        </div>
                                    @endif
                                    <div class="gallery-hover-btn">
                                        @if ($isVideoThumb)<i class="fas fa-play"></i>@else<i class="fas fa-expand-alt"></i>@endif
                                    </div>
                                    <div class="gallery-overlay">
                                        <h5>{{ $gallery->title }}</h5>
                                        <p>{{ Str::limit($gallery->deskripsi ?? '', 60) }}</p>
                                    </div>
                                    @if ($gallery->images->count() > 1)
                                        <span class="gallery-count-badge">
                                            <i class="fas fa-images"></i> {{ $gallery->images->count() }}
                                        </span>
                                    @endif
                                </div>
                                @php $index++; @endphp
                            @endif
                        @endforeach
                            </div>{{-- end .gallery-carousel-track --}}
                        </div>{{-- end .gallery-carousel-wrap --}}
                        <button class="carousel-nav-btn carousel-next" id="bie-next">&#8594;</button>
                    </div>{{-- end .gallery-carousel-outer --}}
            </div>
        </section>

                    {{-- Modals --}}
                    @foreach ($galleries as $gallery)
                        @if ($gallery->images->isNotEmpty())
                            <div id="modal-{{ $gallery->id }}" class="gallery-modal"
                                 onclick="closeModalOnBackdrop(event, {{ $gallery->id }})">
                                <div class="modal-content">

                                    {{-- Header bar --}}
                                    <div class="modal-head-bar">
                                        <div class="modal-head-left">
                                            <i class="fas fa-images" style="color:#FFA109;font-size:.82rem;flex-shrink:0;"></i>
                                            <h3>{{ $gallery->title }}</h3>
                                        </div>
                                        <div class="modal-head-right">
                                            @if ($gallery->images->count() > 1)
                                                <span class="modal-slide-counter" id="counter-{{ $gallery->id }}">
                                                    1 / {{ $gallery->images->count() }}
                                                </span>
                                            @endif
                                            <button class="modal-close-btn"
                                                    onclick="closeGalleryModal({{ $gallery->id }})"
                                                    title="Tutup">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Slider body --}}
                                    <div class="modal-body-area">
                                        <div class="modal-slider-wrapper">
                                            @if ($gallery->images->count() > 1)
                                                <button class="nav-btn left"
                                                        onclick="slideGallery({{ $gallery->id }}, -1)">&#8592;</button>
                                            @endif

                                            <div class="modal-slider" id="slider-{{ $gallery->id }}">
                                                <div class="slide-track">
                                                    @foreach ($gallery->images as $image)
                                                        <div class="slide-item">
                                                            @if ($image->isYoutubeVideo() && $image->getYoutubeEmbedUrl())
                                                                <iframe
                                                                    src="{{ $image->getYoutubeEmbedUrl() }}"
                                                                    frameborder="0"
                                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                    allowfullscreen>
                                                                </iframe>
                                                            @elseif ($image->isLocalVideo())
                                                                <video controls>
                                                                    <source src="{{ asset('storage/' . $image->image_path) }}">
                                                                    Browser Anda tidak mendukung pemutaran video.
                                                                </video>
                                                            @elseif ($image->image_path)
                                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                     alt="Foto {{ $gallery->title }}">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            @if ($gallery->images->count() > 1)
                                                <button class="nav-btn right"
                                                        onclick="slideGallery({{ $gallery->id }}, 1)">&#8594;</button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endforeach

        <div class="lightbox" id="lightbox" onclick="closeLightbox()">
            <span class="lightbox-close" onclick="closeLightbox()">x</span>
            <img class="lightbox-content" id="lightboxImg">
        </div>

        <script>

            // Active modal tracker
            let activeGalleryModalId = null;

            function openGalleryModal(id) {
                document.getElementById('modal-' + id).classList.add('active');
                document.body.style.overflow = 'hidden';
                activeGalleryModalId = id;
                const counter = document.getElementById('counter-' + id);
                if (counter) {
                    const parts = counter.textContent.trim().split('/');
                    if (parts.length === 2) counter.textContent = '1 / ' + parts[1].trim();
                }
            }
            function closeGalleryModal(id) {
                const modal = document.getElementById('modal-' + id);
                modal.classList.remove('active');
                document.body.style.overflow = '';
                const track = modal.querySelector('.slide-track');
                if (track) track.style.transform = 'translateX(0)';
                if (gallerySlidePos[id] !== undefined) gallerySlidePos[id] = 0;
                modal.querySelectorAll('video').forEach(v => { v.pause(); v.currentTime = 0; });
                modal.querySelectorAll('iframe').forEach(fr => { const s = fr.src; fr.src = ''; fr.src = s; });
                const counter = document.getElementById('counter-' + id);
                if (counter) {
                    const parts = counter.textContent.trim().split('/');
                    if (parts.length === 2) counter.textContent = '1 / ' + parts[1].trim();
                }
                activeGalleryModalId = null;
            }
            function closeModalOnBackdrop(event, id) {
                if (event.target === event.currentTarget) closeGalleryModal(id);
            }
            const gallerySlidePos = {};
            function slideGallery(id, direction) {
                const slider = document.getElementById('slider-' + id);
                if (!slider) return;
                const track = slider.querySelector('.slide-track');
                const items = track.querySelectorAll('.slide-item');
                if (!items.length) return;
                if (gallerySlidePos[id] === undefined) gallerySlidePos[id] = 0;
                const cur = items[gallerySlidePos[id]];
                if (cur) cur.querySelectorAll('video').forEach(v => v.pause());
                gallerySlidePos[id] = (gallerySlidePos[id] + direction + items.length) % items.length;
                track.style.transform = `translateX(-${gallerySlidePos[id] * 100}%)`;
                const counter = document.getElementById('counter-' + id);
                if (counter) counter.textContent = (gallerySlidePos[id] + 1) + ' / ' + items.length;
            }
            function slideGalleryGrid(direction) {
                const slider = document.getElementById('gallerySlider');
                if (slider) slider.scrollBy({ left: 320 * direction, behavior: 'smooth' });
            }
            // Keyboard navigation
            document.addEventListener('keydown', function (e) {
                if (!activeGalleryModalId) return;
                if (e.key === 'ArrowRight') slideGallery(activeGalleryModalId,  1);
                if (e.key === 'ArrowLeft')  slideGallery(activeGalleryModalId, -1);
                if (e.key === 'Escape')     closeGalleryModal(activeGalleryModalId);
            });

            // ===== BIE Gallery Carousel Auto-Slide =====
            (function () {
                const track   = document.getElementById('bie-track');
                const wrap    = document.getElementById('bie-wrap');
                const prevBtn = document.getElementById('bie-prev');
                const nextBtn = document.getElementById('bie-next');
                if (!track || !wrap || !prevBtn || !nextBtn) return;

                const frames = Array.from(track.querySelectorAll('.gallery-frame'));
                const total  = frames.length;

                // Jika ≤ 2 item, sembunyikan tombol – tidak perlu carousel
                if (total <= 2) {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                    return;
                }

                let current = 0;
                let autoTimer;

                function getPerView() {
                    if (window.innerWidth <= 480) return 1;
                    if (window.innerWidth <= 1024) return 2;
                    return 3;
                }

                function getStepPx() {
                    const gap = parseFloat(getComputedStyle(track).gap) || 24;
                    return frames[0].offsetWidth + gap;
                }

                function getMaxIndex() {
                    return Math.max(0, total - getPerView());
                }

                function goTo(idx) {
                    current = Math.max(0, Math.min(idx, getMaxIndex()));
                    track.style.transform = 'translateX(-' + (current * getStepPx()) + 'px)';
                }

                function next() { goTo(current >= getMaxIndex() ? 0 : current + 1); }
                function prev() { goTo(current <= 0 ? getMaxIndex() : current - 1); }

                prevBtn.addEventListener('click', function (e) { e.stopPropagation(); prev(); resetAuto(); });
                nextBtn.addEventListener('click', function (e) { e.stopPropagation(); next(); resetAuto(); });

                function startAuto() { autoTimer = setInterval(next, 3500); }
                function resetAuto() { clearInterval(autoTimer); startAuto(); }

                wrap.addEventListener('mouseenter', function () { clearInterval(autoTimer); });
                wrap.addEventListener('mouseleave', startAuto);
                window.addEventListener('resize', function () { goTo(current); });

                startAuto();
            })();
        </script>

        </section>

                    {{-- Modals --}}
                    @foreach ($galleries as $gallery)
                        @if ($gallery->images->isNotEmpty())
                            <div id="modal-{{ $gallery->id }}" class="gallery-modal"
                                 onclick="closeModalOnBackdrop(event, {{ $gallery->id }})">
                                <div class="modal-content">

                                    {{-- Header bar --}}
                                    <div class="modal-head-bar">
                                        <div class="modal-head-left">
                                            <i class="fas fa-images" style="color:#FFA109;font-size:.82rem;flex-shrink:0;"></i>
                                            <h3>{{ $gallery->title }}</h3>
                                        </div>
                                        <div class="modal-head-right">
                                            @if ($gallery->images->count() > 1)
                                                <span class="modal-slide-counter" id="counter-{{ $gallery->id }}">
                                                    1 / {{ $gallery->images->count() }}
                                                </span>
                                            @endif
                                            <button class="modal-close-btn"
                                                    onclick="closeGalleryModal({{ $gallery->id }})"
                                                    title="Tutup">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Slider body --}}
                                    <div class="modal-body-area">
                                        <div class="modal-slider-wrapper">
                                            @if ($gallery->images->count() > 1)
                                                <button class="nav-btn left"
                                                        onclick="slideGallery({{ $gallery->id }}, -1)">&#8592;</button>
                                            @endif

                                            <div class="modal-slider" id="slider-{{ $gallery->id }}">
                                                <div class="slide-track">
                                                    @foreach ($gallery->images as $image)
                                                        <div class="slide-item">
                                                            @if ($image->isYoutubeVideo() && $image->getYoutubeEmbedUrl())
                                                                <iframe
                                                                    src="{{ $image->getYoutubeEmbedUrl() }}"
                                                                    frameborder="0"
                                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                    allowfullscreen>
                                                                </iframe>
                                                            @elseif ($image->isLocalVideo())
                                                                <video controls>
                                                                    <source src="{{ asset('storage/' . $image->image_path) }}">
                                                                    Browser Anda tidak mendukung pemutaran video.
                                                                </video>
                                                            @elseif ($image->image_path)
                                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                     alt="Foto {{ $gallery->title }}">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            @if ($gallery->images->count() > 1)
                                                <button class="nav-btn right"
                                                        onclick="slideGallery({{ $gallery->id }}, 1)">&#8594;</button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endforeach



        <link rel="stylesheet" href="{{ asset('css/kontak.css') }}">

        <div class="wave-dividerkontak">
            <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path class="shape-fillkontak"
                    d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>

        <section id="kontak" class="kontak-section">
            <div class="container">
                <h2 class="section-title">Kontak Kami</h2>
                <p class="kontak-subtitle">
                    Ingin terhubung dengan kami? Hubungi kami langsung via WhatsApp atau kunjungi lokasi kami.
                </p>

                <div class="kontak-maps">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.299223137717!2d112.1899974!3d-7.758055899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785db5d1b27adb%3A0xa8f77ed278eedc6!2sBrilliant%20English%20Course%20Kampung%20Inggris%20Pare!5e0!3m2!1sen!2sid!4v1753597882357!5m2!1sen!2sid"
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </section>

                    {{-- Modals --}}
                    @foreach ($galleries as $gallery)
                        @if ($gallery->images->isNotEmpty())
                            <div id="modal-{{ $gallery->id }}" class="gallery-modal"
                                 onclick="closeModalOnBackdrop(event, {{ $gallery->id }})">
                                <div class="modal-content">

                                    {{-- Header bar --}}
                                    <div class="modal-head-bar">
                                        <div class="modal-head-left">
                                            <i class="fas fa-images" style="color:#FFA109;font-size:.82rem;flex-shrink:0;"></i>
                                            <h3>{{ $gallery->title }}</h3>
                                        </div>
                                        <div class="modal-head-right">
                                            @if ($gallery->images->count() > 1)
                                                <span class="modal-slide-counter" id="counter-{{ $gallery->id }}">
                                                    1 / {{ $gallery->images->count() }}
                                                </span>
                                            @endif
                                            <button class="modal-close-btn"
                                                    onclick="closeGalleryModal({{ $gallery->id }})"
                                                    title="Tutup">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Slider body --}}
                                    <div class="modal-body-area">
                                        <div class="modal-slider-wrapper">
                                            @if ($gallery->images->count() > 1)
                                                <button class="nav-btn left"
                                                        onclick="slideGallery({{ $gallery->id }}, -1)">&#8592;</button>
                                            @endif

                                            <div class="modal-slider" id="slider-{{ $gallery->id }}">
                                                <div class="slide-track">
                                                    @foreach ($gallery->images as $image)
                                                        <div class="slide-item">
                                                            @if ($image->isYoutubeVideo() && $image->getYoutubeEmbedUrl())
                                                                <iframe
                                                                    src="{{ $image->getYoutubeEmbedUrl() }}"
                                                                    frameborder="0"
                                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                    allowfullscreen>
                                                                </iframe>
                                                            @elseif ($image->isLocalVideo())
                                                                <video controls>
                                                                    <source src="{{ asset('storage/' . $image->image_path) }}">
                                                                    Browser Anda tidak mendukung pemutaran video.
                                                                </video>
                                                            @elseif ($image->image_path)
                                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                     alt="Foto {{ $gallery->title }}">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            @if ($gallery->images->count() > 1)
                                                <button class="nav-btn right"
                                                        onclick="slideGallery({{ $gallery->id }}, 1)">&#8594;</button>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endforeach

        <footer>
            &copy; 2025 Brilliant International Education PLUS. Hak Cipta Dilindungi Oleh Undang-Undang
        </footer>

        @include('partials.whatsapp-floating')


    {{-- ===== COMING SOON MODAL ===== --}}
    <div id="comingSoonModal" class="cs-overlay">
        <div class="cs-box">

            {{-- Close button --}}
            <button class="cs-close-btn" id="closeComingSoon" title="Tutup">&times;</button>

            {{-- Left accent bar --}}
            <div class="cs-accent-bar"></div>

            {{-- Top label --}}
            <div class="cs-top-label">
                <span class="cs-dot"></span>
                <span>Brilliant English Course &mdash; 2026</span>
            </div>

            {{-- Main heading --}}
            <div class="cs-headline-wrap">
                <p class="cs-pre-title">Tiket Konser</p>
                <h2 class="cs-title">FOR<br>REVENGE</h2>
                <div class="cs-title-sub">segera&nbsp;dibuka&nbsp;&mdash;&nbsp;nantikan&nbsp;pengumuman&nbsp;resmi</div>
            </div>

            {{-- Divider --}}
            <div class="cs-rule"></div>

            {{-- Event details — tabel gaya poster --}}
            <div class="cs-details-grid">
                <div class="cs-detail-item">
                    <span class="cs-detail-key">Tanggal</span>
                    <span class="cs-detail-val">21 Agustus 2026</span>
                </div>
                <div class="cs-detail-item">
                    <span class="cs-detail-key">Lokasi</span>
                    <span class="cs-detail-val">Kampung Inggris, Pare</span>
                </div>
                <div class="cs-detail-item">
                    <span class="cs-detail-key">Artist</span>
                    <span class="cs-detail-val">For Revenge</span>
                </div>
                <div class="cs-detail-item">
                    <span class="cs-detail-key">Status</span>
                    <span class="cs-detail-val cs-status-pill">Segera Hadir</span>
                </div>
            </div>

            {{-- Divider --}}
            <div class="cs-rule"></div>

            {{-- WA CTA --}}
            <a href="https://wa.me/6282130203020?text=Halo%2C+saya+ingin+mendapatkan+info+tiket+konser+For+Revenge+di+Kampung+Inggris+Pare!" target="_blank" class="cs-wa-btn">
                <i class="fab fa-whatsapp"></i>
                <span>Info via WhatsApp</span>
                <i class="fas fa-arrow-right cs-arrow"></i>
            </a>

            <p class="cs-footnote">Pantau sosial media kami untuk pengumuman harga &amp; jadwal resmi.</p>

        </div>
    </div>
    {{-- ===== END COMING SOON MODAL ===== --}}

    </body>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>

    <script>
    // ===== Coming Soon Modal =====
    (function() {
        const modal   = document.getElementById('comingSoonModal');
        const closBtn = document.getElementById('closeComingSoon');
        const openers = ['openComingSoonBtn', 'navBeliTiketBtn', 'openKursusPopupBtn'];

        function openCS(e) { if(e) e.preventDefault(); modal.classList.add('cs-active'); document.body.style.overflow='hidden'; }
        function closeCS() { modal.classList.remove('cs-active'); document.body.style.overflow=''; }

        openers.forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.addEventListener('click', openCS);
        });
        if (closBtn) closBtn.addEventListener('click', closeCS);
        modal.addEventListener('click', function(e) { if(e.target === modal) closeCS(); });
        document.addEventListener('keydown', function(e) { if(e.key==='Escape') closeCS(); });

    })();
    </script>

    </html>

