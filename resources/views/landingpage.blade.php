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

                <a href="#" id="openPopupBtn" class="cta-button" data-aos="fade-up" data-aos-delay="200">
                    BELI TIKET KONSER
                </a>
            </div>
        </div>

        <!-- Popup Tiket Konser: Pilih Kategori -->
<div id="tiketPopup" class="popup1-overlay">
    <div class="popup1-content">
        <div class="popup1-header">
            <h2>Pilih Kategori Tiket</h2>
            <button id="closeTiketPopupBtn" class="close1-button">&times;</button>
        </div>
        <div class="program-grid">
            <a href="{{ route('tiket-konser.create', ['kategori' => 'umum']) }}"
               class="program1-card">
                <div class="program2-icon" style="background:#fff3cd;padding:16px;border-radius:8px;">
                    <i class="fas fa-ticket-alt" style="font-size:3rem;color:#FFA109;"></i>
                </div>
                <h3>{{ $pengaturanTiket->nama_kategori_umum }}</h3>
                <span class="pilih1-button">Rp {{ number_format($pengaturanTiket->harga_umum, 0, ',', '.') }}</span>
            </a>
            <a href="{{ route('tiket-konser.create', ['kategori' => 'vip']) }}"
               class="program1-card">
                <div class="program2-icon" style="background:#f8d7da;padding:16px;border-radius:8px;">
                    <i class="fas fa-crown" style="font-size:3rem;color:#dc3545;"></i>
                </div>
                <h3>{{ $pengaturanTiket->nama_kategori_vip }}</h3>
                <span class="pilih1-button" style="background:#dc3545;">Rp {{ number_format($pengaturanTiket->harga_vip, 0, ',', '.') }}</span>
            </a>
            <a href="{{ route('tiket-konser.create', ['kategori' => 'member']) }}"
               class="program1-card">
                <div class="program2-icon" style="background:#d4edda;padding:16px;border-radius:8px;">
                    <i class="fas fa-id-card" style="font-size:3rem;color:#28a745;"></i>
                </div>
                <h3>Member Aktif Brilliant</h3>
                <span class="pilih1-button" style="background:#28a745;">Rp {{ number_format($pengaturanTiket->harga_member, 0, ',', '.') }}</span>
            </a>
            <a href="{{ route('tiket-konser.create', ['kategori' => 'spesial']) }}"
               class="program1-card">
                <div class="program2-icon" style="background:#cce5ff;padding:16px;border-radius:8px;">
                    <i class="fas fa-star" style="font-size:3rem;color:#004085;"></i>
                </div>
                <h3>{{ $pengaturanTiket->nama_kategori_spesial }}</h3>
                <span class="pilih1-button" style="background:#004085;">GRATIS 🎉</span>
            </a>
        </div>
    </div>
</div>

