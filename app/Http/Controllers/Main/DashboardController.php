<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $departmentsCount = Department::count();
        $studyProgramsCount = StudyProgram::count();
        $projectCategoriesCount = ProjectCategory::count();
        $projectsCount = Project::count();

        $recentProjects = Project::with('projectCategory')
            ->latest()
            ->take(5)
            ->get();

        $projectsPerYear = Project::selectRaw('school_year, COUNT(*) as total')
            ->groupBy('school_year')
            ->pluck('total', 'school_year');

        $projectsPerCategory = ProjectCategory::withCount('projects')->get();

        return view('main.dashboard.index', compact(
            'departmentsCount',
            'studyProgramsCount',
            'projectCategoriesCount',
            'projectsCount',
            'recentProjects',
            'projectsPerYear',
            'projectsPerCategory'
        ));
    }

    public function getProjectsPerYear(Request $request)
    {
        $year = $request->year;

        $query = Project::query();

        if ($year) {
            $query->where('school_year', $year);
        }

        $projectsPerYear = $query
            ->select('school_year', DB::raw('count(*) as total'))
            ->groupBy('school_year')
            ->pluck('total', 'school_year');

        return response()->json([
            'labels' => $projectsPerYear->keys()->toArray(),
            'data' => $projectsPerYear->values()->toArray()
        ]);
    }

    public function getProjectsPerCategory(Request $request)
    {
        $selectedCategory = $request->input('category');

        $query = ProjectCategory::withCount(['projects' => function ($q) use ($selectedCategory) {
            if (!empty($selectedCategory)) {
                $q->whereHas('projectCategory', function ($subQ) use ($selectedCategory) {
                    $subQ->where('project_category_name', $selectedCategory);
                });
            }
        }]);

        $categories = $query->get()->filter(function ($item) {
            return $item->projects_count > 0;
        });

        $labels = $categories->pluck('project_category_name');
        $data = $categories->pluck('projects_count');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function recentProjects(Request $request)
    {
        $year = $request->input('year');
        $category = $request->input('category');

        $query = Project::with('projectCategory');

        if ($year) {
            $query->where('school_year', $year);
        }

        if ($category) {
            $query->whereHas('projectCategory', function ($q) use ($category) {
                $q->where('project_category_name', $category);
            });
        }

        $projects = $query->orderBy('created_at', 'desc')->take(5)->get();

        $html = view('main.dashboard.partials.recent_projects_table', compact('projects'))->render();

        return response()->json(['html' => $html]);
    }

    public function projectsTrend(Request $request)
    {
        $year = $request->input('year');

        $query = Project::query();

        if ($year) {
            $query->where('school_year', $year);
        }

        $data = $query->selectRaw('school_year, COUNT(*) as total')
            ->groupBy('school_year')
            ->orderBy('school_year', 'asc')
            ->pluck('total', 'school_year');


        return response()->json([
            'labels' => $data->keys(),
            'data' => $data->values(),
        ]);
    }
}
