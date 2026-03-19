@extends('template.master')

@section('page-title', 'Deleted Users')

@push('css')
    <link rel="stylesheet"
        href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Deleted Users</h5>

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
                                <td>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                                <td>
                                    <button class="btn btn-outline-warning btn-restore" data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}" data-url="{{ route('user.restore', $user->id) }}"
                                        data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                                        data-bs-placement="top" data-bs-title="Restore User">
                                        <iconify-icon icon="solar:history-bold-duotone" width="1em"
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

        $(document).on('click', '.btn-restore', function() {
            const name = $(this).data('name');
            const url = $(this).data('url');

            Swal.fire({
                title: 'Are you sure?',
                html: `Want to restore user <strong>${name}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, Restore',
                cancelButtonText: 'Cancel'
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
                        error: function() {
                            Swal.fire('Failed!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
