@extends('front_end.template.master')

@section('page-title', 'Project Detail')

@push('css')
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        .hero-section {
            position: relative;
            padding: 100px 0 60px;
            overflow: hidden;
            background: #f8fafc;
        }

        .hero-bg-blur {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover;
            background-position: center;
            filter: blur(80px) saturate(1.5) opacity(0.25);
            transform: scale(1.1);
            z-index: 0;
        }

        .project-card {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 24px;
            border: 1px solid var(--glass-border);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            z-index: 1;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        .project-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
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

        .member-badge {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.5) !important;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(59, 130, 246, 0.1);
            color: #1e293b !important;
        }

        .member-badge:hover {
            background: white !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .video-btn {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 16px;
            padding: 16px 32px;
            font-weight: 600;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }

        .video-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.2);
        }

        .gallery-img {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 20px;
            cursor: pointer;
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .gallery-img:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            position: relative;
            padding-bottom: 16px;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        .poster-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            background: #fff;
            padding: 10px;
        }

        .poster-container img {
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
        }

        .poster-container:hover img {
            transform: scale(1.03);
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: #94a3b8;
        }

        .breadcrumb-item a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: #3b82f6;
        }
    </style>
@endpush

@section('content')
    {{-- HERO SECTION --}}
    <section class="hero-section">
        @php
            $heroThumbnail = resolveAssetPath($project->thumbnail ?: 'assets/images/logo/main-logo.png');
        @endphp
        <div class="hero-bg-blur"
            style="background-image: url('{{ $heroThumbnail }}');">
        </div>
        <div class="container position-relative z-1">
            <nav aria-label="breadcrumb" class="mb-5 animate__animated animate__fadeInDown">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('frontend.homepage') }}">Home</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('frontend.project.index', $project->projectCategory->uuid) }}">Project
                            Categories</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold" aria-current="page">
                        {{ \Illuminate\Support\Str::limit($project->project_title, 40) }}</li>
                </ol>
            </nav>

            <div class="row justify-content-center animate__animated animate__fadeIn">
                <div class="col-lg-12">
                    <div class="project-card">
                        <div class="card-body p-4 p-lg-5">
                            <div class="row g-4 align-items-center">
                                <div class="col-lg-8">
                                    <div class="d-flex align-items-center mb-4 gap-2">
                                        <span class="badge bg-primary px-3 py-2 rounded-pill fs-6 shadow-sm">
                                            <i class="ti ti-category me-1"></i>
                                            {{ $project->projectCategory->project_category_name }}
                                        </span>
                                        <span
                                            class="badge bg-white text-primary border border-info px-3 py-2 rounded-pill fs-6 shadow-sm">
                                            <i class="ti ti-calendar me-1"></i> {{ $project->school_year }}
                                        </span>
                                    </div>

                                    <h1 class="display-4 fw-bold text-dark mb-4 tracking-tight">
                                        {{ $project->project_title }}
                                    </h1>

                                    <div class="d-flex flex-wrap gap-4 align-items-center text-muted">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="icon-shape bg-light-primary text-primary rounded-circle p-3 d-flex align-items-center justify-content-center"
                                                style="width: 48px; height: 48px; background-color: rgba(59, 130, 246, 0.1);">
                                                <i class="ti ti-building fs-5"></i>
                                            </div>
                                            <div>
                                                <div class="small text-uppercase tracking-wider fw-bold">Department</div>
                                                <div class="text-dark fw-semibold">
                                                    {{ $project->projectCategory?->studyProgram?->department->department_name ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="icon-shape bg-light-purple text-purple rounded-circle p-3 d-flex align-items-center justify-content-center"
                                                style="width: 48px; height: 48px; background-color: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                                                <i class="ti ti-school fs-5"></i>
                                            </div>
                                            <div>
                                                <div class="small text-uppercase tracking-wider fw-bold">Study Program</div>
                                                <div class="text-dark fw-semibold">
                                                    {{ $project->projectCategory?->studyProgram?->study_program_name ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="p-4 rounded-4 bg-white shadow-sm border h-100">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <i class="ti ti-users fs-4 text-primary"></i>
                                            <span class="fw-bold text-dark text-uppercase tracking-wider small">Team
                                                Members</span>
                                        </div>
                                        @php
                                            $members = json_decode($project->detail->members, true);
                                        @endphp
                                        <div class="d-flex flex-column gap-2">
                                            @foreach ($members as $member)
                                                <div class="member-badge p-2 rounded-3 d-flex align-items-center gap-2">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center small"
                                                        style="width: 24px; height: 24px; font-size: 10px;">
                                                        {{ strtoupper(substr($member['student_name'], 0, 1)) }}
                                                    </div>
                                                    <div class="text-truncate small fw-medium">
                                                        {{ $member['student_name'] }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- DESCRIPTION & VIDEO SECTION --}}
    <section class="py-5 bg-white position-relative">
        <div class="container animate__animated animate__fadeInUp">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-12">
                    <div class="project-card">
                        <div class="card-body p-4 p-lg-5">
                            <div class="row g-5">
                                <div class="col-lg-7">
                                    <h2 class="section-title fs-4 fw-bold text-dark mb-4">Project Description</h2>
                                    <div class="text-muted lh-lg fs-5" style="text-align: justify;">
                                        {!! nl2br(e($project->detail->description)) !!}
                                    </div>

                                    <div class="mt-5 pt-4 border-top">
                                        <h2 class="section-title fs-4 fw-bold text-dark mb-4">Live Discovery</h2>
                                        <div class="row g-3">
                                            @if($project->detail->video_trailer_url)
                                            <div class="col-sm-6">
                                                <a href="{{ toEmbedUrl($project->detail->video_trailer_url) }}"
                                                    class="video-btn btn btn-primary w-100 glightbox-video shadow-sm"
                                                    data-gallery="video-trailer" data-type="video">
                                                    <i class="ti ti-play-circle fs-4"></i> Watch Trailer
                                                </a>
                                            </div>
                                            @endif
                                            @if($project->detail->presentation_video_url)
                                            <div class="col-sm-6">
                                                <a href="{{ toEmbedUrl($project->detail->presentation_video_url) }}"
                                                    class="video-btn btn btn-outline-primary w-100 glightbox-video shadow-sm"
                                                    data-gallery="video-presentation" data-type="video">
                                                    <i class="ti ti-presentation fs-4"></i> Presentation
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <h2 class="section-title fs-4 fw-bold text-dark mb-4">Project Poster</h2>
                                    @if($project->detail->poster_path)
                                    @php
                                        $posterPath = resolveAssetPath($project->detail->poster_path);
                                    @endphp
                                    <div class="poster-container mb-3">
                                        <a href="{{ $posterPath }}" class="glightbox" data-gallery="project-poster">
                                            <img src="{{ $posterPath }}" 
                                                class="w-100 h-100 object-fit-cover"
                                                alt="Project Poster" loading="lazy">
                                        </a>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{ $posterPath }}"
                                            class="btn btn-sm btn-light text-primary rounded-pill px-4 fw-bold glightbox"
                                            data-gallery="project-poster">
                                            <i class="ti ti-zoom-in me-1"></i> Expand Poster
                                        </a>
                                    </div>
                                    @else
                                    <div class="text-center py-5 bg-light rounded-4">
                                        <i class="ti ti-image-off fs-1 text-muted opacity-50 mb-2"></i>
                                        <p class="text-muted small">No poster available</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- GALLERY SECTION --}}
    @if ($project->detail->galleries->count() > 0)
    <section class="py-7" style="background: #f8fafc;">
        <div class="container animate__animated animate__fadeInUp">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold text-dark mb-2">Project Gallery</h2>
                <p class="text-muted">A visual journey through the development process.</p>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ($project->detail->galleries as $gallery)
                    @php
                        $galleryPath = resolveAssetPath($gallery->image_path);
                    @endphp
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ $galleryPath }}" 
                           class="glightbox d-block" 
                           data-gallery="project-gallery">
                            <img src="{{ $galleryPath }}" 
                                 class="gallery-img shadow-sm rounded-4" 
                                 alt="Gallery Image {{ $loop->iteration }}" 
                                 loading="lazy">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- RELATED PROJECTS --}}
    @if ($relatedProjects->count() > 0)
    <section class="py-7 bg-white">
        <div class="container animate__animated animate__fadeInUp">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <div>
                    <h2 class="display-6 fw-bold text-dark mb-2">Related Projects</h2>
                    <p class="text-muted mb-0">Discover more innovative work from this category.</p>
                </div>
                <a href="{{ route('frontend.project.index', $project->projectCategory->uuid) }}" class="btn btn-outline-primary rounded-pill px-4">
                    View All <i class="ti ti-arrow-narrow-right ms-1"></i>
                </a>
            </div>
            <div class="row g-4">
                @include('front_end.project.partials.project_card', ['projects' => $relatedProjects])
            </div>
        </div>
    </section>
    @endif
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
