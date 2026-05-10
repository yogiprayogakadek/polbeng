@forelse ($projects as $project)
    <div class="col-lg-4 col-md-6 animate__animated animate__fadeInUp">
        <div class="category-card h-100 d-flex flex-column">
            <div class="position-relative" style="height: 200px; overflow: hidden;">
                @php
                    $thumbnailUrl = resolveAssetPath($project->thumbnail ?: 'assets/images/logo/main-logo.png');
                @endphp
                <img src="{{ $thumbnailUrl }}"
                    alt="{{ $project->project_title }}" class="w-100 h-100 object-fit-cover transition-all"
                    loading="lazy">
                <div class="category-badge shadow-sm">
                    <i class="ti ti-calendar me-1"></i> {{ $project->school_year }}
                </div>
            </div>
            <div class="p-4 d-flex flex-column flex-grow-1">
                <div class="mb-2 text-primary fw-bold small text-uppercase tracking-wider">
                    {{ $project->projectCategory->studyProgram->study_program_code ?? 'Project' }}
                </div>
                <h5 class="fw-bold fs-5 mb-2 text-dark">
                    {{ \Illuminate\Support\Str::limit($project->project_title, 60) }}
                </h5>
                <p class="text-muted fs-4 flex-grow-1 mb-4">
                    {{ \Illuminate\Support\Str::limit(optional($project->detail)->description, 100, '...') }}
                </p>
                <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                    <span class="small text-muted">
                        <i class="ti ti-building me-1"></i>
                        {{ $project->projectCategory->studyProgram->department->department_code ?? '' }}
                    </span>
                    <a href="{{ route('frontend.project.detail', ['slug' => Str::slug($project->project_title), 'uuid' => $project->uuid]) }}"
                        class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm transition-all">
                        View Details <i class="ti ti-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 py-5">
        @include('partials.empty_state', [
            'icon' => 'solar:minimalistic-magnifer-zoom-out-bold-duotone',
            'title' => 'No Projects Found',
            'description' => 'We couldn\'t find any projects matching your current filters. Try adjusting your search or selecting a different year.'
        ])
    </div>
@endforelse
