<div class="col-md-3">
    <div class="card shadow rounded-4 p-3 bg-primary-subtle border-0">
        <div class="d-flex align-items-center">
            <div class="bg-primary p-3 rounded-circle me-3">
                <iconify-icon icon="solar:buildings-2-bold" width="24" height="24" class="text-white"></iconify-icon>
            </div>
            <div>
                <h6 class="fw-semibold mb-0">Departments</h6>
                <h4 class="fw-bold">{{ $departmentsCount }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card shadow rounded-4 p-3 bg-info-subtle border-0">
        <div class="d-flex align-items-center">
            <div class="bg-info p-3 rounded-circle me-3">
                <iconify-icon icon="solar:book-broken" width="24" height="24" class="text-white"></iconify-icon>
            </div>
            <div>
                <h6 class="fw-semibold mb-0">Study Programs</h6>
                <h4 class="fw-bold">{{ $studyProgramsCount }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card shadow rounded-4 p-3 bg-warning-subtle border-0">
        <div class="d-flex align-items-center">
            <div class="bg-warning p-3 rounded-circle me-3">
                <iconify-icon icon="solar:folder-broken" width="24" height="24"
                    class="text-white"></iconify-icon>
            </div>
            <div>
                <h6 class="fw-semibold mb-0">Project Categories</h6>
                <h4 class="fw-bold">{{ $projectCategoriesCount }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card shadow rounded-4 p-3 bg-success-subtle border-0">
        <div class="d-flex align-items-center">
            <div class="bg-success p-3 rounded-circle me-3">
                <iconify-icon icon="solar:archive-broken" width="24" height="24"
                    class="text-white"></iconify-icon>
            </div>
            <div>
                <h6 class="fw-semibold mb-0">Total Projects</h6>
                <h4 class="fw-bold">{{ $projectsCount }}</h4>
            </div>
        </div>
    </div>
</div>

{{-- Approval Pipeline Stats --}}
@if(auth()->user()->isAdmin() || auth()->user()->isKaprodi() || auth()->user()->isDosen())
<div class="col-md-4">
    <div class="card shadow rounded-4 p-3 border-start border-4 border-warning">
        <div class="d-flex align-items-center">
            <div class="bg-warning-subtle p-3 rounded-circle me-3 text-warning">
                <iconify-icon icon="solar:shield-warning-bold" width="24" height="24"></iconify-icon>
            </div>
            <div>
                <h6 class="fw-semibold mb-0">Pending Validation (Dosen)</h6>
                <h4 class="fw-bold">{{ $pendingDosenCount }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow rounded-4 p-3 border-start border-4 border-info">
        <div class="d-flex align-items-center">
            <div class="bg-info-subtle p-3 rounded-circle me-3 text-info">
                <iconify-icon icon="solar:shield-check-bold" width="24" height="24"></iconify-icon>
            </div>
            <div>
                <h6 class="fw-semibold mb-0">Verified by Dosen</h6>
                <h4 class="fw-bold">{{ $verifiedDosenCount }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card shadow rounded-4 p-3 border-start border-4 border-success">
        <div class="d-flex align-items-center">
            <div class="bg-success-subtle p-3 rounded-circle me-3 text-success">
                <iconify-icon icon="solar:check-circle-bold" width="24" height="24"></iconify-icon>
            </div>
            <div>
                <h6 class="fw-semibold mb-0">Approved Projects</h6>
                <h4 class="fw-bold">{{ $approvedCount }}</h4>
            </div>
        </div>
    </div>
</div>
@endif
