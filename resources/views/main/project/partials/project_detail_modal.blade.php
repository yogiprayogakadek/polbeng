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

                    <style>
                        .timeline-stepper {
                            position: relative;
                            padding-left: 3rem;
                        }

                        .timeline-stepper::before {
                            content: '';
                            position: absolute;
                            left: 1rem;
                            top: 0;
                            bottom: 0;
                            width: 2px;
                            background: #e2e8f0;
                        }

                        .timeline-item {
                            position: relative;
                            padding-bottom: 2rem;
                        }

                        .timeline-item:last-child {
                            padding-bottom: 0;
                        }

                        .timeline-icon {
                            position: absolute;
                            left: -2.6rem;
                            width: 2.2rem;
                            height: 2.2rem;
                            background: white;
                            border: 2px solid #e2e8f0;
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            z-index: 1;
                            transition: all 0.3s ease;
                        }

                        .timeline-item.active .timeline-icon {
                            background: #3b82f6;
                            border-color: #3b82f6;
                            color: white;
                            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
                        }

                        .timeline-item.success .timeline-icon {
                            background: #10b981;
                            border-color: #10b981;
                            color: white;
                        }

                        .timeline-item.danger .timeline-icon {
                            background: #ef4444;
                            border-color: #ef4444;
                            color: white;
                        }

                        .timeline-content {
                            padding-top: 0.2rem;
                        }

                        .timeline-title {
                            font-size: 0.95rem;
                            font-weight: 700;
                            color: #1e293b;
                            margin-bottom: 0.2rem;
                        }

                        .timeline-time {
                            font-size: 0.8rem;
                            color: #64748b;
                        }

                        .timeline-desc {
                            font-size: 0.85rem;
                            color: #475569;
                            margin-top: 0.5rem;
                        }
                    </style>

                    <!-- Validation Timeline -->
                    <div class="col-12">
                        <div class="card shadow-sm rounded-4 border-0 bg-light-subtle">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                    <iconify-icon icon="solar:history-bold-duotone" class="text-primary"></iconify-icon>
                                    Approval Journey
                                </h5>

                                <div class="timeline-stepper">
                                    <!-- Step 1: Submission -->
                                    <div class="timeline-item success">
                                        <div class="timeline-icon">
                                            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Project Submitted</div>
                                            <div class="timeline-time">{{ $project->created_at->format('d M Y, H:i') }}</div>
                                            <div class="timeline-desc">Initial submission by student for review.</div>
                                        </div>
                                    </div>

                                    <!-- Step 2: Dosen Verification -->
                                    @php
                                        $dosenStatusClass = '';
                                        $dosenIcon = 'solar:clock-circle-bold';
                                        if (in_array($project->status, [\App\Models\Project::STATUS_VERIFIED_DOSEN, \App\Models\Project::STATUS_APPROVED, \App\Models\Project::STATUS_REJECTED_KAPRODI])) {
                                            $dosenStatusClass = 'success';
                                            $dosenIcon = 'solar:shield-check-bold';
                                        } elseif ($project->status === \App\Models\Project::STATUS_REJECTED_DOSEN) {
                                            $dosenStatusClass = 'danger';
                                            $dosenIcon = 'solar:close-circle-bold';
                                        } elseif ($project->status === \App\Models\Project::STATUS_PENDING) {
                                            $dosenStatusClass = 'active';
                                        }
                                    @endphp
                                    <div class="timeline-item {{ $dosenStatusClass }}">
                                        <div class="timeline-icon">
                                            <iconify-icon icon="{{ $dosenIcon }}"></iconify-icon>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Verification (Dosen Pembimbing)</div>
                                            @if($dosenStatusClass == 'success' || $dosenStatusClass == 'danger')
                                                <div class="timeline-time">{{ $project->updated_at->format('d M Y, H:i') }}</div>
                                            @else
                                                <div class="timeline-time text-warning fw-semibold">Pending Review</div>
                                            @endif

                                            @if($project->status === \App\Models\Project::STATUS_REJECTED_DOSEN)
                                                <div class="alert alert-danger py-2 px-3 rounded-3 mt-2 mb-0 border-0 shadow-sm">
                                                    <small class="fw-bold d-block mb-1">Rejection Reason:</small>
                                                    <small class="mb-0">{{ $project->rejection_reason }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Step 3: Kaprodi Approval -->
                                    @php
                                        $kaprodiStatusClass = '';
                                        $kaprodiIcon = 'solar:clock-circle-bold';
                                        if ($project->status === \App\Models\Project::STATUS_APPROVED) {
                                            $kaprodiStatusClass = 'success';
                                            $kaprodiIcon = 'solar:verified-check-bold';
                                        } elseif ($project->status === \App\Models\Project::STATUS_REJECTED_KAPRODI) {
                                            $kaprodiStatusClass = 'danger';
                                            $kaprodiIcon = 'solar:close-circle-bold';
                                        } elseif ($project->status === \App\Models\Project::STATUS_VERIFIED_DOSEN) {
                                            $kaprodiStatusClass = 'active';
                                        }
                                    @endphp
                                    <div class="timeline-item {{ $kaprodiStatusClass }}">
                                        <div class="timeline-icon">
                                            <iconify-icon icon="{{ $kaprodiIcon }}"></iconify-icon>
                                        </div>
                                        <div class="timeline-content">
                                            <div class="timeline-title">Final Approval (Kaprodi)</div>
                                            @if($kaprodiStatusClass == 'success' || $kaprodiStatusClass == 'danger')
                                                <div class="timeline-time">{{ $project->updated_at->format('d M Y, H:i') }}</div>
                                            @else
                                                <div class="timeline-time text-muted">Awaiting Verification</div>
                                            @endif

                                            @if($project->status === \App\Models\Project::STATUS_REJECTED_KAPRODI)
                                                <div class="alert alert-danger py-2 px-3 rounded-3 mt-2 mb-0 border-0 shadow-sm">
                                                    <small class="fw-bold d-block mb-1">Rejection Reason:</small>
                                                    <small class="mb-0">{{ $project->rejection_reason }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail & Poster -->
                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-3 text-center">
                            <div class="card-body">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-photo me-2"></i> Project Thumbnail</h5>
                                <img src="{{ resolveAssetPath($project->thumbnail) }}"
                                    class="img-fluid rounded lightbox-trigger" style="max-height: 300px;">
                            </div>
                        </div>
                    </div>

                    <!-- Poster -->
                    <div class="col-6">
                        <div class="card shadow-sm rounded-3">
                            <div class="card-body text-center">
                                <h5 class="fw-semibold mb-2"><i class="ti ti-photo-plus me-2"></i> Poster</h5>
                                <img src="{{ resolveAssetPath($project->detail->poster_path) }}"
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
