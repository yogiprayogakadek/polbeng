<div class="tab-pane fade show active" id="content-{{ $departmentID }}" role="tabpanel">
    <div class="row align-items-center">
        @php
            $colors = [
                'primary',
                // 'success',
                // 'info',
                // 'danger',
                // 'warning',
                'secondary',
                'dark',
                // 'pink',
                // 'cyan',
                'indigo',
            ];
            $icons = [
                'bell',
                'rocket',
                'bulb',
                'device-desktop',
                'layers',
                'chart-bar',
                'camera',
                'palette',
                'video',
                'code',
                'settings',
                'cloud',
            ];
        @endphp
        @forelse ($totalProjects as $totalProject)
            <div class="col-lg-3 col-md-6">
                @php
                    $color = $colors[array_rand($colors)];
                    $icon = $icons[array_rand($icons)];
                @endphp
                <div
                    class="card border-start border-{{ $color }} group overflow-hidden position-relative rounded-3 shadow-sm hover-scale">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-{{ $color }} display-6">
                                <i class="ti ti-folder"></i>
                            </span>
                            <div>
                                <h2 class="fs-7 mb-1">{{ $totalProject->total }}</h2>
                                <p class="fw-medium text-{{ $color }} mb-0">
                                    {{ $totalProject->project_category_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 d-flex align-items-center justify-content-center opacity-0 group-hover-opacity-100 transition-all rounded-3">
                        <a href="{{ route('frontend.project.index', $totalProject->uuid) }}"
                            class="btn btn-gradient-primary rounded-pill px-4 py-2 shadow-lg">
                            <i class="ti ti-eye me-2"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center">Data not available for this department.</h3>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-scale:hover {
        transform: translateY(-5px) scale(1.03);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-gradient-primary {
        background: linear-gradient(45deg, #5b76f7, #845ef7);
        border: none;
        color: #fff;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(45deg, #845ef7, #5b76f7);
        box-shadow: 0 4px 15px rgba(91, 118, 247, 0.5);
    }

    .group:hover .group-hover-opacity-100 {
        opacity: 1 !important;
        transition: opacity 0.3s ease-in-out;
    }
</style>