</style>

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
                    Dokumentasi kegiatan dan momen-momen seru bersama Brilliant International Education PLUS.
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
                                </div>
                                @php $index++; @endphp
                            @endif
                        @endforeach
                            </div>{{-- end .gallery-carousel-track --}}
                        </div>{{-- end .gallery-carousel-wrap --}}
                        <button class="carousel-nav-btn carousel-next" id="bie-next">&#8594;</button>
                    </div>{{-- end .gallery-carousel-outer --}}
                    {{-- Modal BIE di luar gallery-grid --}}
                    @foreach ($galleries as $gallery)
                        @if ($gallery->images->isNotEmpty())
                            <div id="modal-{{ $gallery->id }}" class="gallery-modal">
                                <div class="modal-content">
                                    <span class="close-btn"
                                        onclick="closeGalleryModal({{ $gallery->id }})">&times;</span>
                                    <h3>{{ $gallery->title }}</h3>
                                    <div class="modal-slider-wrapper">
                                        <button class="nav-btn left"
                                            onclick="slideGallery({{ $gallery->id }}, -1)">&#8592;</button>
                                        <div class="modal-slider" id="slider-{{ $gallery->id }}">
                                            <div class="slide-track">
                                                @foreach ($gallery->images as $image)
                                                    <div class="slide-item">
                                                        @if ($image->isYoutubeVideo() && $image->getYoutubeEmbedUrl())
                                                            <iframe
                                                                src="{{ $image->getYoutubeEmbedUrl() }}"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen
                                                                style="width:100%; height:400px; border-radius:8px;">
                                                            </iframe>
                                                        @elseif ($image->isLocalVideo())
                                                            <video controls style="max-width:100%; max-height:65vh; border-radius:8px; background:#000;">
                                                                <source src="{{ asset('storage/' . $image->image_path) }}">
                                                                Browser Anda tidak mendukung pemutaran video.
                                                            </video>
                                                        @elseif ($image->image_path)
                                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                alt="Foto Galeri">
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button class="nav-btn right"
                                            onclick="slideGallery({{ $gallery->id }}, 1)">&#8594;</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
            </div>
        </section>

        <div class="lightbox" id="lightbox" onclick="closeLightbox()">
            <span class="lightbox-close" onclick="closeLightbox()">x</span>
            <img class="lightbox-content" id="lightboxImg">
        </div>

        <script>

            // Galeri BIE â€” modal & slider
            function openGalleryModal(id) {
                document.getElementById('modal-' + id).classList.add('active');
                document.body.style.overflow = 'hidden';
            }
            function closeGalleryModal(id) {
                const modal = document.getElementById('modal-' + id);
                modal.classList.remove('active');
                document.body.style.overflow = '';
                const track = modal.querySelector('.slide-track');
                if (track) track.style.transform = 'translateX(0)';
                if (gallerySlidePos[id] !== undefined) gallerySlidePos[id] = 0;
                modal.querySelectorAll('video').forEach(v => v.pause());
            }
            const gallerySlidePos = {};
            function slideGallery(id, direction) {
                const slider = document.getElementById('slider-' + id);
                if (!slider) return;
                const track = slider.querySelector('.slide-track');
                const items = track.querySelectorAll('.slide-item');
                if (!items.length) return;
                if (gallerySlidePos[id] === undefined) gallerySlidePos[id] = 0;
                gallerySlidePos[id] = (gallerySlidePos[id] + direction + items.length) % items.length;
                track.style.transform = `translateX(-${gallerySlidePos[id] * 100}%)`;
            }
            function slideGalleryGrid(direction) {
                const slider = document.getElementById('gallerySlider');
                if (slider) slider.scrollBy({ left: 320 * direction, behavior: 'smooth' });
            }

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

        <link rel="stylesheet" href="{{ asset('css/sosmed.css') }}">

        <section id="sosmed" class="sosmed-section">
            <div class="container">
                <h2 class="section-title">Sosial Media Kami</h2>
                @if (!$hasSosmed)
                    <p class="text-center">Belum ada data yang ditambahkan. Stay tuned!</p>
                @else
                    @foreach ($groupedSosmed as $platform => $items)
                        @if (count($items) > 0)
                            <div class="mb-5">
                                <h4 class="section-subtitle fw-semibold mb-4">{{ $platform }}</h4>
                                <div class="sosmed-grid">
                                    @foreach ($items as $item)
                                        <div class="sosmed-card" data-platform="{{ strtolower($platform) }}">
                                            <div class="sosmed-card-image">
                                                @if (strtolower($platform) === 'youtube')
                                                    <div class="sosmed-card-video">
                                                        <iframe width="100%" height="200"
                                                            src="https://www.youtube.com/embed/{{ getYoutubeVideoId($item->url) }}"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen>
                                                        </iframe>
                                                    </div>
                                                @elseif (strtolower($platform) === 'instagram')
                                                    <a href="{{ $item->url }}" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <img src="{{ asset('storage/' . $item->image_path) }}"
                                                            alt="Instagram Image">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </section>

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
                    Ingin terhubung dengan kami? Silakan hubungi lewat email atau sosial media berikut.
                </p>

                <div class="kontak-info">
                    <p><strong>Instagram:</strong> <a
                            href="https://www.instagram.com/kekampunginggrisbrilliant"
                            target="_blank">kekampunginggrisbrilliant</a></p>
                    <p><strong>TikTok:</strong> <a
                            href="https://www.tiktok.com/@kekampunginggris"
                            target="_blank">kekampunginggris</a></p>
                </div>

                <div class="kontak-maps">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.299223137717!2d112.1899974!3d-7.758055899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785db5d1b27adb%3A0xa8f77ed278eedc6!2sBrilliant%20English%20Course%20Kampung%20Inggris%20Pare!5e0!3m2!1sen!2sid!4v1753597882357!5m2!1sen!2sid"
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>
        </section>

        <footer>
            &copy; 2025 Brilliant International Education PLUS. Hak Cipta Dilindungi Oleh Undang-Undang
        </footer>

        @include('partials.whatsapp-floating')

    </body>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true,
        });
    </script>

    </html>

