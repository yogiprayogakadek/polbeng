@extends('template.master')

@section('page-title', 'Study Program')

@push('css')
    <link rel="stylesheet"
        href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
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

    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Study Programs List</h5>

            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered text-nowrap align-middle" width="100%">
                    <thead>
                        <tr>
                            <th>Department Code/Name</th>
                            <th>Study Program Code</th>
                            <th>Study Program Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $data)
                            <tr>
                                <td>{{ $data->department->department_code . ' - ' . $data->department->department_name }}
                                </td>
                                <td>{{ $data->study_program_code }}</td>
                                <td>{{ $data->study_program_name }}</td>
                                <td>
                                    <span
                                        class="badge text-bg-{{ $data->is_active == true ? 'primary' : 'warning' }}">{{ $data->is_active == true ? 'Active' : 'Disabled' }}</span>
                                </td>
                                <td>
                                    <button type="button"
                                        class="btn {{ $data->is_active ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning' }} btn-toggle-status"
                                        data-id="{{ $data->id }}" data-name="{{ $data->study_program_name }}"
                                        data-status="{{ $data->is_active ? 'disable' : 'activate' }}"
                                        data-url="{{ route('studyProgram.toggleStatus', $data->id) }}"
                                        data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="{{ $data->is_active ? 'Disable Study Program' : 'Activate Study Program' }}">

                                        <iconify-icon
                                            icon="{{ $data->is_active ? 'solar:bill-cross-bold-duotone' : 'solar:bill-check-bold-duotone' }}"
                                            width="1em" height="1em">
                                        </iconify-icon>
                                    </button>

                                    <a href="{{ route('studyProgram.edit', $data->id) }}">
                                        <button class="btn btn-outline-success" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                            data-bs-title="Edit">
                                            <iconify-icon icon="solar:clapperboard-edit-linear" width="1em"
                                                height="1em"></iconify-icon>
                                        </button>
                                    </a>

                                    <button type="button" class="btn bg-danger-subtle text-danger btn-delete"
                                        data-id="{{ $data->id }}" data-name="{{ $data->study_program_name }}"
                                        data-url="{{ route('studyProgram.destroy', $data->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Delete Study Program">
                                        <iconify-icon icon="solar:trash-bin-trash-bold-duotone" width="1em"
                                            height="1em"></iconify-icon>
                                    </button>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net/js/jquery.dataTables.min.js">
    </script>
    {{-- {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}} --}}

    <script>
        $("#table").DataTable({
            scrollX: true,
            scrollY: false
        });

        $(document).on('click', '.btn-toggle-status', function(e) {
            e.preventDefault();

            const url = $(this).data('url');
            const name = $(this).data('name');
            const status = $(this).data('status'); // 'disable' atau 'activate'
            const text = status === 'disable' ? 'disable' : 'activate';
            const icon = status === 'disable' ? 'warning' : 'question';

            Swal.fire({
                title: 'Are you sure?',
                html: `Want to <strong>${text} ${name}</strong> study program?`,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: status === 'disable' ? '#d33' : '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Success!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Failed!',
                                'Something went wrong.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-delete', function() {
            const name = $(this).data('name');
            const url = $(this).data('url');
            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                html: `The <strong>${name}</strong> Study program will deleted.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete It!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire('Success!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            Swal.fire('Failed!', 'Something when wrong.',
                                'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
