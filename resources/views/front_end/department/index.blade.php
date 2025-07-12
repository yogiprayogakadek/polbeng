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

        /* Optional: Dark Mode Support (based on body.dark) */
        body.dark .accordion-button.custom-header {
            background: #0d47a1;
            color: #fff;
        }

        body.dark .accordion-body {
            background: #1a237e;
            color: #fff;
        }

        body.dark .accordion-item {
            background: #101f4b;
            border-color: #263859;
        }
    </style>
@endpush

@section('content')
    <section class="py-5 bg-light-gray">
        <div class="container-fluid">
            <div class="d-flex justify-content-between flex-md-nowrap flex-wrap align-items-center mb-4">
                <h2 class="fs-10 fw-bolder mb-0">Project Showcase</h2>
                <div class="d-flex align-items-center gap-2 fs-4">
                    <a href="/" class="text-muted fw-bold text-uppercase">Politeknik Negeri Bengkalis</a>
                    <iconify-icon icon="solar:alt-arrow-right-outline" class="fs-5 text-muted"></iconify-icon>
                    <a href="#" class="text-primary fw-bold text-uppercase">Projects</a>
                </div>
            </div>
            @if ($studyPrograms->isEmpty())
                <h3 class="text-center lh-base py-xl-5">Data not available for this department.</h3>
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
                                    {{-- Accordion Render --}}
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
        function getAccordionContent(url, targetId) {
            $.get(url, function(response) {
                $('#' + targetId).html(response.html);
            });
        }

        $(document).ready(function() {
            // Load content for first accordion item
            let $firstButton = $('.accordion-button').first();
            let firstUrl = $firstButton.data('url');
            let firstTargetId = $firstButton.data('bs-target').replace('#', '') + ' > .accordion-body';
            getAccordionContent(firstUrl, firstTargetId);

            // Load content on accordion click
            $('body').on('click', '.accordion-button', function() {
                let url = $(this).data('url');
                let targetId = $(this).data('bs-target').replace('#', '') + ' > .accordion-body';
                getAccordionContent(url, targetId);
            });
        });
    </script>
@endpush
