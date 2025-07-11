@extends('template.master')

@push('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@section('page-title', 'Study Program')

@section('content')
    <form action="{{ route('studyProgram.update', $studyProgram->id) }}" method="POST">
        @csrf
        @method('PUT')
        {{-- Alert Success --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Error Global --}}
        @if ($errors->any())
            <div class="alert alert-danger">
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
                <h5 class="card-title fw-semibold mb-4">Edit Study Program Data</h5>

                <div class="row pt-3">
                    {{-- Department Name/Code --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department Code/Name</label>
                            <select name="department_id" id="department_id"
                                class="select2 form-control @error('department_id') is-invalid @enderror">
                                @foreach ($departments as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('department_id', $studyProgram->department_id) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
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
                                placeholder="Enter department code"
                                value="{{ old('study_program_code', $studyProgram->study_program_code) }}">
                            @error('study_program_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Study Program Name --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="study_program_name" class="form-label">Study Program Name</label>
                            <input type="text" id="study_program_name" name="study_program_name"
                                class="form-control @error('study_program_name') is-invalid @enderror"
                                placeholder="Enter study program name"
                                value="{{ old('study_program_name', $studyProgram->study_program_name) }}">
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
                        Update
                    </button>
                    <a href="{{ route('studyProgram.index') }}" class="btn btn-secondary ms-3">Cancel</a>
                </div>
            </div>
        </div>
    </form>


@endsection

@push('script')
    <script>
        $('[id^="mini-"]').removeClass('selected');
        $('#mini-1').addClass('selected');
        $('#studi_program').addClass('active');
        $('#menu-right-mini-1').addClass('sidebar-nav d-block simplebar-scrollable-y');

        $(".select2").select2();
        $('.select2').each(function() {
            const $select = $(this);
            if ($select.hasClass('is-invalid')) {
                $select.next('.select2-container').find('.select2-selection').addClass('is-invalid');
            }
        });
    </script>
@endpush
