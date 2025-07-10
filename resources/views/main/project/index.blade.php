@extends('template.master')

@section('page-title', 'Project')

@push('css')
    <link rel="stylesheet"
        href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    {{-- modal render --}}
    <div class="modal-render"></div>

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
            <h5 class="card-title fw-semibold mb-4">Project List</h5>

            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered text-nowrap align-middle" width="100%">
                    <thead>
                        <tr>
                            <th>Project Thumbnail</th>
                            <th>Project Title</th>
                            <th>Category Name</th>
                            <th>School Year</th>
                            <th>Semester</th>
                            <th>Project Detail</th>
                            <th>Project Galleries</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('storage/' . $project->thumbnail) }}" width="70"
                                        class="img-thumbnail" />
                                </td>
                                <td>{{ $project->project_title }}</td>
                                <td>{{ $project->projectCategory->project_category_name }}</td>
                                <td>{{ $project->school_year }}</td>
                                <td>{{ $project->semester }}</td>
                                <td class="text-center">
                                    <button class="btn btn btn-outline-primary detail-btn"
                                        data-url="{{ route('project.detail', $project->id) }}"
                                        data-modal-id="projectDetailModal" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                        data-bs-title="Project Detail">
                                        <iconify-icon icon="solar:eye-line-duotone" width="1em"
                                            height="1em"></iconify-icon>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn btn-outline-primary galleries-btn"
                                        data-url="{{ route('project.galleries', $project->id) }}"
                                        data-modal-id="projectGalleriesModal" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                        data-bs-title="Project Galleries">
                                        <iconify-icon icon="solar:album-line-duotone" width="1em"
                                            height="1em"></iconify-icon>
                                    </button>
                                </td>
                                <td>
                                    <span
                                        class="badge text-bg-{{ $project->is_active == true ? 'primary' : 'warning' }}">{{ $project->is_active == true ? 'Active' : 'Disabled' }}</span>
                                </td>
                                <td>
                                    <button type="button"
                                        class="btn {{ $project->is_active ? 'bg-primary-subtle' : 'bg-warning-subtle text-warning' }} btn-toggle-status"
                                        data-id="{{ $project->id }}" data-name="{{ $project->project_title }}"
                                        data-status="{{ $project->is_active ? 'disable' : 'activate' }}"
                                        data-url="{{ route('project.toggleStatus', $project->id) }}"
                                        data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="{{ $project->is_active ? 'Disable Project' : 'Activate Project' }}">

                                        <iconify-icon
                                            icon="{{ $project->is_active ? 'solar:bill-cross-bold-duotone' : 'solar:bill-check-bold-duotone' }}"
                                            width="1em" height="1em">
                                        </iconify-icon>
                                    </button>

                                    <a href="{{ route('project.edit', $project->id) }}">
                                        <button class="btn btn-outline-success" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                            data-bs-title="Edit">
                                            <iconify-icon icon="solar:clapperboard-edit-linear" width="1em"
                                                height="1em"></iconify-icon>
                                        </button>
                                    </a>

                                    <button type="button" class="btn bg-danger-subtle text-danger btn-delete"
                                        data-id="{{ $project->id }}" data-name="{{ $project->project_title }}"
                                        data-url="{{ route('project.destroy', $project->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Delete Project">
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

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
                html: `Want to <strong>${text} <i>"${name}" </i></strong>Project?`,
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
                html: `The <strong><i>"${name}" </i></strong> Project will deleted.`,
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

        $('body').on('click', '.detail-btn', function() {
            let url = $(this).data('url');
            let modalID = $(this).data('modal-id');
            $.get(url, function(data) {
                $('.modal-render').html(data);
                $('#' + modalID).modal('show');
            });
        })
    </script>
@endpush
