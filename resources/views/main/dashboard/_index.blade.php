@extends('template.master')

@section('page-title', 'Dashboard')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <div class="row g-4 mb-4">
        @include('main.dashboard.partials.stats')
    </div>


    <div class="row g-4 mb-4">
        <div class="d-flex justify-content-between">
            <select id="yearFilter" class="form-select w-auto">
                <option value="">All Years</option>
                @foreach ($projectsPerYear->keys() as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>

            <select id="filterCategory" class="form-select w-auto">
                <option value="">All Categories</option>
                @foreach ($projectsPerCategory as $category)
                    <option value="{{ $category->project_category_name }}">{{ $category->project_category_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow-sm rounded-4">
                <h5 class="fw-semibold mb-3">Projects Per Year</h5>
                <div style="height: 300px;">
                    <div id="projectsPerYearLoader" class="text-center my-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <canvas id="projectsPerYearChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3 shadow-sm rounded-4">
                <h5 class="fw-semibold mb-3">Projects Per Category</h5>
                <div style="height: 300px;">
                    <div id="projectsPerCategoryLoader" class="text-center my-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <canvas id="projectsPerCategoryChart"></canvas>
                    <div id="projectsPerCategoryEmpty" class="text-center my-4 text-muted"
                        style="display:none; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
                        <p>No data available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card p-3 shadow-sm rounded-4">
            <h5 class="fw-semibold mb-3">Projects Trend Over Years</h5>
            <div style="height: 300px; position: relative;">
                <div id="projectsTrendLoader" class="text-center my-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <canvas id="projectsTrendChart"></canvas>
                <div id="projectsTrendEmpty" class="text-center my-4 text-muted"
                    style="display:none; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
                    <p>No data available</p>
                </div>
            </div>
        </div>
    </div>


    <div class="card p-4 shadow rounded-4">
        <div class="d-flex gap-2 mb-3">
            <select id="recentYearFilter" class="form-select w-auto">
                <option value="">All Years</option>
                @foreach ($projectsPerYear->keys() as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>

            <select id="recentCategoryFilter" class="form-select w-auto">
                <option value="">All Categories</option>
                @foreach ($projectsPerCategory as $category)
                    <option value="{{ $category->project_category_name }}">{{ $category->project_category_name }}</option>
                @endforeach
            </select>
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
            setTimeout(() => {
                $('[id^="mini-"]').removeClass('selected');
                $('#dashboard').addClass('selected');
                $('body').attr('data-sidebartype', 'mini-sidebar');

                $('.container-fluid').css('max-width', '1500px');
            }, 1000);
            // Inisialisasi Select2
            $('#yearFilter, #filterCategory').select2({
                width: '200px',
                placeholder: 'Select Option',
                allowClear: true
            });

            let projectsPerYearChartInstance = null;
            let projectsPerCategoryChartInstance = null;

            // Load Projects Per Year Chart
            function loadProjectsPerYearChart(year = '') {
                $('#projectsPerYearLoader').show();
                $('#projectsPerYearChart').hide();

                $.ajax({
                    url: "{{ route('dashboard.projectsPerYear') }}",
                    type: "GET",
                    data: {
                        year: year
                    },
                    success: function(response) {
                        if (projectsPerYearChartInstance) {
                            projectsPerYearChartInstance.destroy();
                        }

                        const ctx = document.getElementById('projectsPerYearChart').getContext('2d');
                        projectsPerYearChartInstance = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: response.labels,
                                datasets: [{
                                    label: 'Projects',
                                    data: response.data,
                                    backgroundColor: '#3b82f6',
                                    borderRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                animation: {
                                    onComplete: () => {
                                        $('#projectsPerYearLoader').hide();
                                        $('#projectsPerYearChart').show();
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to load project chart.', 'error');
                        $('#projectsPerYearLoader').hide();
                    }
                });
            }

            // Load Projects Per Category Chart
            function loadProjectsPerCategoryChart(category = '') {
                $('#projectsPerCategoryLoader').show();
                $('#projectsPerCategoryChart').hide();
                $('#projectsPerCategoryEmpty').hide();

                $.ajax({
                    url: "{{ route('dashboard.projectsPerCategory') }}",
                    type: "GET",
                    data: {
                        category: category
                    },
                    success: function(response) {
                        if (projectsPerCategoryChartInstance) {
                            projectsPerCategoryChartInstance.destroy();
                        }

                        if (response.data.length === 0) {
                            $('#projectsPerCategoryLoader').hide();
                            $('#projectsPerCategoryEmpty').show();
                            return;
                        }

                        const ctx = document.getElementById('projectsPerCategoryChart').getContext(
                            '2d');
                        projectsPerCategoryChartInstance = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: response.labels,
                                datasets: [{
                                    data: response.data,
                                    backgroundColor: [
                                        '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
                                        '#6366f1', '#ec4899'
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                },
                                animation: {
                                    onComplete: () => {
                                        $('#projectsPerCategoryLoader').hide();
                                        $('#projectsPerCategoryChart').show();
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to load category chart.', 'error');
                        $('#projectsPerCategoryLoader').hide();
                    }
                });
            }

            // Initial Load
            loadProjectsPerYearChart();
            loadProjectsPerCategoryChart();

            // Filter Events
            $('#yearFilter').on('change', function() {
                const selectedYear = $(this).val();
                loadProjectsPerYearChart(selectedYear);
            });

            $('#filterCategory').on('change', function() {
                const selectedCategory = $(this).val();
                loadProjectsPerCategoryChart(selectedCategory);
            });

            $('#recentYearFilter, #recentCategoryFilter').on('change', function() {
                const year = $('#recentYearFilter').val();
                const category = $('#recentCategoryFilter').val();

                $.ajax({
                    url: "{{ route('dashboard.recentProjects') }}",
                    type: "GET",
                    data: {
                        year: year,
                        category: category
                    },
                    success: function(response) {
                        $('#recentProjectsTable').html(response.html);
                        toastr.success(`Data loaded successfully`, 'Data loaded', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 3000
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to load recent projects.', 'error');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let projectsTrendChart = null;

            function loadProjectsTrend(year = '') {
                $('#projectsTrendLoader').show();
                $('#projectsTrendChart').hide();
                $('#projectsTrendEmpty').hide();

                $.ajax({
                    url: "{{ route('dashboard.projectsTrend') }}",
                    type: "GET",
                    data: {
                        year: year
                    },
                    success: function(response) {
                        const ctx = document.getElementById('projectsTrendChart').getContext('2d');

                        if (projectsTrendChart !== null) {
                            projectsTrendChart.destroy();
                        }

                        if (response.data.length === 0) {
                            $('#projectsTrendLoader').hide();
                            $('#projectsTrendEmpty').show();
                            return;
                        }

                        projectsTrendChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: response.labels,
                                datasets: [{
                                    label: 'Projects',
                                    data: response.data,
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59,130,246,0.2)',
                                    tension: 0.3,
                                    fill: true,
                                    pointRadius: 4,
                                    pointBackgroundColor: '#3b82f6'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                animation: {
                                    onComplete: () => {
                                        $('#projectsTrendLoader').hide();
                                        $('#projectsTrendChart').show();
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to load project trends.', 'error');
                        $('#projectsTrendLoader').hide();
                    }
                });
            }

            loadProjectsTrend();
        });
    </script>
@endpush
