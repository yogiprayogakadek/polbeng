@extends('template.master')

@push('css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet" />

    <style>
        /* Sembunyikan progress bar bawaan Dropzone */
        .dz-progress {
            display: none !important;
        }

        .btn-outline-primary {
            border-radius: 25px;
            font-weight: 500;
        }

        .btn-remove-member {
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@section('page-title', 'Project')

@section('content')
    <form action="{{ route('project.store') }}" enctype="multipart/form-data" method="POST" id="form">
        @csrf
        {{-- Success Alert --}}
        @if (session('success'))
            <div class="alert customize-alert alert-dismissible text-success alert-light-success bg-success-subtle fade show remove-close-icon"
                role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="d-flex align-items-center  me-3 me-md-0">
                    <i class="ti ti-info-circle fs-5 me-2 text-success"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        {{-- Error Global --}}
        @if ($errors->any())
            <div class="alert customize-alert alert-dismissible border-danger text-danger fade show remove-close-icon"
                role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>There is an error:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Create Project</h5>

                <div class="row pt-3">
                    {{-- Project Category --}}
                    <div class="col-md-6">
                        <div class="mb-3 position-relative">
                            <label for="project_category_id" class="form-label">Project Category Name</label>
                            <select name="project_category_id" id="project_category_id"
                                class="form-select select2 @error('project_category_id') is-invalid @enderror"
                                data-placeholder="Choose program...">
                                <option value="">Choose program...</option>
                                @foreach ($projectCategories as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('project_category_id') == $key ? 'selected' : '' }}>{{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    {{-- Project Title --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="project_title" class="form-label">Project Title</label>
                            <input type="text" id="project_title" name="project_title"
                                class="form-control @error('project_title') is-invalid @enderror"
                                placeholder="Enter project title" value="{{ old('project_title') }}">
                            @error('project_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- School Year --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="school_year" class="form-label">School Year</label>
                            <select name="school_year" id="school_year"
                                class="form-control select2 @error('school_year') is-invalid @enderror">
                                <option value="">Choose school year...</option>
                                @foreach ($years as $year)
                                    @php $next = $year + 1; @endphp
                                    <option value="{{ $year }}/{{ $next }}"
                                        {{ old('school_year') == "$year/$next" ? 'selected' : '' }}>
                                        {{ $year }}/{{ $next }}
                                    </option>
                                @endforeach
                            </select>
                            @error('school_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Semester --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select name="semester" id="semester"
                                class="select2 form-control @error('semester') is-invalid @enderror">
                                <option value="">Choose semester...</option>
                                @foreach ($semester as $semester)
                                    <option value="{{ $semester }}"
                                        {{ old('semester') == $semester ? 'selected' : '' }}>{{ $semester }}
                                    </option>
                                @endforeach
                            </select>
                            @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Thumbnail --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input type="file" id="thumbnail" name="thumbnail"
                                class="form-control @error('thumbnail') is-invalid @enderror"
                                placeholder="Enter thumbnail file" value="{{ old('thumbnail') }}">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Poster --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="poster_path" class="form-label">Poster</label>
                            <input type="file" id="poster_path" name="poster_path"
                                class="form-control @error('poster_path') is-invalid @enderror"
                                placeholder="Enter poster file" value="{{ old('poster_path') }}">
                            @error('poster_path')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Video Trailer Url --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="video_trailer_url" class="form-label">Video Trailer URL</label>
                            <input type="text" id="video_trailer_url" name="video_trailer_url"
                                class="form-control @error('video_trailer_url') is-invalid @enderror"
                                placeholder="Enter video trailer url" value="{{ old('video_trailer_url') }}">
                            @error('video_trailer_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Presentation Video Url --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="presentation_video_url" class="form-label">Presentation Video URL</label>
                            <input type="text" id="presentation_video_url" name="presentation_video_url"
                                class="form-control @error('presentation_video_url') is-invalid @enderror"
                                placeholder="Enter video trailer url" value="{{ old('presentation_video_url') }}">
                            @error('presentation_video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Galleries --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="galleries" class="form-label">Galleries</label>
                            <div class="dropzone" id="galleryDropzone"></div>
                            <input type="file" name="galleries[]" id="realGalleriesInput" multiple hidden>
                            {{-- <div id="galleriesInputs"></div> --}}
                            @error('galleries')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="5"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Enter description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Project Member --}}
                    <div class="col-md-12">
                        <label class="form-label">Project Members</label>
                        <div id="membersArea">
                            @php
                                $oldNames = old('student_name', ['']);
                                $oldIds = old('student_id_number', ['']);
                                $count = max(count($oldNames), count($oldIds));
                            @endphp

                            @for ($i = 0; $i < $count; $i++)
                                <div class="row student-row mb-3">
                                    <div class="col-md-6">
                                        <input type="text" name="student_name[]" value="{{ $oldNames[$i] ?? '' }}"
                                            class="form-control @error('student_name.' . $i) is-invalid @enderror"
                                            placeholder="Student Name">
                                        @error('student_name.' . $i)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="student_id_number[]" value="{{ $oldIds[$i] ?? '' }}"
                                            class="form-control @error('student_id_number.' . $i) is-invalid @enderror"
                                            placeholder="Student ID Number">
                                        @error('student_id_number.' . $i)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <button type="button" class="btn btn-outline-primary mt-2 rounded-pill px-4" id="addMember">
                            <i class="ti ti-user-plus me-1"></i> Add Member
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="card-body border-top">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                    <button type="reset" class="btn btn-danger ms-3">
                        Reset
                    </button>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('script')
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/select2/dist/js/select2.full.min.js">
    </script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').each(function() {
                const $select = $(this);
                $select.select2({
                    placeholder: $select.data('placeholder') || 'Select an option',
                    width: '100%',
                    dropdownParent: $select.closest('.mb-3')
                });
            });

            // Add error on select2
            $('.select2').each(function() {
                const $select = $(this);
                if ($select.hasClass('is-invalid')) {
                    $select.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                }
            });

            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "newestOnTop": false,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

        });

        Dropzone.autoDiscover = false;

        const realInput = document.getElementById('realGalleriesInput');
        const myDropzone = new Dropzone("#galleryDropzone", {
            url: "#", // Not used since we don't upload via Dropzone
            autoProcessQueue: false,
            addRemoveLinks: true,
            maxFiles: 10,
            acceptedFiles: 'image/*',
            init: function() {
                this.on("addedfile", function(file) {
                    updateRealInput(this.files);
                    toastr.success(`File "${file.name}" berhasil ditambahkan`, 'Upload Success', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000
                    });
                });

                this.on("removedfile", function(file) {
                    updateRealInput(this.files);

                    toastr.success(`File "${file.name}" berhasil dihapus`, 'Remove Success', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 3000
                    });
                });
            }
        });

        function updateRealInput(files) {
            const dataTransfer = new DataTransfer();

            for (let i = 0; i < files.length; i++) {
                dataTransfer.items.add(files[i]);
            }

            realInput.files = dataTransfer.files;
        }
    </script>

    <script>
        $(document).ready(function() {
            const $membersArea = $('#membersArea');
            const $addMemberBtn = $('#addMember');

            function updateLayoutAndButtons() {
                const $rows = $membersArea.find('.student-row');
                const isMultiple = $rows.length > 1;

                $rows.each(function() {
                    const $row = $(this);
                    const $cols = $row.children('div');
                    const $nameCol = $cols.eq(0);
                    const $idCol = $cols.eq(1);
                    let $removeCol = $cols.eq(2);

                    if (isMultiple) {
                        $nameCol.removeClass().addClass('col-md-5');
                        $idCol.removeClass().addClass('col-md-5');

                        if ($removeCol.length === 0) {
                            $removeCol = $(
                                '<div class="col-md-2 d-flex align-items-center justify-content-start"></div>'
                            );
                            const $removeBtn = $(`
                        <button type="button" class="btn btn-outline-danger rounded-pill px-3 remove-member" title="Remove">
                            <i class="ti ti-user-minus me-1"></i> Remove
                        </button>
                    `);
                            $removeCol.append($removeBtn);
                            $row.append($removeCol);
                        } else {
                            $removeCol.removeClass('d-none').addClass('d-flex');
                        }

                    } else {
                        $nameCol.removeClass().addClass('col-md-6');
                        $idCol.removeClass().addClass('col-md-6');

                        if ($removeCol.length) {
                            $removeCol.addClass('d-none').removeClass('d-flex');
                        }
                    }
                });
            }

            function addMemberRow() {
                const $newRow = $(`
            <div class="row student-row mb-3">
                <div class="col-md-5">
                    <input type="text" name="student_name[]" class="form-control" placeholder="Student Name">
                    <div class="text-danger student-name-error"></div>
                </div>
                <div class="col-md-5">
                    <input type="text" name="student_id_number[]" class="form-control" placeholder="Student ID Number">
                    <div class="text-danger student-id-error"></div>
                </div>
                <div class="col-md-2 d-flex align-items-center justify-content-start">
                    <button type="button" class="btn btn-outline-danger rounded-pill px-3 remove-member" title="Remove">
                        <i class="ti ti-user-minus me-1"></i> Remove
                    </button>
                </div>
            </div>
        `);
                $membersArea.append($newRow);
                updateLayoutAndButtons();
            }

            $addMemberBtn.on('click', function() {
                addMemberRow();
            });

            $membersArea.on('click', '.remove-member', function() {
                $(this).closest('.student-row').remove();
                updateLayoutAndButtons();
            });

            updateLayoutAndButtons();
        });
    </script>
@endpush
