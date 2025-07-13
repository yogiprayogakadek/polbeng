@extends('front_end.template.master')

@section('page-title', 'Department')

@push('css')
    <style>
        /* Accordion Header */
        .accordion-button.custom-header {
            background: #1e88e5;
            color: white;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .accordion-button.custom-header:hover {
            background: #1565c0;
            transform: scale(1.01);
        }

        /* Accordion Item Container */
        .accordion-item {
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid #d0d7e2;
            background: linear-gradient(to bottom, #f4f9ff, #ffffff);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
        }

        /* Accordion Body */
        .accordion-body {
            background: linear-gradient(to bottom, #ffffff, #f8fbff);
            border-radius: 0 0 0.75rem 0.75rem;
            padding: 1.25rem 1.5rem;
            animation: fadeIn 0.4s ease-in-out;
        }

        /* Accordion Collapse Transition */
        .accordion-collapse {
            transition: all 0.4s ease-in-out;
        }

        /* Fade in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dark Mode */
        body.dark {
            background-color: #1a1a2e;
            color: #e6e6e6;
        }

        body.dark .accordion-button.custom-header {
            background: #0f3460;
            color: #fff;
        }

        body.dark .accordion-body {
            background: #1a1a2e;
            color: #e6e6e6;
        }

        body.dark .accordion-item {
            background: #16213e;
            border-color: #1f4068;
        }

        body.dark .text-muted {
            color: #b8b8b8 !important;
        }

        body.dark .card {
            background-color: #16213e;
            border-color: #1f4068;
        }

        /* Card Hover Effects */
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1), 0 6px 6px rgba(0, 0, 0, 0.05);
        }

        .card:hover .bg-opacity-10 {
            background-color: rgba(var(--bs-primary-rgb), 0.2) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .accordion-button.custom-header {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }

            .card-body {
                padding: 1rem;
            }

            .breadcrumb {
                font-size: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="py-5 bg-light-gray min-vh-100">
        <div class="container-fluid">
            <!-- Breadcrumbs -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="#" class="text-primary">Projects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Showcase</li>
                    </ol>
                </nav>
                <div class="ms-auto form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="darkModeToggle">
                    <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="ti ti-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search projects..." id="projectSearch">
                    </div>
                </div>
                <div class="col-md-6">
                    <select class="form-select" id="projectFilter">
                        <option value="all">All Categories</option>
                        @foreach ($studyPrograms as $program)
                            <option value="{{ $program->id }}">{{ $program->study_program_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if ($studyPrograms->isEmpty())
                <div class="card border-0 bg-light">
                    <div class="card-body text-center py-5">
                        <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data" class="img-fluid mb-4"
                            style="max-width: 200px;">
                        <h4 class="text-muted mb-3">Data not available for this department.</h4>
                    </div>
                </div>
            @else
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach ($studyPrograms as $index => $studyProgram)
                        <div class="accordion-item border-start border-4 border-primary">
                            <h2 class="accordion-header" id="flush-headingOne-{{ $studyProgram->id }}">
                                <button class="accordion-button collapsed custom-header" type="button"
                                    data-study-program-id="{{ $studyProgram->id }}"
                                    data-url="{{ route('frontend.project.total', $studyProgram->id) }}"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{ $studyProgram->id }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="flush-collapseOne-{{ $studyProgram->id }}">
                                    <iconify-icon icon="solar:folder-outline" class="me-2 fs-5 text-white"></iconify-icon>
                                    {{ $studyProgram->study_program_name }}
                                </button>
                            </h2>

                            <div id="flush-collapseOne-{{ $studyProgram->id }}"
                                class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                aria-labelledby="flush-headingOne-{{ $studyProgram->id }}"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body" id="accordion-render-{{ $studyProgram->id }}">
                                    <div class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Load content for first accordion item
            let $firstButton = $('.accordion-button').first();
            let firstUrl = $firstButton.data('url');
            let firstTargetId = 'accordion-render-' + $firstButton.data('study-program-id');
            getAccordionContent(firstUrl, firstTargetId);

            // Load content on accordion click
            $('body').on('click', '.accordion-button', function() {
                let url = $(this).data('url');
                let targetId = 'accordion-render-' + $(this).data('study-program-id');
                getAccordionContent(url, targetId);
            });

            // Search functionality
            $('#projectSearch').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                $('.accordion-item').each(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.includes(searchText));
                });
            });

            // Filter functionality
            $('#projectFilter').on('change', function() {
                const programId = $(this).val();
                if (programId === 'all') {
                    $('.accordion-item').show();
                } else {
                    $('.accordion-item').hide();
                    $(`.accordion-item [data-study-program-id="${programId}"]`).closest('.accordion-item')
                        .show();
                }
            });

            // Dark mode toggle
            $('#darkModeToggle').change(function() {
                $('body').toggleClass('dark', this.checked);
                localStorage.setItem('darkMode', this.checked);
            });

            // Check for saved dark mode preference
            if (localStorage.getItem('darkMode') === 'true') {
                $('#darkModeToggle').prop('checked', true).trigger('change');
            }
        });

        function getAccordionContent(url, targetId) {
            const $target = $('#' + targetId);
            $target.html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            $.get(url)
                .done(function(response) {
                    $target.html(response.html);
                })
                .fail(function() {
                    $target.html(`
                        <div class="alert alert-danger">
                            Failed to load content. Please try again.
                        </div>
                    `);
                });
        }
    </script>
@endpush
