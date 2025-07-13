@extends('front_end.template.master')

@section('page-title', 'Home Page')

@push('css')
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #3b82f6, #8b5cf6);
            --danger-gradient: linear-gradient(135deg, #ef4444, #ec4899);
        }

        /* Video Player Styles */
        .video-player-container {
            position: relative;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: #000;
        }

        .video-player-container:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }

        .video-embed-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
        }

        #player {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
            display: none;
            /* Hidden by default */
        }

        .video-poster-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            z-index: 2;
            cursor: pointer;
        }

        .video-poster-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
        }

        .video-play-icon {
            width: 80px;
            height: 80px;
            background: var(--danger-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
            z-index: 3;
        }

        .video-play-icon:hover {
            transform: scale(1.1);
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .video-player-container {
                margin-top: 30px;
            }
        }

        @media (max-width: 768px) {
            .video-player-container {
                border-radius: 8px;
            }

            .video-play-icon {
                width: 60px;
                height: 60px;
            }
        }

        /* Keep all your existing styles */
        .category-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary-gradient);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .impact-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .impact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .impact-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
        }

        .tabs-btn {
            border-radius: 12px;
            padding: 1.5rem;
            background: white;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            color: #4b5563;
        }

        .tabs-btn:hover,
        .tabs-btn.active {
            background: var(--primary-gradient);
            color: white !important;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .tabs-btn.active iconify-icon {
            color: white !important;
        }

        body.dark {
            background-color: #1a1a2e;
            color: #e6e6e6;
        }

        body.dark .impact-card,
        body.dark .tabs-btn:not(.active) {
            background-color: #16213e;
            border-color: #1f4068;
            color: #e6e6e6;
        }

        body.dark .impact-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .tabs-btn {
                padding: 1rem;
                font-size: 0.9rem;
            }

            .impact-card {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Banner Start -->
    <section class="py-lg-7 pt-lg-12 bg-light-gray overflow-hidden">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 animate__animated animate__fadeInLeft">
                    <div>
                        <h1 class="display-4 fw-bold lh-sm mb-4">
                            Showcase <span class="text-primary">Project-Based Learning</span> Excellence
                        </h1>
                        <div class="d-flex align-items-center gap-6 mb-4">
                            <p class="fs-4 mb-0 text-muted">
                                Explore a collection of inspiring IT projects showcased in our Project-Based Learning
                                exhibitions since 2020. Spanning fields such as Application Development, Mobile Apps,
                                Networking, IoT, Multimedia, Animation, Videography, and more—these projects reflect
                                real-world industry needs, creativity, and research-driven innovation.
                            </p>
                        </div>
                        <div class="d-flex gap-3">
                            <a href="#projects" class="btn btn-primary btn-lg px-4">Discover More</a>
                            <a href="#contact" class="btn btn-outline-primary btn-lg px-4">Get Involved</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 animate__animated animate__fadeInRight">
                    @php
                        $videoUrl = 'https://www.youtube.com/watch?v=omgUq6hwrdw';
                        $thumbnailUrl = 'https://img.youtube.com/vi/omgUq6hwrdw/maxresdefault.jpg';
                    @endphp

                    <div class="video-player-container">
                        <div class="video-embed-wrapper">
                            <div id="player"></div>
                        </div>
                        <div class="video-poster-overlay" id="video-poster"
                            style="background-image: url('{{ $thumbnailUrl }}')">
                            <div class="video-play-icon">
                                <iconify-icon icon="solar:play-circle-bold" width="2em" height="2em"
                                    class="text-white"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner End -->

    <!-- Impact Section Start -->
    <section class="py-7 py-lg-11">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="col-lg-5 mb-5 mb-lg-0 animate__animated animate__fadeInUp">
                    <h2 class="display-5 fw-bold mb-4">
                        Empowering Innovation Through Project-Based Learning
                    </h2>
                    <p class="fs-4 text-muted mb-4">
                        Since 2020, our students have successfully delivered over 300 impactful IT projects, showcasing
                        creativity, collaboration, and technological innovation.
                    </p>
                    <ul class="list-unstyled fs-4 mb-4">
                        <li class="mb-2 d-flex align-items-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary me-3 p-2 rounded-circle">
                                <i class="ti ti-check"></i>
                            </span>
                            <span>150+ Application & Mobile Development</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary me-3 p-2 rounded-circle">
                                <i class="ti ti-check"></i>
                            </span>
                            <span>80+ IoT & Networking Solutions</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary me-3 p-2 rounded-circle">
                                <i class="ti ti-check"></i>
                            </span>
                            <span>70+ Multimedia, Animation & Videography</span>
                        </li>
                    </ul>
                    <a href="#contact" class="btn btn-outline-primary btn-lg px-4">
                        Join Our Community
                    </a>
                </div>
                <div class="col-lg-6 animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="impact-card">
                                <div class="impact-icon bg-danger bg-opacity-10 text-danger">
                                    <iconify-icon icon="mdi:lightbulb-on-outline"></iconify-icon>
                                </div>
                                <h3 class="fw-bold mb-3">Innovative Solutions</h3>
                                <p class="text-muted mb-0">Real-world projects tackling current industry challenges.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="impact-card">
                                <div class="impact-icon bg-primary bg-opacity-10 text-primary">
                                    <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
                                </div>
                                <h3 class="fw-bold mb-3">Collaboration & Teamwork</h3>
                                <p class="text-muted mb-0">Projects designed and developed by multidisciplinary teams.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="impact-card">
                                <div class="impact-icon bg-info bg-opacity-10 text-info">
                                    <iconify-icon icon="mdi:layers-triple-outline"></iconify-icon>
                                </div>
                                <h3 class="fw-bold mb-3">Diverse Categories</h3>
                                <p class="text-muted mb-0">IT, Multimedia, Animation, IoT, Networking, and more.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="impact-card">
                                <div class="impact-icon bg-dark bg-opacity-10 text-dark">
                                    <iconify-icon icon="mdi:chart-bubble"></iconify-icon>
                                </div>
                                <h3 class="fw-bold mb-3">Industry-Driven</h3>
                                <p class="text-muted mb-0">Projects aligned with real-world business and social needs.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Impact Section End -->

    <!-- Departments Tabs Section -->
    <section class="py-7 py-lg-11 bg-light-gray" id="projects">
        <div class="container-fluid">
            <div class="row mb-5 animate__animated animate__fadeIn">
                <div class="col-12">
                    <h2 class="display-5 fw-bold text-center mb-3">Explore Projects by Department</h2>
                    <p class="fs-4 text-muted text-center mx-auto" style="max-width: 700px;">
                        Browse through our diverse collection of student projects
                    </p>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <ul class="nav nav-pills justify-content-center gap-3 flex-wrap mb-5" id="departments-tab" role="tablist">
                @foreach ($departments as $index => $department)
                    <li class="nav-item flex-grow-1" role="presentation" style="min-width: 200px;">
                        <button class="tabs-btn nav-link w-100 fs-5 fw-semibold {{ $index === 0 ? 'active' : '' }}"
                            id="tab-{{ $department->id }}" data-bs-toggle="pill"
                            data-bs-target="#content-{{ $department->id }}"
                            data-url="{{ route('frontend.project.category', $department->id) }}"
                            data-department-id="{{ $department->id }}" type="button" role="tab">
                            <iconify-icon icon="{{ $department->icon ?? 'mdi:school-outline' }}"
                                class="fs-2 mb-2 d-block mx-auto"></iconify-icon>
                            <span>{{ $department->department_name }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content mt-4 animate__animated animate__fadeIn" id="departments-tabContent">
                @foreach ($departments as $index => $department)
                    <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-{{ $department->id }}"
                        role="tabpanel" aria-labelledby="tab-{{ $department->id }}">
                        @if ($index === 0)
                            <!-- Initial loading for first tab -->
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('script')
    <!-- YouTube IFrame API -->
    <script>
        // Load YouTube API script
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    </script>

    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        // YouTube player variables
        let player;
        const videoId = 'omgUq6hwrdw';
        const videoPoster = document.getElementById('video-poster');

        // This function creates an <iframe> (and YouTube player) after the API code downloads.
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '100%',
                width: '100%',
                videoId: videoId,
                playerVars: {
                    'autoplay': 0,
                    'controls': 1,
                    'rel': 0,
                    'modestbranding': 1,
                    'showinfo': 0
                },
                events: {
                    'onReady': onPlayerReady
                }
            });
        }

        // When player is ready
        function onPlayerReady(event) {
            // Hide the player initially
            document.getElementById('player').style.display = 'none';

            // When poster is clicked
            videoPoster.addEventListener('click', function() {
                // Hide poster
                videoPoster.style.display = 'none';
                // Show player
                document.getElementById('player').style.display = 'block';
                // Play video
                player.playVideo();
            });
        }

        // Initialize GLightbox
        $(document).ready(function() {
            const lightbox = GLightbox({
                selector: '.glightbox-video',
                touchNavigation: true,
                loop: false,
                autoplayVideos: true
            });

            // Load first department content
            const firstTab = $('#departments-tab .nav-link.active').first();
            if (firstTab.length) {
                loadDepartmentContent(firstTab.data('department-id'));
            }

            // Handle tab clicks
            $('#departments-tab').on('click', '.nav-link', function(e) {
                e.preventDefault();
                const deptId = $(this).data('department-id');
                loadDepartmentContent(deptId);

                // Manually activate tab
                $(this).tab('show');
            });

            function loadDepartmentContent(id) {
                const tabContent = $('#content-' + id);
                const url = $(`#tab-${id}`).data('url');

                // Only load if empty or needs refresh
                if (tabContent.html().trim() === '' || tabContent.find('.spinner-border').length > 0) {
                    tabContent.html(`
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        cache: false,
                        success: function(response) {
                            if (response.html) {
                                tabContent.html(response.html);
                                // Reinitialize any plugins for loaded content
                                if (typeof GLightbox !== 'undefined') {
                                    GLightbox();
                                }
                            } else {
                                showError(tabContent, 'No content available');
                            }
                        },
                        error: function(xhr) {
                            let message = 'Failed to load content';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }
                            showError(tabContent, message);
                        }
                    });
                }
            }

            function showError(container, message) {
                container.html(`
                    <div class="alert alert-danger">
                        <i class="ti ti-alert-circle me-2"></i>
                        ${message}
                    </div>
                `);
            }

            // Animate on scroll
            $(window).on('scroll', function() {
                $('.animate__animated').each(function() {
                    const elementTop = $(this).offset().top;
                    const windowHeight = $(window).height();
                    const scrollTop = $(window).scrollTop();

                    if (elementTop < scrollTop + windowHeight - 100) {
                        $(this).addClass($(this).attr('data-animation'));
                    }
                });
            }).trigger('scroll');
        });
    </script>
@endpush
