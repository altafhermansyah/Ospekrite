@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">

        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">Overview</p>
                    <h1 class="h3 mb-1">Dashboard Panel</h1>
                    <p class="text-muted mb-0">Pantau transaksi Pre-Order Ospek Kit secara real-time.</p>
                </div>
            </div>
            <div class="heading-actions">
                <button class="btn btn-outline-secondary btn-sm" type="button">
                    <i class="bi bi-download" aria-hidden="true"></i> Export Laporan
                </button>
            </div>
        </div>

        <section class="row g-3 mt-1" aria-label="Dashboard metrics">
            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-primary">
                    <div class="metric-top">
                        <span class="metric-label">Total Tagihan Lunas</span>
                        <span class="metric-icon"><i class="bi bi-cash-stack" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">Rp {{ number_format($widget['omset_lunas'], 0, ',', '.') }}</div>
                    <div class="metric-meta">
                        <span>Dana masuk di rekening</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-success">
                    <div class="metric-top">
                        <span class="metric-label">Pesanan Masuk</span>
                        <span class="metric-icon"><i class="bi bi-bag-check" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($widget['total_orders']) }}</div>
                    <div class="metric-meta">
                        <span>Total formulir checkout</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-warning">
                    <div class="metric-top">
                        <span class="metric-label">Mahasiswa Terdaftar</span>
                        <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ number_format($widget['total_users']) }}</div>
                    <div class="metric-meta">
                        <span>Akun maba & panitia</span>
                    </div>
                </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <article class="metric-card metric-danger">
                    <div class="metric-top">
                        <span class="metric-label">Menunggu Validasi</span>
                        <span class="metric-icon"><i class="bi bi-hourglass-split" aria-hidden="true"></i></span>
                    </div>
                    <div class="metric-value">{{ $widget['pending_validation'] }}</div>
                    <div class="metric-meta">
                        <span class="text-danger fw-semibold">Urgent</span>
                        <span>butuh cek mutasi bank</span>
                    </div>
                </article>
            </div>
        </section>

        <section class="row g-3 mt-1">
            <div class="col-12 col-xl-8">
                <div class="panel h-100 shadow-sm border-0">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title"><i class="bi bi-bar-chart-line"
                                    aria-hidden="true"></i><span>Tren Pendapatan Bulanan</span></h2>
                            <p class="text-muted mb-0">Grafik akumulasi penjualan lunas sepanjang tahun 2026.</p>
                        </div>
                    </div>
                    <div class="p-3">
                        <canvas id="revenueTrendChart" style="min-height: 250px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="panel shadow-sm border-0 mb-3">
                    <div class="panel-header">
                        <div>
                            <h2 class="h5 mb-1 section-title">
                                <i class="bi bi-pie-chart" aria-hidden="true"></i><span>Distribusi Fakultas</span>
                            </h2>
                            <p class="text-muted mb-0">Proporsi pesanan masuk berdasarkan fakultas maba.</p>
                        </div>
                    </div>
                    <div class="p-3 bg-white rounded-bottom">
                        <div class="chart-container py-2" style="position: relative; height:280px; width:100%">
                            <canvas id="facultyDoughnutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // =============================================================================================
            // 1. INTEGRASI GRAFIK BATANG TREN REVENUE (CHART.JS)
            // =============================================================================================
            const ctxBar = document.getElementById('revenueTrendChart').getContext('2d');

            // Pengolahan data dari Backend Laravel PHP
            const chartDataRaw = @json($monthlyRevenue);
            const monthsLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                'Dec'
            ];
            const revenueValues = new Array(12).fill(0);

            // Suntikkan nilai omset sesuai dengan indeks bulan databasemu (1-12)
            chartDataRaw.forEach(item => {
                revenueValues[item.month - 1] = item.total_sales;
            });

            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: monthsLabel,
                    datasets: [{
                        label: 'Pendapatan Lunas (Rp)',
                        data: revenueValues,
                        backgroundColor: '#0d6efd',
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // =============================================================================================
            // 2. INTEGRASI GRAFIK DOUGHNUT DISTRIBUSI FAKULTAS (CHART.JS - MODERN STYLE)
            // =============================================================================================
            const ctxDoughnut = document.getElementById('facultyDoughnutChart').getContext('2d');
            const facultyDataRaw = @json($facultyMix);

            const facultyLabels = facultyDataRaw.map(item => item.fakultas);
            const facultyTotals = facultyDataRaw.map(item => item.total_order);

            new Chart(ctxDoughnut, {
                type: 'doughnut', // Mengubah tipe grafik menjadi doughnut
                data: {
                    labels: facultyLabels,
                    datasets: [{
                        data: facultyTotals,
                        backgroundColor: [
                            '#0d6efd', // Primary Blue
                            '#198754', // Success Green
                            '#ffc107', // Warning Yellow
                            '#dc3545', // Danger Red
                            '#0dcaf0', // Info Cyan
                            '#6c757d', // Secondary Gray
                            '#212529', // Dark Black
                            '#fd7e14' // Orange
                        ],
                        borderWidth: 3,
                        borderColor: '#ffffff', // Garis potong putih tegas ala UI modern
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%', // Mengatur ketebalan lubang tengah (makin besar % makin tipis & modern)
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                usePointStyle: true, // Mengubah kotak legenda menjadi lingkaran kecil biar estetik
                                padding: 15,
                                font: {
                                    size: 11,
                                    family: 'system-ui'
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return ` ${label}: ${value} Pesanan (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // =============================================================================================
            // 3. LOGIKA INTERAKSI MODAL DETAIL & VALIDASI ORDER
            // =============================================================================================
            const formStatus = document.getElementById('formUpdateStatusOrder');

            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-detail-order');
                if (btn) {
                    const id = btn.getAttribute('data-id');
                    const invoice = btn.getAttribute('data-invoice');
                    const nama = btn.getAttribute('data-nama');
                    const nim = btn.getAttribute('data-nim');
                    const whatsapp = btn.getAttribute('data-whatsapp');
                    const tagihan = btn.getAttribute('data-tagihan');
                    const ptype = btn.getAttribute('data-ptype');
                    const catatan = btn.getAttribute('data-catatan');
                    const bukti = btn.getAttribute('data-bukti');

                    const statusPayment = btn.getAttribute('data-spayment');
                    const statusOrder = btn.getAttribute('data-sorder');

                    formStatus.action = `/orders/${id}/status`;

                    document.getElementById('detInvoice').textContent = invoice ? '#' + invoice :
                        '#PENDING_KEY';
                    document.getElementById('detNama').textContent = nama;
                    document.getElementById('detNimProdi').textContent =
                        `${nim} — ${btn.getAttribute('data-fakultas')}`;
                    document.getElementById('detWhatsapp').textContent = whatsapp;
                    document.getElementById('detTagihan').textContent = tagihan;
                    document.getElementById('detPtype').textContent = ptype;
                    document.getElementById('detCatatan').textContent = catatan;

                    document.getElementById('edit_status_payment').value = statusPayment;
                    document.getElementById('edit_status_order').value = statusOrder;

                    const wrapperBukti = document.getElementById('wrapperBukti');
                    const imgEl = document.getElementById('detBuktiImg');
                    const txtEl = document.getElementById('detNoBukti');

                    if (ptype === 'QRIS DINAMIS') {
                        wrapperBukti.classList.add('d-none');
                    } else {
                        wrapperBukti.classList.remove('d-none');
                        if (bukti) {
                            imgEl.src = bukti;
                            imgEl.classList.remove('d-none');
                            txtEl.classList.add('d-none');
                        } else {
                            imgEl.src = '';
                            imgEl.classList.add('d-none');
                            txtEl.classList.remove('d-none');
                        }
                    }

                    const modal = new bootstrap.Modal(document.getElementById('modalDetailOrder'));
                    modal.show();
                }
            });
        });
    </script>
@endpush
