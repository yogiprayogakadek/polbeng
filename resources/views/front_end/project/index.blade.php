@extends('front_end.template.master')

@section('page-title', 'Project')

@section('content')
    <section class="py-5 bg-light-gray">
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-md-nowrap flex-wrap align-items-center">
                <h2 class="fs-10 fw-bolder mb-0">Project Showcase</h2>
                <div class="d-flex align-items-center gap-2 fs-4">
                    <a href="/" class="text-muted fw-bold text-uppercase">Politeknik Negeri Bengkalis</a>
                    <iconify-icon icon="solar:alt-arrow-right-outline" class="fs-5 text-muted"></iconify-icon>
                    <a href="#" class="text-primary fw-bold text-uppercase">Projects</a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light-gray pb-10 pb-lg-14 min-vh-100">
        <div class="container-fluid">

            <div class="mb-4">
                <input type="text" id="search-project" class="form-control rounded-pill px-4 py-2 shadow-sm"
                    placeholder="Search projects...">
            </div>

            <div id="project-list" class="row g-4">
                @foreach ($projects as $project)
                    <div class="col-lg-4 col-md-6 project-item">
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
                                    <a href="{{ route('frontend.project.detail', ['slug' => Str::slug($project->project_title), 'uuid' => $project->uuid]) }}"
                                        class="btn btn-outline-primary rounded-pill px-4 py-2 shadow-sm">
                                        <i class="ti ti-eye me-1"></i> Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($projects->isEmpty())
                <div class="text-center py-7">
                    <h3 class="text-muted">There is no project data available for this category.</h3>
                </div>
            @endif

            <div class="text-center mt-5">
                <button id="load-more" class="btn btn-primary rounded-pill px-5 py-2">Load More</button>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        let page = 1;

        const projectCategoryID = '{{ $projectCategoryID }}';

        function loadMoreProjects() {
            page++;
            const query = $('#search-project').val();
            $.ajax({
                url: `/projects/filter/load-more?page=${page}&query=${query}&projectCategoryID=${projectCategoryID}`,
                method: 'GET',
                success: function(html) {
                    if ($.trim(html) !== '') {
                        const newContent = $(html).css({
                            opacity: 0,
                            transform: 'translateY(20px)'
                        });
                        $('#project-list').append(newContent);
                        newContent.animate({
                            opacity: 1,
                            transform: 'translateY(0)'
                        }, {
                            duration: 500,
                            step: function(now, fx) {
                                if (fx.prop === "transform") {
                                    $(this).css('transform', `translateY(${20 - now * 20}px)`);
                                } else {
                                    $(this).css(fx.prop, now);
                                }
                            }
                        });
                    } else {
                        $('#load-more').hide();
                    }
                }
            });
        }

        $('#load-more').on('click', function() {
            loadMoreProjects();
        });

        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                loadMoreProjects();
            }
        });

        $('#search-project').on('keyup', function() {
            const query = $(this).val();

            $.ajax({
                url: `/projects/filter/search?query=${query}&projectCategoryID=${projectCategoryID}`,
                method: 'GET',
                success: function(html) {
                    $('#project-list').html(html);
                    if ($.trim(html) === '') {
                        $('#load-more').hide();
                    } else {
                        $('#load-more').show();
                    }
                }
            });
        });
    </script>
@endpush
