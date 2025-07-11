<div id="lightboxOverlay" style="display: none;">
    <span class="lightbox-close" id="lightboxClose">&times;</span>
    <img id="lightboxImage" src="" alt="Zoomed Image">
</div>

<div class="modal fade" id="projectDetailModal" tabindex="-1" data-bs-backdrop="static" role="dialog"
    aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Project Detail</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <div class="modal-body">
                <div class="row g-3">

                    <!-- Project Title -->
                    <div class="col-12">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-file-text me-2"></i> Project Title</h5>
                                <p class="mb-0">{{ $project->project_title }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail & Poster -->
                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-3 text-center">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-photo me-2"></i> Project Thumbnail</h5>
                                <img src="{{ asset('storage/' . $project->thumbnail) }}" class="img-fluid rounded"
                                    style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-3 text-center">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-image me-2"></i> Project Poster</h5>
                                <img src="{{ asset('storage/' . $project->detail->poster_path) }}"
                                    class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <!-- Members -->
                    <div class="col-12">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-users me-2"></i> Project Members</h5>
                                <ul class="mb-0 ps-3">
                                    @foreach (json_decode($project->detail->members, true) as $item)
                                        <li>{{ $item['student_id_number'] . ' - ' . $item['student_name'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-align-left me-2"></i> Description</h5>
                                <p class="mb-0">{{ $project->detail->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Videos -->
                    @php
                        function getYoutubeEmbed($url)
                        {
                            preg_match(
                                '/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([^\s&]+)/',
                                $url,
                                $matches,
                            );
                            return isset($matches[1]) ? 'https://www.youtube.com/embed/' . $matches[1] : null;
                        }

                        $trailerEmbed = getYoutubeEmbed($project->detail->video_trailer_url);
                        $presentationEmbed = getYoutubeEmbed($project->detail->presentation_video_url);
                    @endphp

                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body text-center">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-video me-2"></i> Video Trailer</h5>
                                @if ($trailerEmbed)
                                    <iframe width="100%" height="200" src="{{ $trailerEmbed }}" frameborder="0"
                                        allowfullscreen></iframe>
                                @else
                                    <a href="{{ $project->detail->video_trailer_url }}"
                                        target="_blank">{{ $project->detail->video_trailer_url }}</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body text-center">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-presentation-analytics me-2"></i>
                                    Presentation Video</h5>
                                @if ($presentationEmbed)
                                    <iframe width="100%" height="200" src="{{ $presentationEmbed }}" frameborder="0"
                                        allowfullscreen></iframe>
                                @else
                                    <a href="{{ $project->detail->presentation_video_url }}"
                                        target="_blank">{{ $project->detail->presentation_video_url }}</a>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div> --}}

            <div class="modal-body">
                <div class="row g-3">

                    <!-- Project Title -->
                    <div class="col-12">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-file-text me-2"></i> Project Title</h5>
                                <p class="mb-0">{{ $project->project_title }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail & Poster -->
                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-3 text-center">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-photo me-2"></i> Project Thumbnail</h5>
                                <img src="{{ asset('storage/' . $project->thumbnail) }}"
                                    class="img-fluid rounded lightbox-trigger" style="max-height: 300px;">
                            </div>
                        </div>
                    </div>

                    <!-- Poster -->
                    <div class="col-6">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body text-center">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-photo-plus me-2"></i> Poster</h5>
                                <img src="{{ asset('storage/' . $project->detail->poster_path) }}"
                                    class="img-fluid rounded shadow-sm lightbox-trigger" style="max-height: 300px;">
                            </div>
                        </div>
                    </div>

                    <!-- Members -->
                    <div class="col-12">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-users me-2"></i> Members</h5>
                                <ul class="list-group list-group-flush">
                                    @foreach (json_decode($project->detail->members, true) as $item)
                                        <li class="list-group-item">{{ $item['student_id_number'] }} -
                                            {{ $item['student_name'] }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Description with Accordion -->
                    <div class="col-12">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-align-left me-2"></i> Description</h5>
                                <div class="accordion" id="descAccordion">
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header" id="descHeading">
                                            <button class="accordion-button collapsed fw-semibold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#descCollapse"
                                                aria-expanded="false" aria-controls="descCollapse">
                                                View Description
                                            </button>
                                        </h2>
                                        <div id="descCollapse" class="accordion-collapse collapse"
                                            aria-labelledby="descHeading" data-bs-parent="#descAccordion">
                                            <div class="accordion-body">
                                                {!! nl2br(e($project->detail->description)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        function generateVideoEmbed($url)
                        {
                            if (empty($url)) {
                                return '<p class="text-muted">No video provided.</p>';
                            }

                            // Check for YouTube
                            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/', $url, $matches)) {
                                $videoId = $matches[1];
                                return '<div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/' .
                                    $videoId .
                                    '" frameborder="0" allowfullscreen></iframe>
                    </div>';
                            }

                            // Check for Vimeo
                            if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
                                $videoId = $matches[1];
                                return '<div class="ratio ratio-16x9">
                        <iframe src="https://player.vimeo.com/video/' .
                                    $videoId .
                                    '" frameborder="0" allowfullscreen></iframe>
                    </div>';
                            }

                            // If not recognized
                            return '<p class="text-danger">Invalid video URL.</p>';
                        }
                    @endphp

                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body text-center">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-video me-2"></i> Video Trailer</h5>
                                {!! generateVideoEmbed($project->detail->video_trailer_url) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body text-center">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-presentation-analytics me-2"></i>
                                    Presentation Video</h5>
                                {!! generateVideoEmbed($project->detail->presentation_video_url) !!}
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Klik gambar → munculkan lightbox
        $('.lightbox-trigger').on('click', function() {
            var imgSrc = $(this).attr('src');
            $('#lightboxImage').attr('src', imgSrc);
            $('#lightboxOverlay').fadeIn();
        });

        // Klik tombol X → sembunyikan lightbox
        $('#lightboxClose').on('click', function() {
            $('#lightboxOverlay').fadeOut();
        });

        // Nonaktifkan klik di luar agar tidak menutup
        $('#lightboxOverlay').on('click', function(e) {
            // Cek apakah yang diklik adalah overlay itu sendiri (bukan gambar atau tombol)
            if (e.target.id === 'lightboxOverlay') {
                // Tidak melakukan apa-apa → tidak close
            }
        });

        // Cegah klik di gambar dari menutup (jaga-jaga)
        $('#lightboxImage').on('click', function(e) {
            e.stopPropagation();
        });
    });
</script>
