<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function homepage()
    {
        $departments = Department::where('is_active', true)
            ->get();

        // Calculate dynamic stats for the homepage impact section
        $stats = [
            'dev' => Project::approved()->whereIn('project_category_id', [1, 2, 10])->count(),
            'iot' => Project::approved()->whereIn('project_category_id', [3, 11])->count(),
            'media' => Project::approved()->whereIn('project_category_id', [4, 5, 6, 7, 8, 9, 12, 13, 14, 15])->count(),
            'total' => Project::approved()->count()
        ];

        return view('front_end.home_page.index', compact('departments', 'stats'));
    }

    public function projectCategory($departmentID)
    {
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
            ->where('study_programs.department_id', $departmentID)
            ->whereNull('project_categories.deleted_at')
            ->where('project_categories.is_active', true)
            ->groupBy('project_categories.id', 'project_categories.project_category_name', 'project_categories.uuid')
            ->get();


        $view = view('front_end.home_page.partials.tabs', compact('totalProjects', 'departmentID'))->render();

        return response()->json([
            'html' => $view
        ]);
    }

    public function globalSearch(Request $request)
    {
        $query = $request->get('query');
        if (!$query) {
            return response()->json(['html' => '']);
        }

        $projects = Project::with(['projectCategory.studyProgram.department', 'detail'])
            ->approved()
            ->where(function ($q) use ($query) {
                $q->where('project_title', 'like', "%{$query}%")
                    ->orWhereHas('detail', function ($q2) use ($query) {
                        $q2->where('description', 'like', "%{$query}%");
                    });
            })
            ->latest()
            ->limit(8)
            ->get();

        $view = view('front_end.home_page.partials.search_results', compact('projects'))->render();

        return response()->json([
            'html' => $view
        ]);
    }
}
