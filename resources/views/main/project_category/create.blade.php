@extends('template.master')

@push('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet"
        href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/select2/dist/css/select2.min.css">
@endpush

@section('page-title', 'Project Category')

@section('content')
    <form action="{{ route('projectCategory.store') }}" method="POST">
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
                <h5 class="card-title fw-semibold mb-4">Create Project Category</h5>

                <div class="row pt-3">
                    {{-- Study Program Name/Code --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="study_program_id" class="form-label">Study Program Code/Name</label>
                            <select name="study_program_id" id="study_program_id"
                                class="select2 form-control @error('study_program_id') is-invalid @enderror">
                                @foreach ($studyPrograms as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('study_program_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('study_program_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Project Category Name --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="project_category_name" class="form-label">Project Category Name</label>
                            <input type="text" id="project_category_name" name="project_category_name"
                                class="form-control @error('project_category_name') is-invalid @enderror"
                                placeholder="Enter project category name" value="{{ old('project_category_name') }}">
                            @error('project_category_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/select2/dist/js/select2.min.js"></script>

    <script>
        $(".select2").select2();

        $('.select2').each(function() {
            const $select = $(this);
            if ($select.hasClass('is-invalid')) {
                $select.next('.select2-container').find('.select2-selection').addClass('is-invalid');
            }
        });
    </script>
@endpush
