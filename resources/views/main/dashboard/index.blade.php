@extends('template.master')

@section('page-title', 'Dashboard')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --purple: #6366f1;
            --pink: #ec4899;
        }

        .card {
            transition: all 0.3s ease;
            border: none;
            background-color: #fff;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            height: 300px;
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
            color: #6c757d;
        }

        canvas {
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        canvas.show {
            opacity: 1;
        }

        .filter-card {
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row g-4 mb-4">
        @include('main.dashboard.partials.stats')
    </div>

    <!-- Unified Filter Section -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card p-3 shadow-sm rounded-4 filter-card">
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <div>
                        <label class="form-label">Year</label>
                        <select id="yearFilter" class="form-select">
                            <option value="">All Years</option>
                            @foreach ($projectsPerYear->keys() as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Category</label>
                        <select id="filterCategory" class="form-select">
                            <option value="">All Categories</option>
                            @foreach ($projectsPerCategory as $category)
                                <option value="{{ $category->project_category_name }}">
                                    {{ $category->project_category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Per Year Chart -->
        <div class="col-xl-6">
            <div class="card p-3 shadow-sm rounded-4 h-100">
                <h5 class="fw-semibold mb-3">Projects Per Year</h5>
                <div class="chart-container">
                    <div id="projectsPerYearLoader" class="chart-loader">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <canvas id="projectsPerYearChart"></canvas>
                    <div id="projectsPerYearEmpty" class="chart-empty" style="display:none;">
                        <i class="ti ti-alert-circle fs-4"></i>
                        <p class="mt-2">No data available</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Per Category Chart -->
        <div class="col-xl-6">
            <div class="card p-3 shadow-sm rounded-4 h-100">
                <h5 class="fw-semibold mb-3">Projects Per Category</h5>
                <div class="chart-container">
                    <div id="projectsPerCategoryLoader" class="chart-loader">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <canvas id="projectsPerCategoryChart"></canvas>
                    <div id="projectsPerCategoryEmpty" class="chart-empty" style="display:none;">
                        <i class="ti ti-alert-circle fs-4"></i>
                        <p class="mt-2">No data available</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Trend Chart -->
        <div class="col-12">
            <div class="card p-3 shadow-sm rounded-4 mt-4">
                <h5 class="fw-semibold mb-3">Projects Trend Over Years</h5>
                <div class="chart-container">
                    <div id="projectsTrendLoader" class="chart-loader">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                    <canvas id="projectsTrendChart"></canvas>
                    <div id="projectsTrendEmpty" class="chart-empty" style="display:none;">
                        <i class="ti ti-alert-circle fs-4"></i>
                        <p class="mt-2">No data available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Projects Table -->
    <div class="card p-4 shadow rounded-4 mt-4">
        <div class="d-flex flex-wrap gap-3 align-items-center mb-3">
            <div>
                <label class="form-label">Year</label>
                <select id="recentYearFilter" class="form-select">
                    <option value="">All Years</option>
                    @foreach ($projectsPerYear->keys() as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Category</label>
                <select id="recentCategoryFilter" class="form-select">
                    <option value="">All Categories</option>
                    @foreach ($projectsPerCategory as $category)
                        <option value="{{ $category->project_category_name }}">{{ $category->project_category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <h5 class="fw-semibold mb-3">Recent Projects</h5>
        <div class="table-responsive">
            <table class="table" id="recentProjectsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Project Title</th>
                        <th>Category</th>
                        <th>School Year</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentProjects as $index => $project)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $project->project_title }}</td>
                            <td>{{ $project->projectCategory->project_category_name ?? '-' }}</td>
                            <td>{{ $project->school_year }}</td>
                            <td><span class="badge bg-primary">{{ $project->semester }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize dashboard
            initDashboard();

            // Initialize sidebar (if needed)
            setTimeout(() => {
                $('[id^="mini-"]').removeClass('selected');
                $('#dashboard').addClass('selected');
                $('body').attr('data-sidebartype', 'mini-sidebar');
                $('.container-fluid').css('max-width', '1500px');
            }, 1000);
        });

        // Global chart instances
        const charts = {
            perYear: null,
            perCategory: null,
            trend: null
        };

        // Color schemes for different charts
        const chartColorSchemes = {
            perYear: {
                background: 'rgba(59, 130, 246, 0.8)',
                border: '#3b82f6'
            },
            perCategory: [
                '#3b82f6', '#10b981', '#f59e0b',
                '#ef4444', '#6366f1', '#ec4899'
            ],
            trend: {
                line: '#3b82f6',
                fill: 'rgba(59, 130, 246, 0.2)',
                point: '#3b82f6'
            }
        };

        // Initialize all dashboard components
        function initDashboard() {
            // Initialize Select2
            $('.form-select').select2({
                width: '100%',
                minimumResultsForSearch: 10
            });

            // Load initial charts
            loadProjectsPerYearChart();
            loadProjectsPerCategoryChart();
            loadProjectsTrend();

            // Setup filter event handlers
            setupFilterHandlers();
        }

        // Setup filter event handlers
        function setupFilterHandlers() {
            // Unified filter handler for charts
            $('#yearFilter, #filterCategory').on('change', function() {
                const year = $('#yearFilter').val();
                const category = $('#filterCategory').val();

                loadProjectsPerYearChart(year);
                loadProjectsPerCategoryChart(category);
                loadProjectsTrend(year);
            });

            // Filter handler for recent projects table
            $('#recentYearFilter, #recentCategoryFilter').on('change', function() {
                const year = $('#recentYearFilter').val();
                const category = $('#recentCategoryFilter').val();
                filterRecentProjects(year, category);
            });
        }

        // Load Projects Per Year Chart (Blue)
        function loadProjectsPerYearChart(year = '') {
            showLoader('projectsPerYear');

            $.ajax({
                url: "{{ route('dashboard.projectsPerYear') }}",
                type: "GET",
                data: {
                    year: year
                },
                success: function(response) {
                    if (charts.perYear) charts.perYear.destroy();

                    const ctx = document.getElementById('projectsPerYearChart').getContext('2d');
                    charts.perYear = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Projects',
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
                error: function() {
                    showError('Failed to load projects per year data');
                    hideLoader('projectsPerYear');
                }
            });
        }

        // Load Projects Per Category Chart (Multi-color)
        function loadProjectsPerCategoryChart(category = '') {
            showLoader('projectsPerCategory');

            $.ajax({
                url: "{{ route('dashboard.projectsPerCategory') }}",
                type: "GET",
                data: {
                    category: category
                },
                success: function(response) {
                    if (charts.perCategory) charts.perCategory.destroy();

                    const ctx = document.getElementById('projectsPerCategoryChart').getContext('2d');
                    charts.perCategory = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                data: response.data,
                                backgroundColor: chartColorSchemes.perCategory,
                                borderColor: '#fff',
                                borderWidth: 1
                            }]
                        },
                        options: getChartOptions('pie')
                    });

                    handleChartResponse('projectsPerCategory', response.data.length > 0);
                },
                error: function() {
                    showError('Failed to load projects per category data');
                    hideLoader('projectsPerCategory');
                }
            });
        }

        // Load Projects Trend Chart (Blue with gradient)
        function loadProjectsTrend(year = '') {
            showLoader('projectsTrend');

            $.ajax({
                url: "{{ route('dashboard.projectsTrend') }}",
                type: "GET",
                data: {
                    year: year
                },
                success: function(response) {
                    if (charts.trend) charts.trend.destroy();

                    const ctx = document.getElementById('projectsTrendChart').getContext('2d');
                    charts.trend = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Projects',
                                data: response.data,
                                borderColor: chartColorSchemes.trend.line,
                                backgroundColor: chartColorSchemes.trend.fill,
                                tension: 0.3,
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
                error: function() {
                    showError('Failed to load projects trend data');
                    hideLoader('projectsTrend');
                }
            });
        }

        // Filter Recent Projects Table
        function filterRecentProjects(year = '', category = '') {
            $.ajax({
                url: "{{ route('dashboard.recentProjects') }}",
                type: "GET",
                data: {
                    year: year,
                    category: category
                },
                success: function(response) {
                    $('#recentProjectsTable tbody').html(response.html);
                    showToast('Data loaded successfully', 'success');
                },
                error: function() {
                    showError('Failed to load recent projects');
                }
            });
        }

        // Helper function to get chart options
        function getChartOptions(type) {
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: type === 'pie' ? 'bottom' : 'top',
                        labels: {
                            color: '#000000',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            color: '#000000'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: {
                            color: '#000000'
                        }
                    }
                }
            };

            return commonOptions;
        }

        // Helper function to show loader
        function showLoader(chartId) {
            $(`#${chartId}Loader`).show();
            $(`#${chartId}Chart`).hide();
            $(`#${chartId}Empty`).hide();
        }

        // Helper function to hide loader and show chart/empty state
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

        // Helper function to show error message
        function showError(message) {
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error',
                confirmButtonColor: '#3b82f6'
            });
        }

        // Helper function to show toast
        function showToast(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: type,
                title: message,
                background: '#fff',
                color: '#000'
            });
        }
    </script>
@endpush
