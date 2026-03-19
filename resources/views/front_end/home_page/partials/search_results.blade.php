@if ($projects->count() > 0)
    <div class="list-group list-group-flush bg-transparent">
        @foreach ($projects as $project)
            <a href="{{ route('frontend.project.detail', ['slug' => Str::slug($project->project_title), 'uuid' => $project->uuid]) }}"
                class="list-group-item list-group-item-action search-result-item py-3 px-4 d-flex align-items-center gap-3">
                <div class="flex-shrink-0 shadow-sm border" style="width: 64px; height: 48px; overflow: hidden; border-radius: 8px;">
                    <img src="{{ $project->thumbnail ? asset('storage/' . $project->thumbnail) : asset('assets/images/logo/main-logo.png') }}"
                        class="w-100 h-100 object-fit-cover" alt="{{ $project->project_title }}">
                </div>
                <div class="flex-grow-1 min-width-0">
                    <h6 class="mb-1 text-dark fw-bold text-truncate">{{ $project->project_title }}</h6>
                    <div class="small d-flex align-items-center gap-2">
                        <span class="badge bg-light-primary text-primary fw-bold px-2 py-1 rounded-pill" style="font-size: 0.7rem;">
                            {{ $project->projectCategory->project_category_name }}
                        </span>
                        <span class="text-muted d-none d-sm-inline">•</span>
                        <span class="text-muted text-truncate d-none d-sm-inline" style="font-size: 0.8rem;">
                            {{ $project->projectCategory->studyProgram->department->department_name }}
                        </span>
                    </div>
                </div>
                <div class="flex-shrink-0 opacity-25">
                    <i class="ti ti-chevron-right fs-5"></i>
                </div>
            </a>
        @endforeach
        <div class="list-group-item p-3 text-center bg-light-gray border-top-0">
            <span class="small text-muted text-uppercase tracking-wider fw-bold" style="font-size: 0.65rem;">End of results</span>
        </div>
    </div>
@else
    <div class="p-5 text-center bg-transparent">
        <div class="icon-box bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 64px; height: 64px; background-color: rgba(59, 130, 246, 0.1);">
            <i class="ti ti-search-off fs-1"></i>
        </div>
        <h5 class="text-dark fw-bold mb-1">No matches found</h5>
        <p class="mb-0 text-muted small px-4">We couldn't find any projects matching your search term.</p>
    </div>
@endif
