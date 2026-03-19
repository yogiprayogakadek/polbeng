<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProjectApprovalController extends Controller
{
    // DOSEN PEMBIMBING SECTION
    public function dosenIndex()
    {
        return view('main.approval.dosen.index');
    }

    public function dosenData(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->get('status');
            $projects = Project::with(['projectCategory.studyProgram', 'dosenPembimbing'])
                ->where('dosen_pembimbing_id', auth()->id())
                ->when($status, function ($query) use ($status) {
                    if ($status === 'pending') {
                        $query->where('status', Project::STATUS_PENDING);
                    } elseif ($status === 'processed') {
                        $query->whereIn('status', [
                            Project::STATUS_VERIFIED_DOSEN,
                            Project::STATUS_REJECTED_DOSEN,
                            Project::STATUS_APPROVED,
                            Project::STATUS_REJECTED_KAPRODI
                        ]);
                    }
                })
                ->select('projects.*');

            return DataTables::eloquent($projects)
                ->addIndexColumn()
                ->addColumn('category_name', function ($project) {
                    return '<span class="fw-semibold text-dark">' . $project->projectCategory->studyProgram->study_program_name . '</span><br>' .
                           '<span class="text-muted fs-2">' . $project->projectCategory->project_category_name . '</span>';
                })
                ->addColumn('status_label', function ($project) {
                    $badges = [
                        Project::STATUS_PENDING => '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:clock-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Pending</span>',
                        Project::STATUS_VERIFIED_DOSEN => '<span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:check-read-bold-duotone" class="align-middle me-1"></iconify-icon> Verified</span>',
                        Project::STATUS_REJECTED_DOSEN => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:close-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Rejected</span>',
                        Project::STATUS_APPROVED => '<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:check-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Approved</span>',
                        Project::STATUS_REJECTED_KAPRODI => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:close-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Rejected (K)</span>',
                    ];
                    return $badges[$project->status] ?? $project->status;
                })
                ->addColumn('action', function ($project) {
                    $btn = '<div class="d-flex gap-2">';
                    if ($project->status === Project::STATUS_PENDING) {
                        $btn .= '<button class="btn btn-primary d-flex align-items-center btn-verify" data-id="' . $project->id . '" data-title="' . $project->project_title . '">
                                    <iconify-icon icon="solar:shield-check-bold" class="me-1"></iconify-icon> Process
                                 </button>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['category_name', 'status_label', 'action'])
                ->make(true);
        }
    }

    public function dosenVerify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified_by_dosen,rejected_by_dosen',
            'rejection_reason' => 'required_if:status,rejected_by_dosen'
        ]);

        try {
            $project = Project::where('dosen_pembimbing_id', auth()->id())
                ->where('status', Project::STATUS_PENDING)
                ->findOrFail($id);

            $project->update([
                'status' => $request->status,
                'rejection_reason' => $request->status == Project::STATUS_REJECTED_DOSEN ? $request->rejection_reason : null
            ]);

            return response()->json(['status' => true, 'message' => 'Project status updated successfully.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    // KAPRODI SECTION
    public function kaprodiIndex()
    {
        return view('main.approval.kaprodi.index');
    }

    public function kaprodiData(Request $request)
    {
        if ($request->ajax()) {
            $status = $request->get('status');
            $projects = Project::with(['projectCategory.studyProgram', 'dosenPembimbing'])
                ->when($status, function ($query) use ($status) {
                    if ($status === 'pending_dosen') {
                        $query->where('status', Project::STATUS_PENDING);
                    } elseif ($status === 'verified_dosen') {
                        $query->where('status', Project::STATUS_VERIFIED_DOSEN);
                    } elseif ($status === 'approved') {
                        $query->where('status', Project::STATUS_APPROVED);
                    }
                })
                ->select('projects.*');

            return DataTables::eloquent($projects)
                ->addIndexColumn()
                ->addColumn('category_name', function ($project) {
                    return '<span class="fw-semibold text-dark">' . $project->projectCategory->studyProgram->study_program_name . '</span><br>' .
                           '<span class="text-muted fs-2">' . $project->projectCategory->project_category_name . '</span>';
                })
                ->addColumn('dosen_pembimbing', function ($project) {
                    return '<div class="d-flex align-items-center">
                                <div class="ms-0">
                                    <h6 class="mb-0 fs-3">' . ($project->dosenPembimbing->name ?? '-') . '</h6>
                                    <span class="text-muted fs-2">Dosen Pembimbing</span>
                                </div>
                            </div>';
                })
                ->addColumn('status_label', function ($project) {
                    $badges = [
                        Project::STATUS_PENDING => '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:clock-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Pending (Dosen)</span>',
                        Project::STATUS_VERIFIED_DOSEN => '<span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:check-read-bold-duotone" class="align-middle me-1"></iconify-icon> Verified (Dosen)</span>',
                        Project::STATUS_REJECTED_DOSEN => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:close-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Rejected (Dosen)</span>',
                        Project::STATUS_APPROVED => '<span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:check-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Approved</span>',
                        Project::STATUS_REJECTED_KAPRODI => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill"><iconify-icon icon="solar:close-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Rejected (K)</span>',
                    ];
                    return $badges[$project->status] ?? $project->status;
                })
                ->addColumn('action', function ($project) {
                    $btn = '<div class="d-flex gap-2">';
                    if ($project->status === Project::STATUS_VERIFIED_DOSEN) {
                        $btn .= '<button class="btn btn-success d-flex align-items-center btn-approve" data-id="' . $project->id . '" data-title="' . $project->project_title . '">
                                    <iconify-icon icon="solar:check-read-bold" class="me-1"></iconify-icon> Approve
                                 </button>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['category_name', 'dosen_pembimbing', 'status_label', 'action'])
                ->make(true);
        }
    }

    public function kaprodiApprove(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected_by_kaprodi',
            'rejection_reason' => 'required_if:status,rejected_by_kaprodi'
        ]);

        try {
            $project = Project::where('status', Project::STATUS_VERIFIED_DOSEN)
                ->findOrFail($id);

            $project->update([
                'status' => $request->status,
                'rejection_reason' => $request->status == Project::STATUS_REJECTED_KAPRODI ? $request->rejection_reason : null
            ]);

            return response()->json(['status' => true, 'message' => 'Project status updated successfully.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
