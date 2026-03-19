@extends('template.master')

@section('page-title', 'Project Approval')

@push('css')
    <link rel="stylesheet"
        href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
@endpush

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h5 class="card-title fw-bold mb-1">Final Project Approval</h5>
                    <p class="text-muted mb-0 fs-2">Review and give final approval for verified projects.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <label class="form-label mb-0 fs-2 text-muted text-uppercase fw-semibold">Status Filter</label>
                        <select id="statusFilter" class="form-select form-select-sm border-0 bg-light-subtle fw-semibold" style="min-width: 200px;">
                            <option value="">All Projects</option>
                            <option value="pending_dosen">Wait Dosen</option>
                            <option value="verified_dosen" selected>Verified by Dosen</option>
                            <option value="approved">Approved</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle border-light" id="kaprodiApprovalTable">
                    <thead class="bg-light-subtle">
                        <tr>
                            <th class="ps-3 py-3 border-0">No</th>
                            <th class="py-3 border-0">Project Info</th>
                            <th class="py-3 border-0">Category & Dosen</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="pe-3 py-3 border-0 text-end">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Process Modal -->
    <div class="modal fade" id="processModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="processForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Final Project Approval</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="projectTitleDisplay" class="fw-bold"></p>
                        <div class="mb-3">
                            <label class="form-label">Action</label>
                            <select name="status" id="approvalStatus" class="form-select" required>
                                <option value="approved">Approve / Publish</option>
                                <option value="rejected_by_kaprodi">Reject</option>
                            </select>
                        </div>
                        <div class="mb-3" id="rejectionReasonWrapper" style="display: none;">
                            <label class="form-label">Rejection Reason</label>
                            <textarea name="rejection_reason" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Complete Approval</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/datatables.net/js/jquery.dataTables.min.js">
    </script>
    <script>
        $(document).ready(function() {
            let table = $('#kaprodiApprovalTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('kaprodi.data') }}",
                    data: function (d) {
                        d.status = $('#statusFilter').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'ps-3' },
                    { 
                        data: 'project_title', 
                        name: 'project_title',
                        render: function(data) {
                            return `<div class="fw-bold text-dark">${data}</div>`;
                        }
                    },
                    { 
                        data: 'category_name', 
                        name: 'category_name',
                        render: function(data, type, row) {
                            return `<div>${data}</div><div class="mt-1">${row.dosen_pembimbing}</div>`;
                        }
                    },
                    { data: 'status_label', name: 'status_label', className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'pe-3 text-end' }
                ],
                language: {
                    paginate: {
                        previous: '<iconify-icon icon="solar:alt-arrow-left-linear"></iconify-icon>',
                        next: '<iconify-icon icon="solar:alt-arrow-right-linear"></iconify-icon>'
                    }
                }
            });

            $('#statusFilter').on('change', function() {
                table.ajax.reload();
            });

            $('#approvalStatus').on('change', function() {
                if ($(this).val() === 'rejected_by_kaprodi') {
                    $('#rejectionReasonWrapper').show();
                } else {
                    $('#rejectionReasonWrapper').hide();
                }
            });

            let currentId = null;
            $(document).on('click', '.btn-approve', function() {
                currentId = $(this).data('id');
                $('#projectTitleDisplay').text($(this).data('title'));
                $('#processModal').modal('show');
            });

            $('#processForm').on('submit', function(e) {
                e.preventDefault();
                let url = "{{ route('kaprodi.approve', ':id') }}".replace(':id', currentId);
                
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#processModal').modal('hide');
                        table.ajax.reload();
                        Swal.fire('Success', response.message, 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON.message, 'error');
                    }
                });
            });
        });
    </script>
@endpush
