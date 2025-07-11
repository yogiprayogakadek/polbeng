@foreach ($projects as $project)
    <div class="col-lg-4 col-md-6">
        <div class="card shadow-sm border-0 rounded-4 h-100 overflow-hidden">
            <div class="ratio ratio-16x9">
                <img src="{{ $project->thumbnail ? asset('storage/' . $project->thumbnail) : asset('assets/images/logo/main-logo.png') }}"
                    alt="{{ $project->project_name }}" class="object-fit-cover w-100 h-100 rounded-top-4">
            </div>
            <div class="card-body d-flex flex-column">
                <div class="mb-3 d-flex flex-wrap align-items-center text-muted fs-5">
                    <div class="me-3 d-flex align-items-center">
                        <i class="ti ti-calendar me-1"></i>
                        {{ $project->school_year }}
                    </div>
                    <div class="ms-auto d-flex align-items-center text-truncate">
                        <i class="ti ti-message-circle me-1"></i>
                        {{ $project->projectCategory->studyProgram->department->department_code ?? '' }} -
                        {{ $project->projectCategory->studyProgram->study_program_code ?? '' }}
                    </div>
                </div>

                <h5 class="fw-semibold fs-5 mb-2 text-dark">
                    {{ \Illuminate\Support\Str::limit($project->project_title, 60) }}
                </h5>
                <p class="text-muted fs-4 flex-grow-1">
                    {{ \Illuminate\Support\Str::limit(optional($project->detail)->description, 80, '...') }}
                </p>

                <div class="mt-3 text-end">
                    <a href="{{ url('/projects/detail/' . $project->id) }}"
                        class="btn btn-outline-primary rounded-pill px-4 py-2 shadow-sm">
                        <i class="ti ti-eye me-1"></i> Read More
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
