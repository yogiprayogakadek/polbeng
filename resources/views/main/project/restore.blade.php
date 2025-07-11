@extends('template.master')

@section('page-title', 'Project')

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
            <h5 class="card-title fw-semibold mb-4">Deleted Items Project</h5>

            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered text-nowrap align-middle" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Project Thumbnail</th>
                            <th>Project Title</th>
                            <th>Category Name</th>
                            <th>School Year</th>
                            <th>Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $project)
                            <tr>
                                <td>
                                    <button type="button" class="btn bg-info-subtle text-info btn-restore"
                                        data-id="{{ $project->id }}" data-name="{{ $project->project_title }}"
                                        data-url="{{ route('project.restore', $project->id) }}" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                        data-bs-title="Restore">
                                        <iconify-icon icon="solar:refresh-bold-duotone" width="1em"
                                            height="1em"></iconify-icon>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <img src="{{ asset('storage/' . $project->thumbnail) }}" width="70"
                                        class="img-thumbnail" />
                                </td>
                                <td>{{ $project->project_title }}</td>
                                <td>{{ $project->projectCategory->studyProgram->study_program_name . ' - ' . $project->projectCategory->project_category_name }}
                                </td>
                                <td>{{ $project->school_year }}</td>
                                <td>{{ $project->semester }}</td>
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

        $(document).on('click', '.btn-restore', function() {
            const name = $(this).data('name');
            const url = $(this).data('url');

            Swal.fire({
                title: 'Pulihkan Data?',
                html: `The <strong>${name}</strong> Project category will be restored.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Recover!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Success!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(err) {
                            Swal.fire('Failed!', 'An error occurred while restoring data.',
                                'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
