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
            <h5 class="card-title fw-semibold mb-4">Restore Study Program</h5>

            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered text-nowrap align-middle" width="100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Department Code/Name</th>
                            <th>Study Program Code</th>
                            <th>Study Program Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $data)
                            <tr>
                                <td>
                                    <button type="button" class="btn bg-info-subtle text-info btn-restore"
                                        data-id="{{ $data->id }}" data-name="{{ $data->study_program_name }}"
                                        data-url="{{ route('studyProgram.restore', $data->id) }}" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                        data-bs-title="Restore">
                                        <iconify-icon icon="solar:refresh-bold-duotone" width="1em"
                                            height="1em"></iconify-icon>
                                    </button>
                                </td>
                                <td>{{ $data->department->department_code . ' - ' . $data->department->department_name }}
                                </td>
                                <td>{{ $data->study_program_code }}</td>
                                <td>{{ $data->study_program_name }}</td>
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
                html: `The <strong>${name}</strong> Study program will be restored.`,
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
