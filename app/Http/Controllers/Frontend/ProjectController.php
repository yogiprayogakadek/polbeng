<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index($uuid)
    {
        $projectCategory = ProjectCategory::withTrashed()->with(['studyProgram' => function ($q) {
            $q->withTrashed();
        }, 'studyProgram.department' => function ($q) {
            $q->withTrashed();
        }])->where('uuid', $uuid)->firstOrFail();
        $projectCategoryID = $projectCategory->id;

        $projects = Project::with(['projectCategory.studyProgram.department', 'detail'])
            ->approved()
            ->where('project_category_id', $projectCategoryID)
            ->orderBy('school_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $allYears = Project::approved()
            ->where('project_category_id', $projectCategoryID)
            ->distinct()
            ->orderBy('school_year', 'desc')
            ->pluck('school_year');

        return view('front_end.project.index', compact('projects', 'projectCategoryID', 'projectCategory', 'allYears'));
    }

    public function loadMore(Request $request)
    {
        $projects = $this->getFilteredProjects($request);
        
        if ($projects->isEmpty()) {
            return response()->json('');
        }

        $html = view('front_end.project.partials.project_card', compact('projects'))->render();
        return response()->json($html);
    }

    public function search(Request $request)
    {
        $projects = $this->getFilteredProjects($request);
        $html = view('front_end.project.partials.project_card', compact('projects'))->render();
        return response()->json($html);
    }

    private function getFilteredProjects(Request $request)
    {
        $query = $request->get('query');
        $year = $request->get('year');
        $projectCategoryID = $request->get('projectCategoryID');

        return Project::with(['projectCategory.studyProgram.department', 'detail'])
            ->approved()
            ->where('project_category_id', $projectCategoryID)
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('project_title', 'like', "%{$query}%")
                        ->orWhereHas('detail', function ($q2) use ($query) {
                            $q2->where('description', 'like', "%{$query}%");
                        });
                });
            })
            ->when($year, function ($q) use ($year) {
                $q->where('school_year', $year);
            })
            ->orderBy('school_year', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(6);
    }

    public function detail($slug, $uuid)
    {
        $project = Project::withTrashed()->with(['detail.galleries', 'projectCategory' => function ($q) {
            $q->withTrashed();
        }])->where('uuid', $uuid)->firstOrFail();
        $relatedProjects = Project::where(
            'project_category_id',
            $project->project_category_id,
        )
            ->where('id', '!=', $project->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();
        return view('front_end.project_detail.index', compact('project', 'relatedProjects'));
    }

    public function departmentProject($slug, $uuid)
    {
        $studyPrograms = StudyProgram::with('department')
            ->whereHas('department', function ($q) use ($uuid) {
                $q->where('uuid', $uuid);
            })->get();

        return view('front_end.department.index', compact('studyPrograms'));
    }

    public function totalProjectByStudyProgram($id)
    {
        $departmentID = StudyProgram::findOrFail($id)->department_id;
        $totalProjects = DB::table('project_categories')
            ->select(
                'project_categories.uuid',
                'project_categories.project_category_name',
                'project_categories.id as project_category_id',
                DB::raw('COUNT(projects.id) as total')
            )
            ->leftJoin('projects', function ($join) {
                $join->on('project_categories.id', '=', 'projects.project_category_id')
                    ->where('projects.status', Project::STATUS_APPROVED)
                    ->whereNull('projects.deleted_at');
            })
            ->leftJoin('study_programs', 'project_categories.study_program_id', '=', 'study_programs.id')
            ->where('study_programs.id', $id)
            ->whereNull('project_categories.deleted_at')
            ->where('project_categories.is_active', true)
            ->groupBy('project_categories.id', 'project_categories.project_category_name', 'project_categories.uuid')
            ->get();

        $view = view('front_end.department.partials.accordion', compact('totalProjects', 'departmentID'))->render();

        return response()->json([
            'html' => $view
        ]);
    }
}
