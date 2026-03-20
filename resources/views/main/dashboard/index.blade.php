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
            --text-dark: #334155;
            --text-muted: #64748b;
        }

        body {
            background-color: #f1f5f9;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 1.25rem;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .glass-panel:hover {
            box-shadow: 0 10px 30px 0 rgba(0, 0, 0, 0.06);
        }

        .chart-container {
            height: 350px;
            position: relative;
            padding: 10px;
        }

        /* Skeleton Screen Animation */
        @keyframes skeleton-loading {
            0% { background-position: 100% 50%; }
            100% { background-position: 0 50%; }
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 0.5rem;
        }

        .skeleton-text { height: 20px; margin-bottom: 10px; width: 80%; }
        .skeleton-chart { height: 100%; width: 100%; }

        .form-select {
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1rem;
            transition: all 0.2s;
        }

        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.03);
            transform: scale(1.002);
            transition: all 0.2s ease;
        }

        .table thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.25rem 1rem;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 300px;
            }
            .card.glass-panel {
                padding: 1.25rem !important;
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
            <div class="card p-4 glass-panel border-0">
                <div class="d-flex flex-column flex-md-row flex-wrap gap-4 align-items-center">
                    <div class="flex-grow-1">
                        <label for="yearFilter" class="form-label fw-bold text-dark fs-2 mb-2">School Year</label>
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
            <div class="card glass-panel border-0 p-4 h-100">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2 text-dark">
                    <iconify-icon icon="solar:chart-2-bold-duotone" class="text-primary fs-6"></iconify-icon>
                    Projects per Year
                </h5>
                <div class="chart-container">
                    <div id="projectsPerYearLoader" class="chart-loader w-100 h-100 skeleton skeleton-chart"></div>
                    <canvas id="projectsPerYearChart"></canvas>
                    <div id="projectsPerYearEmpty" style="display:none;">
                        @include('partials.empty_state', [
                            'icon' => 'solar:chart-square-broken-duotone',
                            'title' => 'No Annual Data',
                            'description' => 'We couldn\'t find any project data for the selected years.'
                        ])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6" data-aos="fade-up" data-aos-delay="200">
            <div class="card glass-panel border-0 p-4 h-100">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2 text-dark">
                    <iconify-icon icon="solar:pie-chart-2-bold-duotone" class="text-info fs-6"></iconify-icon>
                    Projects per Category
                </h5>
                <div class="chart-container">
                    <div id="projectsPerCategoryLoader" class="chart-loader w-100 h-100 skeleton skeleton-chart"></div>
                    <canvas id="projectsPerCategoryChart"></canvas>
                    <div id="projectsPerCategoryEmpty" style="display:none;">
                        @include('partials.empty_state', [
                            'icon' => 'solar:pie-chart-broken-duotone',
                            'title' => 'No Category Data',
                            'description' => 'No project categories are currently represented in this dataset.'
                        ])
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12" data-aos="fade-up" data-aos-delay="300">
            <div class="card glass-panel border-0 p-4 mt-4">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2 text-dark">
                    <iconify-icon icon="solar:graph-new-bold-duotone" class="text-success fs-6"></iconify-icon>
                    Project Trends
                </h5>
                <div class="chart-container">
                    <div id="projectsTrendLoader" class="chart-loader w-100 h-100 skeleton skeleton-chart"></div>
                    <canvas id="projectsTrendChart"></canvas>
                    <div id="projectsTrendEmpty" style="display:none;">
                        @include('partials.empty_state', [
                            'icon' => 'solar:graph-broken-duotone',
                            'title' => 'No Trend Data',
                            'description' => 'Historical trends are not available for the current filter selection.'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card glass-panel border-0 p-4 mt-4" data-aos="fade-up" data-aos-delay="400">
        <h5 class="fw-bold mb-4 d-flex align-items-center gap-2 text-dark">
            <iconify-icon icon="solar:list-bold-duotone" class="text-primary fs-6"></iconify-icon>
            Recent Project Submissions
        </h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="recentProjectsTable">
                <thead>
                    <tr>
                        <th class="border-top-0">#</th>
                        <th class="border-top-0">Project Title</th>
                        <th class="border-top-0">Category</th>
                        <th class="border-top-0">Academic Year</th>
                        <th class="border-top-0">Semester</th>
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

        // Skema warna untuk grafik (Premium Palette)
        const chartColorSchemes = {
            perYear: {
                background: 'rgba(57, 106, 255, 0.7)',
                border: '#396aff'
            },
            perCategory: ['#396aff', '#00d084', '#ffbc0d', '#ff5c5c', '#8a3ffc', '#ff7eb6'],
            trend: {
                line: '#396aff',
                fill: 'rgba(57, 106, 255, 0.08)',
                point: '#396aff'
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
                            color: '#475569',
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#1e293b',
                        titleFont: {
                            size: 14,
                            weight: '700'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: true,
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
                        border: { display: false },
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11, weight: '500' }
                        }
                    },
                    x: {
                        border: { display: false },
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: { size: 11, weight: '500' }
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
