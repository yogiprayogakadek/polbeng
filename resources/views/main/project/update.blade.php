@extends('template.master')

@push('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@section('page-title', 'Project Category')

@section('content')
    <form action="{{ route('projectCategory.update', $studyProgram->id) }}" method="POST">
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
                <h5 class="card-title fw-semibold mb-4">Edit Project Category Data</h5>

                <div class="row pt-3">
                    {{-- Study Program Name/Code --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="study_program_id" class="form-label">Department Code/Name</label>
                            <select name="study_program_id" id="study_program_id"
                                class="select2 form-control @error('study_program_id') is-invalid @enderror">
                                @foreach ($studyPrograms as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $projectCategory->study_program_id == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
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
                                placeholder="Enter project category name"
                                value="{{ old('project_category_name', $projectCategory->project_category_name) }}">
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
                        Update
                    </button>
                    <a href="{{ route('projectCategory.index') }}" class="btn btn-secondary ms-3">Cancel</a>
                </div>
            </div>
        </div>
    </form>


@endsection

@push('script')
    <script>
        $('[id^="mini-"]').removeClass('selected');
        $('#mini-1').addClass('selected');
        $('#project_category').addClass('active');
        $('#menu-right-mini-1').addClass('sidebar-nav d-block simplebar-scrollable-y');
    </script>
@endpush
