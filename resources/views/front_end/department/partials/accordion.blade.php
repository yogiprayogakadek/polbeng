@php
    $colors = ['blue', 'indigo', 'purple', 'primary'];
@endphp

<div class="row g-4 py-3">
    @forelse ($totalProjects as $totalProject)
        <div class="col-lg-3 col-md-4 col-sm-6">
            @php
                $color = $colors[$loop->index % count($colors)];
            @endphp
            <div class="category-card-small shadow-sm h-100 animate__animated animate__fadeInUp"
                style="animation-delay: {{ $loop->index * 0.05 }}s">
                <div class="d-flex align-items-center mb-4">
                    <div class="icon-box rounded-4 d-flex align-items-center justify-content-center me-3"
                        style="width: 54px; height: 54px; background-color: rgba(59, 130, 246, 0.1);">
                        <i class="ti ti-layers-intersect fs-3 text-primary"></i>
                    </div>
                    <div>
                        <h3 class="fs-2 fw-bold mb-0 text-dark">{{ $totalProject->total }}</h3>
                        <span class="text-muted small">Projects</span>
                    </div>
                </div>

                <h4 class="fs-6 fw-bold text-dark mb-4 lh-base" style="min-height: 2.5rem;">
                    {{ $totalProject->project_category_name }}
                </h4>

                <div class="mt-auto">
                    <a href="{{ route('frontend.project.index', $totalProject->uuid) }}"
                        class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold d-flex align-items-center justify-content-center">
                        View Discovery <i class="ti ti-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5 bg-light rounded-5 animate__animated animate__fadeIn">
                <i class="ti ti-folder-off fs-1 text-muted opacity-50 mb-3 d-block"></i>
                <h5 class="text-dark fw-bold mb-1">No Categories Found</h5>
                <p class="text-muted small">There are currently no categorised projects in this program.</p>
            </div>
        </div>
    @endforelse
</div>
