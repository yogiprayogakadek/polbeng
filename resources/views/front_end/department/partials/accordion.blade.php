@php
    $colors = ['primary', 'secondary', 'dark', 'indigo'];
    $icons = ['bell', 'rocket', 'bulb', 'device-desktop', 'layers', 'chart-bar'];
@endphp

<div class="row align-items-center py-3 px-4">
    @forelse ($totalProjects as $totalProject)
        <div class="col-lg-3 col-md-6 pt-3">
            @php
                $color = $colors[array_rand($colors)];
                $icon = $icons[array_rand($icons)];
            @endphp
            <div class="card border-start border-{{ $color }} border-3 h-100 hover-scale">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-{{ $color }} bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="ti ti-{{ $icon }} fs-4 text-{{ $color }}"></i>
                        </div>
                        <div>
                            <h3 class="fs-2 fw-bold mb-0">{{ $totalProject->total }}</h3>
                            <span class="text-muted small">Total Projects</span>
                        </div>
                    </div>
                    <h4 class="fw-semibold text-{{ $color }} mb-3">{{ $totalProject->project_category_name }}</h4>
                    <div class="progress mt-2" style="height: 6px;">
                        <div class="progress-bar bg-{{ $color }}" role="progressbar"
                            style="width: {{ min(100, $totalProject->total) }}%">
                        </div>
                    </div>
                    <div class="mt-auto pt-3">
                        <a href="{{ route('frontend.project.index', $totalProject->uuid) }}"
                            class="btn btn-sm btn-{{ $color }} stretched-link">
                            View Details <i class="ti ti-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 bg-light">
                <div class="card-body text-center py-5">
                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No projects" class="img-fluid mb-4"
                        style="max-width: 200px;">
                    <h4 class="text-muted mb-3">No projects found</h4>
                    <p class="text-muted mb-4">There are currently no projects available in this category.</p>
                    <a href="#" class="btn btn-primary">
                        <i class="ti ti-plus me-1"></i> Create New Project
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>
