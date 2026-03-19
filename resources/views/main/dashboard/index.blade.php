@extends('template.master')

@section('page-title', 'Dashboard')

@push('css')
    {{-- Library untuk select dropdown yang lebih canggih --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- Library untuk animasi saat scroll/load --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --purple: #6366f1;
            --pink: #ec4899;
            --light-gray: #f8f9fa;
            --text-dark: #343a40;
            --text-muted: #6c757d;
        }

        body {
            background-color: var(--light-gray);
        }

        .card {
            border: none;
            border-radius: 1rem;
            /* Sudut lebih bulat */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease-in-out;
            background: #fff;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Gradien halus untuk latar belakang card header */
        .card .card-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, var(--light-gray) 100%);
            border-bottom: none;
            font-weight: 600;
            color: var(--text-dark);
        }

        .chart-container {
            height: 320px;
            position: relative;
        }

        .chart-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .chart-empty {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: var(--text-muted);
        }

        /* Efek transisi untuk kemunculan canvas */
        canvas {
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        canvas.show {
            opacity: 1;
        }

        /* Styling untuk filter */
        .filter-card {
            background: #ffffff;
        }

        .table-responsive {
            border-radius: 0.5rem;
        }

        thead {
            background-color: var(--primary);
            color: white;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 280px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row g-4 mb-4">
        {{-- Statistik Utama (jika ada) --}}
        @include('main.dashboard.partials.stats')
    </div>

    <div class="row g-4 mb-4" data-aos="fade-up">
        <div class="col-12">
            <div class="card p-3 filter-card">
                <div class="d-flex flex-column flex-md-row flex-wrap gap-3 align-items-center">
                    <div class="flex-grow-1">
                        <label for="yearFilter" class="form-label fw-semibold">Tahun</label>
                        <select id="yearFilter" class="form-select">
                            <option value="">Semua Tahun</option>
                            @foreach ($projectsPerYear->keys() as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-grow-1">
                        <label for="categoryFilter" class="form-label fw-semibold">Kategori</label>
                        <select id="categoryFilter" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach ($projectsPerCategory as $category)
                                <option value="{{ $category->project_category_name }}">
                                    {{ $category->project_category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card p-3 h-100">
                <h5 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                    <i class="ti ti-calendar-event"></i> Proyek per Tahun
                </h5>
                <div class="chart-container">
                    <div id="projectsPerYearLoader" class="chart-loader">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <canvas id="projectsPerYearChart"></canvas>
                    <div id="projectsPerYearEmpty" class="chart-empty" style="display:none;">
                        <i class="ti ti-chart-bar-off fs-1"></i>
                        <p class="mt-2">Data tidak ditemukan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6" data-aos="fade-up" data-aos-delay="200">
            <div class="card p-3 h-100">
                <h5 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                    <i class="ti ti-layout-grid"></i> Proyek per Kategori
                </h5>
                <div class="chart-container">
                    <div id="projectsPerCategoryLoader" class="chart-loader">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <canvas id="projectsPerCategoryChart"></canvas>
                    <div id="projectsPerCategoryEmpty" class="chart-empty" style="display:none;">
                        <i class="ti ti-chart-pie-off fs-1"></i>
                        <p class="mt-2">Data tidak ditemukan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12" data-aos="fade-up" data-aos-delay="300">
            <div class="card p-3 mt-4">
                <h5 class="fw-semibold mb-3 d-flex align-items-center gap-2">
                    <i class="ti ti-trending-up"></i> Tren Proyek
                </h5>
                <div class="chart-container">
                    <div id="projectsTrendLoader" class="chart-loader">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <canvas id="projectsTrendChart"></canvas>
                    <div id="projectsTrendEmpty" class="chart-empty" style="display:none;">
                        <i class="ti ti-chart-line-off fs-1"></i>
                        <p class="mt-2">Data tidak ditemukan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4 mt-4" data-aos="fade-up" data-aos-delay="400">
        <h5 class="fw-semibold mb-3 d-flex align-items-center gap-2">
            <i class="ti ti-list-details"></i> Daftar Proyek Terbaru
        </h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="recentProjectsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Proyek</th>
                        <th>Kategori</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Konten tabel akan diisi oleh AJAX --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi semua komponen dasbor
            initDashboard();

            // Atur sidebar jika diperlukan (Dihapus karena menyebabkan konflik dengan role-based menu)
            // setTimeout(() => {
            //     $('[id^="mini-"]').removeClass('selected');
            //     $('#dashboard').addClass('selected');
            //     $('body').attr('data-sidebartype', 'mini-sidebar');
            //     $('.container-fluid').css('max-width', '1500px');
            // }, 1000);
        });

        // Objek untuk menyimpan instance Chart.js
        const charts = {
            perYear: null,
            perCategory: null,
            trend: null
        };

        // Skema warna untuk grafik
        const chartColorSchemes = {
            perYear: {
                background: 'rgba(59, 130, 246, 0.8)',
                border: '#3b82f6'
            },
            perCategory: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1', '#ec4899'],
            trend: {
                line: '#3b82f6',
                fill: 'rgba(59, 130, 246, 0.1)',
                point: '#3b82f6'
            }
        };

        // Fungsi utama untuk inisialisasi
        function initDashboard() {
            // Inisialisasi AOS (Animate On Scroll)
            AOS.init({
                duration: 800,
                once: true
            });

            // Inisialisasi Select2
            $('.form-select').select2({
                width: '100%',
                minimumResultsForSearch: 10
            });

            // Muat data awal untuk semua komponen
            updateDashboard();

            // Atur event listener untuk filter
            $('#yearFilter, #categoryFilter').on('change', function() {
                updateDashboard();
            });
        }

        // Fungsi terpusat untuk memuat/memperbarui semua data dasbor
        function updateDashboard() {
            const year = $('#yearFilter').val();
            const category = $('#categoryFilter').val();

            loadProjectsPerYearChart(year);
            loadProjectsPerCategoryChart(category, year); // Tambahkan filter tahun di sini
            loadProjectsTrend(year);
            filterRecentProjects(year, category);
        }

        // --- FUNGSI-FUNGSI AJAX UNTUK MEMUAT DATA ---

        function loadProjectsPerYearChart(year = '') {
            showLoader('projectsPerYear');
            $.ajax({
                url: "{{ route('dashboard.projectsPerYear') }}",
                data: {
                    year
                },
                success: response => {
                    if (charts.perYear) charts.perYear.destroy();
                    const ctx = document.getElementById('projectsPerYearChart').getContext('2d');
                    charts.perYear = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Total Proyek',
                                data: response.data,
                                backgroundColor: chartColorSchemes.perYear.background,
                                borderColor: chartColorSchemes.perYear.border,
                                borderWidth: 1,
                                borderRadius: 8
                            }]
                        },
                        options: getChartOptions('bar')
                    });
                    handleChartResponse('projectsPerYear', response.data.length > 0);
                },
                error: (xhr) => {
                    if (xhr.status !== 0) showError('Gagal memuat data Proyek per Tahun.');
                }
            });
        }

        function loadProjectsPerCategoryChart(category = '', year = '') {
            showLoader('projectsPerCategory');
            $.ajax({
                url: "{{ route('dashboard.projectsPerCategory') }}",
                data: {
                    category,
                    year
                }, // Kirim filter tahun juga
                success: response => {
                    if (charts.perCategory) charts.perCategory.destroy();
                    const ctx = document.getElementById('projectsPerCategoryChart').getContext('2d');
                    charts.perCategory = new Chart(ctx, {
                        type: 'doughnut', // Ganti ke doughnut untuk tampilan lebih modern
                        data: {
                            labels: response.labels,
                            datasets: [{
                                data: response.data,
                                backgroundColor: chartColorSchemes.perCategory,
                                borderColor: '#fff',
                                borderWidth: 2
                            }]
                        },
                        options: getChartOptions('doughnut')
                    });
                    handleChartResponse('projectsPerCategory', response.data.length > 0);
                },
                error: (xhr) => {
                    if (xhr.status !== 0) showError('Gagal memuat data Proyek per Kategori.');
                }
            });
        }

        function loadProjectsTrend(year = '') {
            showLoader('projectsTrend');
            $.ajax({
                url: "{{ route('dashboard.projectsTrend') }}",
                data: {
                    year
                },
                success: response => {
                    if (charts.trend) charts.trend.destroy();
                    const ctx = document.getElementById('projectsTrendChart').getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
                    gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

                    charts.trend = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Tren Proyek',
                                data: response.data,
                                borderColor: chartColorSchemes.trend.line,
                                backgroundColor: gradient, // Gunakan gradien
                                tension: 0.4, // Garis lebih melengkung
                                fill: true,
                                pointRadius: 4,
                                pointBackgroundColor: chartColorSchemes.trend.point,
                                borderWidth: 2
                            }]
                        },
                        options: getChartOptions('line')
                    });
                    handleChartResponse('projectsTrend', response.data.length > 0);
                },
                error: (xhr) => {
                    if (xhr.status !== 0) showError('Gagal memuat data Tren Proyek.');
                }
            });
        }

        function filterRecentProjects(year = '', category = '') {
            // Tampilkan loader sederhana di tabel
            $('#recentProjectsTable tbody').html(
                '<tr><td colspan="5" class="text-center"><div class="spinner-border spinner-border-sm"></div> Memuat...</td></tr>'
                );
            $.ajax({
                url: "{{ route('dashboard.recentProjects') }}",
                data: {
                    year,
                    category
                },
                success: response => {
                    $('#recentProjectsTable tbody').html(response.html);
                    if (!response.html.trim()) {
                        $('#recentProjectsTable tbody').html(
                            '<tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>');
                    }
                },
                error: (xhr) => {
                    if (xhr.status !== 0) {
                        $('#recentProjectsTable tbody').html(
                            '<tr><td colspan="5" class="text-center text-danger">Gagal memuat data.</td></tr>');
                        showError('Gagal memuat daftar proyek terbaru.');
                    }
                }
            });
        }

        // --- FUNGSI-FUNGSI PEMBANTU (HELPERS) ---

        function getChartOptions(type) {
            const options = {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000
                },
                plugins: {
                    legend: {
                        position: (type === 'doughnut' || type === 'pie') ? 'bottom' : 'top',
                        labels: {
                            color: '#333',
                            font: {
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || context.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) label += context.parsed.y;
                                else if (context.parsed !== null) label += context.parsed;
                                return ' ' + label;
                            }
                        }
                    }
                },
                scales: (type === 'bar' || type === 'line') ? {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },
                        ticks: {
                            color: '#666'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#666'
                        }
                    }
                } : {}
            };
            return options;
        }

        function showLoader(chartId) {
            $(`#${chartId}Loader`).show();
            $(`#${chartId}Chart`).removeClass('show').hide();
            $(`#${chartId}Empty`).hide();
        }

        function handleChartResponse(chartId, hasData) {
            $(`#${chartId}Loader`).hide();
            if (hasData) {
                $(`#${chartId}Chart`).addClass('show').show();
                $(`#${chartId}Empty`).hide();
            } else {
                $(`#${chartId}Chart`).hide();
                $(`#${chartId}Empty`).show();
            }
        }

        function showError(message) {
            Swal.fire({
                title: 'Error!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#3b82f6'
            });
        }
    </script>
@endpush
