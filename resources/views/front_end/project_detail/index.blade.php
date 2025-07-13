@extends('front_end.template.master')

@section('page-title', 'Project Detail')

@push('css')
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .project-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .member-badge {
            transition: all 0.2s ease;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .member-badge:hover {
            background-color: #f8f9fa !important;
            transform: scale(1.05);
        }

        .video-btn {
            transition: all 0.3s ease;
            border-radius: 8px;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .video-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }

        .video-btn i {
            transition: transform 0.3s ease;
        }

        .video-btn:hover i {
            transform: scale(1.2);
        }

        .gallery-img {
            transition: all 0.3s ease;
            border-radius: 8px;
            cursor: pointer;
        }

        .gallery-img:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border-radius: 3px;
        }

        .accordion-button:not(.collapsed) {
            color: #3b82f6;
            background-color: transparent;
        }

        .poster-container {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .poster-container img {
            transition: transform 0.5s ease;
        }

        .poster-container:hover img {
            transform: scale(1.03);
        }

        .project-card .position-relative:hover img {
            transform: scale(1.05);
        }

        .project-card .position-relative:hover div {
            opacity: 1 !important;
        }

        .object-fit-cover {
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    {{-- HERO SECTION --}}
    <section class="position-relative py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);">
        <div class="container">
            <div class="row justify-content-center animate__animated animate__fadeIn">
                <div class="col-lg-10">
                    <div class="project-card shadow-lg">
                        <div class="card-body px-4 px-lg-5 py-4">
                            <div class="d-flex align-items-center mb-3">
                                <span
                                    class="badge bg-primary me-2 fs-6">{{ $project->projectCategory->project_category_name }}</span>
                                <span class="text-muted">{{ $project->school_year }} • Semester
                                    {{ $project->semester }}</span>
                            </div>

                            <h1 class="display-5 fw-bold text-dark mb-4">{{ $project->project_title }}</h1>

                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-users fs-4 text-primary me-2"></i>
                                    <span class="fw-medium">Team Members:</span>
                                </div>
                                @php
                                    $members = json_decode($project->detail->members, true);
                                @endphp
                                @foreach ($members as $member)
                                    <span
                                        class="member-badge badge text-bg-light text-dark fs-6 fw-medium px-3 py-2 rounded-pill">
                                        {{ $member['student_id_number'] }} - {{ $member['student_name'] }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- DESCRIPTION & VIDEO SECTION --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center animate__animated animate__fadeInUp">
                <div class="col-lg-10">
                    <div class="project-card shadow-sm">
                        <div class="card-body px-4 px-lg-5 py-4">
                            {{-- DESCRIPTION - Accordion --}}
                            <div class="mb-5">
                                <h2 class="section-title fs-5 fw-bold text-dark mb-4">Project Description</h2>
                                <div class="accordion" id="descriptionAccordion">
                                    <div class="accordion-item border-0 bg-transparent">
                                        <div id="descCollapse" class="accordion-collapse collapse show">
                                            <div class="accordion-body pt-3 px-0">
                                                <div class="text-muted lh-lg" style="text-align: justify;">
                                                    {!! nl2br(e($project->detail->description)) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- VIDEOS --}}
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <h2 class="section-title fs-5 fw-bold text-dark mb-4">Demo Video / Trailer</h2>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ toEmbedUrl($project->detail->video_trailer_url) }}"
                                            class="video-btn btn btn-primary btn-lg glightbox-video d-inline-flex align-items-center"
                                            data-gallery="video-trailer" data-type="video" data-width="1280"
                                            title="Trailer">
                                            <i class="ti ti-play-circle fs-4 me-2"></i> Watch Trailer
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h2 class="section-title fs-5 fw-bold text-dark mb-4">Presentation Video</h2>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ toEmbedUrl($project->detail->presentation_video_url) }}"
                                            class="video-btn btn btn-outline-primary btn-lg glightbox-video d-inline-flex align-items-center"
                                            data-gallery="video-presentation" data-type="video" data-width="1280"
                                            title="Presentation">
                                            <i class="ti ti-presentation fs-4 me-2"></i> Watch Presentation
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- GALLERY & POSTER SECTION --}}
    <section class="py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);">
        <div class="container">
            <div class="row justify-content-center g-4 animate__animated animate__fadeInUp">
                <div class="col-lg-8 order-lg-1 order-2">
                    <div class="project-card shadow-sm h-100">
                        <div class="card-body px-4 px-lg-5 py-4">
                            <h2 class="section-title fs-5 fw-bold text-dark mb-4">Project Gallery</h2>
                            @if ($project->detail->galleries->count() > 0)
                                <div class="row g-3">
                                    @foreach ($project->detail->galleries as $gallery)
                                        <div class="col-6 col-md-4">
                                            <a href="{{ asset('storage/' . $gallery->image_path) }}"
                                                class="glightbox d-block" data-gallery="project-gallery"
                                                data-title="{{ $project->project_title }}">
                                                <img src="{{ asset('storage/' . $gallery->image_path) }}"
                                                    class="gallery-img w-100 shadow-sm"
                                                    style="height: 180px; object-fit: cover;"
                                                    alt="Gallery Image {{ $loop->iteration }}" loading="lazy">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <img src="{{ asset('assets/images/empty-state.svg') }}" alt="No galleries"
                                        class="img-fluid mb-3" style="max-width: 300px;">
                                    <h4 class="text-muted">No galleries available</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 order-lg-2 order-1">
                    <div class="project-card shadow-sm h-100">
                        <div class="card-body px-4 px-lg-5 py-4">
                            <h2 class="section-title fs-5 fw-bold text-dark mb-4">Project Poster</h2>
                            <div class="poster-container">
                                <img src="{{ asset('storage/' . $project->detail->poster_path) }}" class="w-100 rounded"
                                    alt="Project Poster" loading="lazy">
                            </div>
                            <div class="mt-3 text-center">
                                <a href="{{ asset('storage/' . $project->detail->poster_path) }}"
                                    class="btn btn-sm btn-outline-primary glightbox"
                                    data-title="{{ $project->project_title }}">
                                    <i class="ti ti-zoom-in me-1"></i> View Full Size
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RELATED PROJECTS --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @if ($relatedProjects->count() > 0)
                        <h2 class="section-title fs-5 fw-bold text-dark mb-4">Related Projects</h2>
                        <div class="row g-4">
                            @foreach ($relatedProjects as $related)
                                <div class="col-md-4">
                                    <div class="project-card shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <div class="position-relative mb-3"
                                                style="height: 180px; overflow: hidden; border-radius: 8px;">
                                                <img src="{{ asset('storage/' . $related->thumbnail) }}"
                                                    class="w-100 h-100 object-fit-cover"
                                                    alt="{{ $related->project_title }}"
                                                    style="transition: transform 0.5s ease;">
                                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                                    style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s ease;">
                                                    <a href="{{ route('frontend.project.detail', ['slug' => Str::slug($related->project_title), 'uuid' => $related->uuid]) }}"
                                                        class="btn btn-sm btn-primary">
                                                        View Project
                                                    </a>
                                                </div>
                                            </div>
                                            <h3 class="fs-6 fw-bold mb-2 text-truncate">{{ $related->project_title }}</h3>
                                            <div class="d-flex align-items-center text-muted small">
                                                <span>{{ $related->school_year }}</span>
                                                <span class="mx-2">•</span>
                                                <span>{{ $related->semester }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <img src="{{ asset('assets/images/empty-state-2.svg') }}" alt="No related projects"
                                class="img-fluid mb-3" style="max-width: 250px;">
                            <h4 class="text-muted">No related projects found</h4>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize GLightbox for images
            const lightboxImages = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                zoomable: true,
                openEffect: 'fade',
                closeEffect: 'fade',
                onOpen: () => {
                    document.body.style.overflow = 'hidden';
                },
                onClose: () => {
                    document.body.style.overflow = '';
                }
            });

            // Initialize GLightbox for videos
            const lightboxVideos = GLightbox({
                selector: '.glightbox-video',
                touchNavigation: true,
                loop: false
            });

            // Add animation to elements when they come into view
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.animate__animated');
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;

                    if (elementPosition < windowHeight - 100) {
                        const animation = element.getAttribute('class').split('animate__')[1];
                        element.classList.add(`animate__${animation}`);
                    }
                });
            };

            // Run once on load
            animateOnScroll();

            // Run on scroll
            window.addEventListener('scroll', animateOnScroll);
        });
    </script>
@endpush
