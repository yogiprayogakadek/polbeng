@extends('template.master')

@section('page-title', 'User Management')

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
            <h5 class="card-title fw-semibold mb-4">Users List</h5>

            <div class="table-responsive">
                <table id="table" class="table table-striped table-bordered text-nowrap align-middle" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}">
                                        <button class="btn btn-outline-success" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                            data-bs-title="Edit">
                                            <iconify-icon icon="solar:clapperboard-edit-linear" width="1em"
                                                height="1em"></iconify-icon>
                                        </button>
                                    </a>

                                    <button type="button" class="btn bg-danger-subtle text-danger btn-delete"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                        data-url="{{ route('user.destroy', $user->id) }}" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Delete User">
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

    <script>
        $("#table").DataTable({
            scrollX: true,
            scrollY: false
        });

        $(document).on('click', '.btn-delete', function() {
            const name = $(this).data('name');
            const url = $(this).data('url');
            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                html: `The user <strong>${name}</strong> will be deleted.`,
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
                            Swal.fire('Failed!', 'Something went wrong.',
                                'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
