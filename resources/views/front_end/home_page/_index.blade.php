@extends('front_end.template.master')

@section('page-title', 'Home Page')

@push('css')
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>
        .video-thumb {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .video-thumb img {
            transition: transform 0.3s ease-in-out;
        }

        .video-thumb:hover img {
            transform: scale(1.02);
        }

        .video-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            z-index: 5;
            transition: opacity 0.3s ease-in-out;
        }

        .video-thumb:hover .video-overlay {
            opacity: 1;
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .fade-in-loaded {
            opacity: 1;
        }
    </style>
@endpush

@section('content')
    <!-- Banner Start -->
    <section class="py-lg-7 pt-lg-12 bg-light-gray overflow-hidden">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div>
                        <h1 class="fs-10 fw-medium lh-sm mb-4">
                            Showcase <b>Project-Based Learning</b> Excellence
                        </h1>
                        <div class="d-flex align-items-center gap-6 mb-4">
                            <p class="fs-4 mb-0 fw-medium">
                                Explore a collection of inspiring IT projects showcased in our Project-Based Learning
                                exhibitions since 2020. Spanning fields such as Application Development, Mobile Apps,
                                Networking, IoT, Multimedia, Animation, Videography, and more—these projects reflect
                                real-world industry needs, creativity, and research-driven innovation.
                            </p>
                        </div>
                        <a href="#projects" class="btn btn-primary">Discover More</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    @php
                        $videoUrl = 'https://www.youtube.com/watch?v=omgUq6hwrdw';
                        $thumb = videoThumbnail($videoUrl);
                    @endphp

                    @if ($thumb)
                        <a href="{{ $videoUrl }}"
                            class="video-thumb glightbox-video d-block rounded overflow-hidden position-relative"
                            data-type="video" data-gallery="video" data-width="1280" title="Tonton Video"
                            style="aspect-ratio: 16/9;">

                            {{-- Thumbnail --}}
                            <img src="{{ $thumb }}" alt="Thumbnail" class="w-100 h-100 object-fit-cover rounded"
                                loading="lazy" style="image-rendering: auto;">

                            {{-- Overlay Play Button --}}
                            <div class="video-overlay">
                                <iconify-icon icon="solar:clapperboard-open-play-line-duotone" width="2em" height="2em"
                                    class="text-white rounded-circle p-3" style="background-color: #e53935;">
                                </iconify-icon>
                            </div>
                        </a>
                    @endif

                </div>



            </div>
        </div>
    </section>
    <!-- Banner End -->

    <!-- Impact Section Start -->
    <section class="pt-7 pt-md-14 pt-lg-11 pb-7 pb-lg-5">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <h2 class="fs-15 fw-bolder mb-4">
                        Empowering Innovation Through Project-Based Learning
                    </h2>
                    <p class="fs-5 text-muted mb-4">
                        Since 2020, our students have successfully delivered over 300 impactful IT projects, showcasing
                        creativity, collaboration, and technological innovation.
                    </p>
                    <ul class="list-unstyled fs-4 text-muted mb-4">
                        <li>✔ 150+ Application & Mobile Development</li>
                        <li>✔ 80+ IoT & Networking Solutions</li>
                        <li>✔ 70+ Multimedia, Animation & Videography</li>
                    </ul>
                    <a href="#contact" class="fs-4 fw-bolder pb-2 border-dark border-2 border-bottom">
                        Get Involved
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <div class="d-flex flex-column align-items-start gap-3">
                                <div class="bg-danger-subtle rounded-2 round-48 hstack justify-content-center">
                                    <iconify-icon icon="mdi:lightbulb-on-outline" class="fs-7 text-danger"></iconify-icon>
                                </div>
                                <h4 class="fw-semibold mb-0">Innovative Solutions</h4>
                                <p class="fs-4 text-muted mb-0">Real-world projects tackling current industry challenges.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="d-flex flex-column align-items-start gap-3">
                                <div class="bg-primary-subtle rounded-2 round-48 hstack justify-content-center">
                                    <iconify-icon icon="mdi:account-group-outline" class="fs-7 text-primary"></iconify-icon>
                                </div>
                                <h4 class="fw-semibold mb-0">Collaboration & Teamwork</h4>
                                <p class="fs-4 text-muted mb-0">Projects designed and developed by multidisciplinary teams.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="d-flex flex-column align-items-start gap-3">
                                <div class="bg-info-subtle rounded-2 round-48 hstack justify-content-center">
                                    <iconify-icon icon="mdi:layers-triple-outline" class="fs-7 text-info"></iconify-icon>
                                </div>
                                <h4 class="fw-semibold mb-0">Diverse Categories</h4>
                                <p class="fs-4 text-muted mb-0">IT, Multimedia, Animation, IoT, Networking, and more.</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="d-flex flex-column align-items-start gap-3">
                                <div class="bg-light-subtle rounded-2 round-48 hstack justify-content-center">
                                    <iconify-icon icon="mdi:chart-bubble" class="fs-7 text-dark"></iconify-icon>
                                </div>
                                <h4 class="fw-semibold mb-0">Industry-Driven</h4>
                                <p class="fs-4 text-muted mb-0">Projects aligned with real-world business and social needs.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Impact Section End -->

    <!-- Departments Tabs Start -->
    <section class="py-7 py-md-14 py-lg-11 bg-light-gray overflow-hidden" id="projects">
        <div class="container-fluid">
            <ul class="nav nav-pills tabs-pills justify-content-start gap-3 flex-wrap" id="pills-tab" role="tablist">
                @foreach ($departments as $index => $department)
                    <li class="nav-item flex-grow-1" role="presentation">
                        <button
                            class="tabs-btn nav-link w-100 {{ $index === 0 ? 'active' : '' }} fs-4 fw-semibold px-4 py-4 tabs-shadow text-center d-flex flex-column align-items-center justify-content-center"
                            id="tab-{{ $department->id }}" data-bs-toggle="pill"
                            data-bs-target="#content-{{ $department->id }}"
                            data-url="{{ route('frontend.project.category', $department->id) }}"
                            data-department-id="{{ $department->id }}" type="button" role="tab">
                            <iconify-icon icon="{{ $department->icon ?? 'mdi:school-outline' }}"
                                class="fs-3 mb-2"></iconify-icon>
                            <div>{{ $department->department_name }}</div>
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content mt-5" id="pills-tabContent">
                {{-- tabs content render --}}
            </div>
        </div>
    </section>
    <!-- Departments Tabs End -->

@endsection

@push('script')
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
        <script>
            const lightboxVideos = GLightbox({
                selector: '.glightbox-video'
            });
        </script>
    @endpush
    <script>
        function getTabContent(id) {
            $.get('homepage/project-category/' + id, function(response) {
                $('#pills-tabContent').html(response.html);
            });
        }
        $(document).ready(function() {
            let deptID = $('.tabs-btn').first().data('department-id')
            getTabContent(deptID)
            $('body').on('click', '.tabs-btn', function() {
                let departmentID = $(this).data('department-id')
                getTabContent(departmentID)
            })
        });

        document.querySelectorAll('img.fade-in').forEach(img => {
            img.onload = () => img.classList.add('fade-in-loaded');
        });
    </script>
@endpush
