@extends('front_end.template.master')

@section('page-title', 'Project Detail')

@push('css')
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
@endpush

@section('content')
    {{-- TITLE --}}
    <section class="bg-light-gray position-relative py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-lg" style="background-color: rgba(244, 244, 244, 0.697)">
                        <div class="card-body px-4 px-lg-5 py-4 text-start">
                            <h2 class="fs-8 fw-bold text-dark lh-base mb-3">{{ $project->project_title }}</h2>
                            @php
                                $members = json_decode($project->detail->members, true);
                            @endphp
                            <div class="d-flex flex-wrap gap-2">
                                <i class="ti ti-users fs-4 text-dark fw-medium px-3 py-2"></i>
                                @foreach ($members as $member)
                                    <span class="badge text-bg-light text-dark fs-4 fw-medium px-3 py-2 rounded-pill">
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

    {{-- DESCRIPTION, VIDEO --}}
    <section class="bg-light-gray position-relative py-2">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body px-4 px-lg-5 py-4 text-start">

                            {{-- DESCRIPTION - Accordion --}}
                            <div class="mb-5">
                                <div class="accordion" id="descriptionAccordion">
                                    <div class="accordion-item border-0 bg-transparent">
                                        <h2 class="accordion-header" id="descHeading">
                                            <button class="accordion-button bg-transparent px-0 text-dark fs-6 fw-bold"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#descCollapse"
                                                aria-expanded="true" aria-controls="descCollapse" style="box-shadow: none;">
                                                Description
                                            </button>
                                        </h2>
                                        <div id="descCollapse" class="accordion-collapse collapse show"
                                            aria-labelledby="descHeading" data-bs-parent="#descriptionAccordion">
                                            <div class="accordion-body pt-3 border-top border-bottom">
                                                {{ $project->detail->description }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- VIDEOS --}}
                            <div class="row g-4">
                                {{-- VIDEO TRAILER --}}
                                <div class="col-lg-6">
                                    <h2 class="fs-6 fw-bold text-dark lh-base mb-3">Demo Video / Trailer</h2>
                                    <div class="border-top pt-4 mt-3">
                                        <a href="{{ toEmbedUrl($project->detail->video_trailer_url) }}"
                                            class="btn btn-outline-primary glightbox-video" data-gallery="video-trailer"
                                            data-type="video" data-width="1280" title="Trailer">
                                            <i class="ti ti-play-circle me-2"></i> Watch Trailer
                                        </a>
                                    </div>
                                </div>

                                {{-- VIDEO PRESENTASI --}}
                                <div class="col-lg-6">
                                    <h2 class="fs-6 fw-bold text-dark lh-base mb-3">Presentation Video</h2>
                                    <div class="border-top pt-4 mt-3">
                                        <a href="{{ toEmbedUrl($project->detail->presentation_video_url) }}"
                                            class="btn btn-outline-primary glightbox-video"
                                            data-gallery="video-presentation" data-type="video" data-width="1280"
                                            title="Presentasi">
                                            <i class="ti ti-play-circle me-2"></i> Watch Presentasi
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div> <!-- card-body -->
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </section>

    {{-- POSTER & GALLERY --}}
    <section class="bg-light-gray position-relative py-4">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body px-4 px-lg-5 py-4 text-start">
                            <h2 class="fs-6 fw-bold text-dark lh-base mb-3">Poster</h2>
                            <div class="border-top pt-4 mt-3">
                                <img src="{{ asset('storage/' . $project->detail->poster_path) }}" width="100%"
                                    class="rounded shadow-sm" alt="Project Poster">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body px-4 px-lg-5 py-4 text-start">
                            <h2 class="fs-6 fw-bold text-dark lh-base mb-3">Gallery</h2>
                            <div class="border-top pt-4 mt-3">
                                @forelse ($project->detail->galleries->chunk(2) as $chunk)
                                    <div class="row g-3">
                                        @foreach ($chunk as $gallery)
                                            <div class="col-12 col-md-6">
                                                <a href="{{ asset('storage/' . $gallery->image_path) }}"
                                                    class="glightbox d-block" data-gallery="project-gallery"
                                                    data-title="{{ $project->project_title }}">
                                                    <img src="{{ asset('storage/' . $gallery->image_path) }}"
                                                        class="rounded shadow-sm w-100"
                                                        style="height: 200px; object-fit: cover;" alt="Gallery Image">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @empty
                                    <h3 class="text-center">No data available</h3>
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const lightboxImages = GLightbox({
            selector: '.glightbox'
        });

        const lightboxVideos = GLightbox({
            selector: '.glightbox-video'
        });
    </script>
@endpush
