@extends('template.master')

@push('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush

@section('page-title', 'Department')

@section('content')
    <form action="{{ route('department.update', $department->id) }}" method="POST">
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
                <h5 class="card-title fw-semibold mb-4">Edit Department Data</h5>

                <div class="row pt-3">
                    {{-- Department code --}}
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="department_code" class="form-label">Department Code</label>
                            <input type="text" id="department_code" name="department_code"
                                class="form-control @error('department_code') is-invalid @enderror"
                                placeholder="Enter department code"
                                value="{{ old('department_code', $department->department_code) }}">
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
                                placeholder="Enter department name"
                                value="{{ old('department_name', $department->department_name) }}">
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
                        Update
                    </button>
                    <a href="{{ route('department.index') }}" class="btn btn-secondary ms-3">Cancel</a>
                </div>
            </div>
        </div>
    </form>


@endsection

@push('script')
    <script>
        $('[id^="mini-"]').removeClass('selected');
        $('#mini-1').addClass('selected');
        $('#department').addClass('active');
        $('#menu-right-mini-1').addClass('sidebar-nav d-block simplebar-scrollable-y');
    </script>
@endpush
