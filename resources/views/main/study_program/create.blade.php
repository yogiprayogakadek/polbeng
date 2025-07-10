@extends('template.master')

@push('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet"
        href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/select2/dist/css/select2.min.css">
@endpush

@section('page-title', 'Study Program')

@section('content')
    <form action="{{ route('studyProgram.store') }}" method="POST">
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
                <h5 class="card-title fw-semibold mb-4">Create Study Program</h5>

                <div class="row pt-3">
                    {{-- Department Name/Code --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department Code/Name</label>
                            <select name="department_id" id="department_id"
                                class="select2 form-control @error('department_id') is-invalid @enderror">
                                @foreach ($departments as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('department_id' == $key ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Study Program Code --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="study_program_code" class="form-label">Study Program Code</label>
                            <input type="text" id="study_program_code" name="study_program_code"
                                class="form-control @error('study_program_code') is-invalid @enderror"
                                placeholder="Enter study program code" value="{{ old('study_program_code') }}">
                            @error('study_program_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Study Program Name --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="study_program_name" class="form-label">Study Program name</label>
                            <input type="text" id="study_program_name" name="study_program_name"
                                class="form-control @error('study_program_name') is-invalid @enderror"
                                placeholder="Enter study program name" value="{{ old('study_program_name') }}">
                            @error('study_program_name')
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
