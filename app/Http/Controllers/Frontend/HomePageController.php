<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\ProjectCategory;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function homepage()
    {
        $departments = Department::where('is_active', true)
            // ->with(['studyPrograms.projectCategories.projects'])
            ->get();
        return view('front_end.home_page.index', compact('departments'));
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
            ->leftJoin('projects', 'project_categories.id', '=', 'projects.project_category_id')
            ->leftJoin('study_programs', 'project_categories.study_program_id', '=', 'study_programs.id')
            ->where('study_programs.department_id', $departmentID)
            ->groupBy('project_categories.id', 'project_categories.project_category_name', 'project_categories.uuid')
            ->having('total', '>', 0)
            ->get();


        $view = view('front_end.home_page.partials.tabs', compact('totalProjects', 'departmentID'))->render();

        return response()->json([
            'html' => $view
        ]);
    }
}
