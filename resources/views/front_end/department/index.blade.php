@extends('front_end.template.master')

@section('page-title', 'Department')

@push('css')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        .hero-section {
            position: relative;
            padding: 80px 0 60px;
            overflow: hidden;
            background: #f8fafc;
        }

        .hero-bg-blur {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://images.unsplash.com/photo-1541339907198-e08756ebafe3?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
            filter: blur(80px) saturate(1.5) opacity(0.2);
            transform: scale(1.1);
            z-index: 0;
        }

        .accordion-item {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 24px !important;
            border: 1px solid var(--glass-border) !important;
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        }

        .accordion-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 24px;
            padding: 2px;
            background: var(--primary-gradient);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0.15;
            pointer-events: none;
        }

        .accordion-button.custom-header {
            background: transparent !important;
            color: #1e293b !important;
            font-weight: 700;
            font-size: 1.25rem;
            padding: 1.75rem 2rem;
            border: none !important;
            box-shadow: none !important;
            transition: all 0.3s ease;
        }

        .accordion-button:not(.collapsed) {
            color: #3b82f6 !important;
            padding-bottom: 1rem;
        }

        .accordion-button::after {
            filter: grayscale(1) brightness(0.5);
            transform: scale(1.2);
        }

        .accordion-body {
            background: rgba(255, 255, 255, 0.3);
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 2rem;
            animation: fadeIn 0.5s ease;
        }

        .filter-pill {
            padding: 10px 24px;
            border-radius: 100px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            background: white;
            color: #64748b;
            font-weight: 600;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .filter-pill.active {
            background: var(--primary-gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
        }

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

        .category-card-small {
            background: white;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            padding: 1.5rem;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .category-card-small:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            border-color: rgba(59, 130, 246, 0.1);
        }
    </style>
@endpush

@section('content')
    {{-- HERO SECTION --}}
    <section class="hero-section">
        <div class="hero-bg-blur"></div>
        <div class="container position-relative z-1">
            <nav aria-label="breadcrumb" class="mb-5 animate__animated animate__fadeInDown">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.homepage') }}">Home</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">Departments & Programs</li>
                </ol>
            </nav>

            <div class="row align-items-center g-4 animate__animated animate__fadeIn">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold text-dark mb-4 tracking-tight">
                        Academic Departments
                    </h1>
                    <p class="fs-5 text-muted mb-5 lh-lg">
                        Explore the diverse range of study programs and innovative projects being developed across our engineering and technology departments.
                    </p>

                    <div class="row g-4 mb-5">
                        <div class="col-sm-8">
                            <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden border">
                                <span class="input-group-text bg-white border-end-0 ps-4">
                                    <i class="ti ti-search text-muted"></i>
                                </span>
                                <input type="text" id="projectSearch" class="form-control border-start-0 ps-2 py-3 fs-5"
                                    placeholder="Search programs...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-7 bg-white min-vh-100 position-relative"
        style="margin-top: -30px; border-radius: 40px 40px 0 0; z-index: 2; box-shadow: 0 -20px 40px rgba(0,0,0,0.02);">
        <div class="container">
            @if ($studyPrograms->isEmpty())
                <div class="text-center py-10">
                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No data" class="img-fluid mb-4"
                        style="max-width: 300px;">
                    <h3 class="text-dark fw-bold mb-2">No Programs Found</h3>
                    <p class="text-muted">We couldn't find any study programs for this department yet.</p>
                </div>
            @else
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    @foreach ($studyPrograms as $index => $studyProgram)
                        <div class="accordion-item animate__animated animate__fadeInUp"
                            style="animation-delay: {{ $index * 0.1 }}s">
                            <h2 class="accordion-header" id="flush-headingOne-{{ $studyProgram->id }}">
                                <button class="accordion-button collapsed custom-header d-flex align-items-center"
                                    type="button" data-study-program-id="{{ $studyProgram->id }}"
                                    data-url="{{ route('frontend.project.total', $studyProgram->id) }}"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{ $studyProgram->id }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="flush-collapseOne-{{ $studyProgram->id }}">
                                    <div class="icon-shape bg-light-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 48px; height: 48px; background-color: rgba(59, 130, 246, 0.1);">
                                        <i class="ti ti-school fs-4"></i>
                                    </div>
                                    <span>{{ $studyProgram->study_program_name }}</span>
                                    <span class="ms-auto me-3 badge bg-light text-muted rounded-pill fs-6 fw-normal">
                                        {{ $studyProgram->department->department_name ?? 'N/A' }}
                                    </span>
                                </button>
                            </h2>

                            <div id="flush-collapseOne-{{ $studyProgram->id }}"
                                class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                aria-labelledby="flush-headingOne-{{ $studyProgram->id }}"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body" id="accordion-render-{{ $studyProgram->id }}">
                                    <div class="text-center py-5">
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
            if($firstButton.length) {
                let firstUrl = $firstButton.data('url');
                let firstTargetId = 'accordion-render-' + $firstButton.data('study-program-id');
                getAccordionContent(firstUrl, firstTargetId);
            }

            // Load content on accordion click
            $('body').on('click', '.accordion-button', function() {
                let url = $(this).data('url');
                let targetId = 'accordion-render-' + $(this).data('study-program-id');
                getAccordionContent(url, targetId);
            });

            // Search functionality - refined for premium cards
            $('#projectSearch').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                $('.accordion-item').each(function() {
                    const text = $(this).find('.accordion-button span').text().toLowerCase();
                    if (text.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });

        function getAccordionContent(url, targetId) {
            const $target = $('#' + targetId);
            
            // Prevent redundant loading
            if ($target.hasClass('content-loaded')) return;

            $.get(url)
                .done(function(response) {
                    $target.html(response.html).addClass('content-loaded');
                })
                .fail(function() {
                    $target.html(`
                        <div class="alert alert-soft-danger rounded-4 py-4 text-center">
                            <i class="ti ti-exclamation-circle fs-2 mb-2 d-block"></i>
                            <p class="mb-0 fw-semibold">Failed to load content. Please reload the page.</p>
                        </div>
                    `);
                });
        }
    </script>
@endpush
