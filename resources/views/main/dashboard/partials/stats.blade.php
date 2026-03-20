<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .glass-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px 0 rgba(31, 38, 135, 0.12);
        background: rgba(255, 255, 255, 0.85);
    }

    .stat-icon-wrapper {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
    }

    .stat-icon-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
    }

    .bg-gradient-primary-glass { background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%); }
    .bg-gradient-info-glass { background: linear-gradient(135deg, #0ea5e9 0%, #22d3ee 100%); }
    .bg-gradient-warning-glass { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); }
    .bg-gradient-success-glass { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); }
</style>

<div class="col-md-3" data-aos="fade-up" data-aos-delay="0">
    <div class="card glass-card rounded-4 p-4 border-0 h-100">
        <div class="d-flex align-items-center mb-3">
            <div class="stat-icon-wrapper bg-gradient-primary-glass shadow-sm me-3">
                <iconify-icon icon="solar:buildings-2-bold-duotone" width="28" height="28" class="text-white"></iconify-icon>
            </div>
            <div>
                <h6 class="text-muted fw-semibold mb-0 fs-2 uppercase tracking-wider">Departments</h6>
            </div>
        </div>
        <div class="d-flex align-items-baseline">
            <h3 class="fw-bold mb-0 text-dark counter">{{ $departmentsCount }}</h3>
        </div>
    </div>
</div>

<div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
    <div class="card glass-card rounded-4 p-4 border-0 h-100">
        <div class="d-flex align-items-center mb-3">
            <div class="stat-icon-wrapper bg-gradient-info-glass shadow-sm me-3">
                <iconify-icon icon="solar:book-bookmark-bold-duotone" width="28" height="28" class="text-white"></iconify-icon>
            </div>
            <div>
                <h6 class="text-muted fw-semibold mb-0 fs-2 uppercase tracking-wider">Study Programs</h6>
            </div>
        </div>
        <div class="d-flex align-items-baseline">
            <h3 class="fw-bold mb-0 text-dark counter">{{ $studyProgramsCount }}</h3>
        </div>
    </div>
</div>

<div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
    <div class="card glass-card rounded-4 p-4 border-0 h-100">
        <div class="d-flex align-items-center mb-3">
            <div class="stat-icon-wrapper bg-gradient-warning-glass shadow-sm me-3">
                <iconify-icon icon="solar:folder-with-files-bold-duotone" width="28" height="28" class="text-white"></iconify-icon>
            </div>
            <div>
                <h6 class="text-muted fw-semibold mb-0 fs-2 uppercase tracking-wider">Categories</h6>
            </div>
        </div>
        <div class="d-flex align-items-baseline">
            <h3 class="fw-bold mb-0 text-dark counter">{{ $projectCategoriesCount }}</h3>
        </div>
    </div>
</div>

<div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
    <div class="card glass-card rounded-4 p-4 border-0 h-100">
        <div class="d-flex align-items-center mb-3">
            <div class="stat-icon-wrapper bg-gradient-success-glass shadow-sm me-3">
                <iconify-icon icon="solar:star-fall-bold-duotone" width="28" height="28" class="text-white"></iconify-icon>
            </div>
            <div>
                <h6 class="text-muted fw-semibold mb-0 fs-2 uppercase tracking-wider">Total Projects</h6>
            </div>
        </div>
        <div class="d-flex align-items-baseline">
            <h3 class="fw-bold mb-0 text-dark counter">{{ $projectsCount }}</h3>
        </div>
    </div>
</div>

{{-- Approval Pipeline Stats --}}
@if(auth()->user()->isAdmin() || auth()->user()->isKaprodi() || auth()->user()->isDosen())
<div class="col-12 mt-4">
    <h5 class="fw-bold text-dark mb-3 px-1">Validation Pipeline</h5>
</div>

<div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
    <div class="card glass-card border-start border-warning border-4 rounded-4 p-4">
        <div class="d-flex align-items-center">
            <div class="stat-icon-wrapper bg-warning bg-opacity-10 text-warning me-3">
                <iconify-icon icon="solar:shield-warning-bold-duotone" width="28" height="28"></iconify-icon>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-dark">{{ $pendingDosenCount }}</h3>
                <h6 class="text-muted fw-semibold mb-0 fs-2">Waiting for Dosen</h6>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
    <div class="card glass-card border-start border-info border-4 rounded-4 p-4">
        <div class="d-flex align-items-center">
            <div class="stat-icon-wrapper bg-info bg-opacity-10 text-info me-3">
                <iconify-icon icon="solar:shield-check-bold-duotone" width="28" height="28"></iconify-icon>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-dark">{{ $verifiedDosenCount }}</h3>
                <h6 class="text-muted fw-semibold mb-0 fs-2">Verified/Waiting Kaprodi</h6>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
    <div class="card glass-card border-start border-success border-4 rounded-4 p-4">
        <div class="d-flex align-items-center">
            <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success me-3">
                <iconify-icon icon="solar:check-circle-bold-duotone" width="28" height="28"></iconify-icon>
            </div>
            <div>
                <h3 class="fw-bold mb-0 text-dark">{{ $approvedCount }}</h3>
                <h6 class="text-muted fw-semibold mb-0 fs-2">Final Approved</h6>
            </div>
        </div>
    </div>
</div>
@endif
