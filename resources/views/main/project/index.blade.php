@extends('template.master')

@section('page-title', 'Project')

@push('css')
    <link rel="stylesheet"
        href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
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
            <table id="table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th data-priority="1">Thumbnail</th>
                        <th data-priority="1">Project Title</th>
                        <th>Category</th>
                        <th data-priority="2">School Year</th>
                        <th>Semester</th>
                        <th>Detail</th>
                        <th>Galleries</th>
                        <th data-priority="3">Status</th>
                        <th data-priority="1">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </div>
@endsection

@push('script')
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net/js/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
    <script>
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('project.data') }}",
            columns: [{
                    data: 'thumbnail',
                    name: 'thumbnail',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'project_title',
                    name: 'project_title'
                },
                {
                    data: 'category_name',
                    name: 'category_name',
                    orderable: false
                },
                {
                    data: 'school_year',
                    name: 'school_year'
                },
                {
                    data: 'semester',
                    name: 'semester'
                },
                {
                    data: 'project_detail',
                    name: 'project_detail',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'galleries',
                    name: 'galleries',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'is_active'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            responsive: true,
            initComplete: function() {
                // Inisialisasi tooltip setelah tabel selesai dimuat
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
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

        $('body').on('click', '.modal-btn', function() {
            let url = $(this).data('url');
            let modalID = $(this).data('modal-id');
            $.get(url, function(response) {
                let htmlContent = '';

                if (typeof response === 'object' && response.status !== undefined) {
                    htmlContent = response.html;
                } else {
                    htmlContent = response; // fallback for general response (without JSON wrapper)
                }

                $('.modal-render').html(htmlContent);
                $('#' + modalID).modal('show');

                // Re-initialize GLightbox if exists
                if (typeof GLightbox === 'function') {
                    GLightbox({
                        selector: '.glightbox',
                        touchNavigation: true,
                        loop: true,
                        zoomable: true
                    });
                }

                // re-run delete event if exists
                if (typeof bindDeleteButtons === 'function') {
                    bindDeleteButtons();
                }
            });
        });
    </script>
@endpush
