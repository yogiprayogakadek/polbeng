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
        $projectCategory = ProjectCategory::where('uuid', $uuid)->firstOrFail();
        $projectCategoryID = $projectCategory->id;
        $projects = Project::with(['projectCategory.studyProgram.department', 'detail'])
            ->where('project_category_id', $projectCategoryID)
            ->orderBy('created_at', 'desc')
            ->paginate(3);
        return view('front_end.project.index', compact('projects', 'projectCategoryID'));
    }

    public function loadMore(Request $request)
    {
        $query = $request->get('query');
        $projectCategoryID = $request->get('projectCategoryID');

        $projects = Project::with(['projectCategory.studyProgram.department', 'detail'])
            ->where('project_category_id', $projectCategoryID)
            ->when($query, function ($q) use ($query) {
                $q->where(function ($subQuery) use ($query) {
                    $subQuery->where('project_title', 'like', "%{$query}%")
                        ->orWhere('id', $query)
                        ->orWhereHas('detail', function ($q2) use ($query) {
                            $q2->where('description', 'like', "%{$query}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        $html = view('front_end.project.partials.project_card', compact('projects'))->render();

        return response()->json($html);
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $projectCategoryID = $request->get('projectCategoryID');
        $q = Project::with(['projectCategory.studyProgram.department', 'detail'])
            ->where('project_category_id', $projectCategoryID)
            ->when($query, function ($q) use ($query) {
                $q->where('project_title', 'like', "%$query%")
                    ->orWhereHas('detail', function ($q2) use ($query) {
                        $q2->where('description', 'like', "%$query%");
                    });
            })
            // ->where('project_category_id', $projectCategoryID)
            ->orderBy('created_at', 'desc');

        $projects = $query == null ? $q->get() : $q->paginate(3);
        // ->paginate(6);

        $html = view('front_end.project.partials.project_card', compact('projects'))->render();

        return response()->json($html);
    }

    public function detail($slug, $uuid)
    {
        $project = Project::with('detail.galleries')->where('uuid', $uuid)->firstOrFail();
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
            ->leftJoin('projects', 'project_categories.id', '=', 'projects.project_category_id')
            ->leftJoin('study_programs', 'project_categories.study_program_id', '=', 'study_programs.id')
            ->where('study_programs.id', $id)
            ->groupBy('project_categories.id', 'project_categories.project_category_name', 'project_categories.uuid')
            ->having('total', '>', 0)
            ->get();

        $view = view('front_end.department.partials.accordion', compact('totalProjects', 'departmentID'))->render();

        return response()->json([
            'html' => $view
        ]);
    }
}
