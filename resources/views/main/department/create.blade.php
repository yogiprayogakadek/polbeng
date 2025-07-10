@extends('template.master')

@push('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@section('page-title', 'Department')

@section('content')
    <form action="{{ route('department.store') }}" enctype="multipart/form-data" method="POST">
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
                <h5 class="card-title fw-semibold mb-4">Create Department</h5>

                <div class="row pt-3">
                    {{-- Department code --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="department_code" class="form-label">Department Code</label>
                            <input type="text" id="department_code" name="department_code"
                                class="form-control @error('department_code') is-invalid @enderror"
                                placeholder="Enter department code" value="{{ old('department_code') }}">
                            @error('department_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Department name --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="department_name" class="form-label">Department Name</label>
                            <input type="text" id="department_name" name="department_name"
                                class="form-control @error('department_name') is-invalid @enderror"
                                placeholder="Enter department name" value="{{ old('department_name') }}">
                            @error('department_name')
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
