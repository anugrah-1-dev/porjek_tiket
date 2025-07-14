    @extends('adminlte::page')

    @section('title', 'Dashboard')

    @section('content_header')
        <h1>Dashboard Admin</h1>
    @endsection

    @section('content')
        {{-- Ringkasan --}}
        <div class="row mt-4 justify-content-center text-center">

            <div class="col-6 col-md-3">
                <x-adminlte-info-box title="Kursus Terjual" :text="$totalKursus" icon="fas fa-shopping-cart" theme="success" />
            </div>
            <div class="col-6 col-md-3">
                <x-adminlte-info-box title="Keuntungan" :text="'Rp ' . number_format($totalKeuntungan, 0, ',', '.')" icon="fas fa-money-bill" theme="warning" />
            </div>
            <div class="col-6 col-md-3">
                <x-adminlte-info-box title="Media Sosial" :text="$totalMediaSosial . ' Upload'" icon="fas fa-photo-video" theme="primary" />
            </div>
        </div>

        {{-- Grafik --}}
        <div class="row mt-4">
            <div class="col-md-6">
                <x-adminlte-card title="Keuntungan Bulanan" theme="info" icon="fas fa-chart-line">
                    <canvas id="profitChart" height="180"></canvas>
                </x-adminlte-card>
            </div>
            <div class="col-md-6">
                <x-adminlte-card title="Penjualan Kursus" theme="success" icon="fas fa-chart-bar">
                    <canvas id="salesChart" height="180"></canvas>
                </x-adminlte-card>
            </div>
        </div>


        {{-- Galeri Media Sosial --}}
        <div class="row mt-4 justify-content-center">
            <div class="col-12">
                <x-adminlte-card title="Galeri Media Sosial" theme="light" icon="fas fa-photo-video">
                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                        @for ($i = 1; $i <= 8; $i++)
                            <div class="d-flex flex-column align-items-center m-2">
                                <img src="https://picsum.photos/seed/social{{ $i }}/100/100" class="shadow"
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 16px;"
                                    alt="Media Sosial {{ $i }}">
                                <small class="mt-2 text-muted">
                                    @if ($i % 2 == 0)
                                        <i class="fab fa-instagram"></i> Instagram
                                    @else
                                        <i class="fab fa-facebook"></i> Facebook
                                    @endif
                                </small>
                            </div>
                        @endfor
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    @endsection

    @section('css')
        <style>
            .gap-2 {
                gap: 0.5rem;
            }

            @media (max-width: 768px) {
                canvas {
                    max-width: 100%;
                }
            }
        </style>
    @endsection
    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Data dari Controller
            const monthlyProfit = @json($monthlyProfit);
            const salesData = @json($salesData);

            // Profit Chart
            const ctxProfit = document.getElementById('profitChart').getContext('2d');
            const colors = ['#17a2b8', '#28a745', '#ffc107', '#dc3545', '#6f42c1']; // Tambah jika perlu
            const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            const datasets = Object.entries(monthlyProfit).map(([year, data], index) => ({
                label: `Tahun ${year}`,
                data: Object.values(data),
                borderColor: colors[index % colors.length],
                backgroundColor: colors[index % colors.length] + '33', // transparan
                fill: false,
                tension: 0.4
            }));

            new Chart(ctxProfit, {
                type: 'line',
                data: {
                    labels: monthLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Keuntungan Bulanan per Tahun'
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });


            // Sales Chart
            new Chart(document.getElementById('salesChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(salesData),
                    datasets: [{
                        label: 'Total Penjualan Berdasarkan Kuota',
                        data: Object.values(salesData),
                        backgroundColor: ['#007bff', '#28a745']
                    }]
                }
            });

            console.log('Dashboard dengan data real dimuat.');
        </script>
    @endsection
