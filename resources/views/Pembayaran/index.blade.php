<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Pendaftaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .payment-details { border: 2px dashed #0d6efd; padding: 1.5rem; border-radius: .5rem; background-color: #f8f9fa; }
        .list-group-item { display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            @if(session('success'))
                <div class="alert alert-success text-center"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Selesaikan Pembayaran Anda</h4>
                </div>
                <div class="card-body p-4">
                    <div class="payment-details text-center mb-4">
                        <h5 class="mb-3">Detail Pendaftaran</h5>
                        <p class="mb-1"><strong>ID Transaksi:</strong></p>
                        
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <h3 class="fw-bold text-primary mb-0">{{ $pendaftaran->trx_id }}</h3>
                            <button class="btn btn-sm btn-outline-secondary" 
                                    onclick="copyToClipboard('{{ $pendaftaran->trx_id }}', this)" 
                                    title="Salin ID Transaksi">
                                <i class="bi bi-clipboard"></i>
                                <span class="copy-text d-none">Salin</span>
                            </button>
                        </div>
                        
                        <hr>
                        <p class="mb-1"><strong>Program:</strong></p>
                        <p class="lead">{{ $pendaftaran->program->nama }}</p>
                        <p class="mb-1"><strong>Total Pembayaran:</strong></p>
                        <h2 class="fw-bolder">Rp {{ number_format($pendaftaran->program->harga, 0, ',', '.') }}</h2>
                    </div>

                    <div class="instructions mb-4">
                        <h5 class="text-center mb-3">Instruksi Pembayaran</h5>
                        <p>Silakan transfer ke rekening berikut:</p>
                        <ul class="list-group">
                            @if ($pendaftaran->bank)
                                <li class="list-group-item">
                                    <div>
                                        <i class="bi bi-bank"></i>
                                        <strong>{{ $pendaftaran->bank->name }}:</strong>
                                        <span id="bank-number">{{ $pendaftaran->bank->number }}</span> (a.n. {{ $pendaftaran->bank->owner }})
                                    </div>
                                    <button class="btn btn-sm btn-outline-secondary"
                                            onclick="copyToClipboard('{{ $pendaftaran->bank->number }}', this)">
                                        <i class="bi bi-clipboard"></i>
                                        <span class="copy-text">Salin</span>
                                    </button>
                                </li>
                            @else
                                <li class="list-group-item text-center text-muted">Informasi bank belum dipilih.</li>
                            @endif
                        </ul>
                    </div>

                    <hr>
                    <div class="upload-section mt-4">
                        <h5 class="text-center mb-3">Unggah Bukti Pembayaran</h5>
                        <p class="text-center text-muted small">Setelah transfer, unggah bukti Anda di sini (JPG, PNG, PDF. Maks 2MB).</p>

                        <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $pendaftaran->id }}">
                            <input type="hidden" name="type" value="offline">

                            <div class="input-group">
                                <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran" required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-upload"></i> Kirim Bukti
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="mt-4 text-center">
                        {{-- PERUBAHAN: Mengambil nomor dari koleksi $contactServices --}}
                        @php
                            // Ambil kontak pertama dari koleksi, atau gunakan nomor cadangan jika tidak ada
                            $waNumber = $contactServices->isNotEmpty() ? $contactServices->first()->nomor : '6281234567890';
                        @endphp
                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, saya ingin konfirmasi pembayaran untuk ID Transaksi: ' . $pendaftaran->trx_id . ' dengan total Rp ' . number_format($pendaftaran->program->harga, 0, ',', '.')) }}" class="btn btn-success mb-2" target="_blank"><i class="bi bi-whatsapp"></i> Konfirmasi via WhatsApp</a>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary mb-2"><i class="bi bi-house-door-fill"></i> Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fungsi untuk menyalin teks ke clipboard
    function copyToClipboard(text, buttonElement) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            
            const copyTextSpan = buttonElement.querySelector('.copy-text');
            const originalText = copyTextSpan ? copyTextSpan.innerHTML : 'Salin';
            const icon = buttonElement.querySelector('i');
            
            if (copyTextSpan) {
                copyTextSpan.innerHTML = 'Tersalin!';
            }
            icon.classList.remove('bi-clipboard');
            icon.classList.add('bi-check-lg');
            buttonElement.classList.remove('btn-outline-secondary');
            buttonElement.classList.add('btn-success');

            setTimeout(() => {
                if (copyTextSpan) {
                    copyTextSpan.innerHTML = originalText;
                }
                icon.classList.remove('bi-check-lg');
                icon.classList.add('bi-clipboard');
                buttonElement.classList.remove('btn-success');
                buttonElement.classList.add('btn-outline-secondary');
            }, 2000);

        } catch (err) {
            console.error('Gagal menyalin teks: ', err);
        }
        document.body.removeChild(textArea);
    }
</script>
</body>
</html>
