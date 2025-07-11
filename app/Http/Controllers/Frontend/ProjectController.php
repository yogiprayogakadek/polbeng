<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($projectCategoryID)
    {
        $projects = Project::with(['projectCategory.studyProgram.department', 'detail'])
            ->where('project_category_id', $projectCategoryID)
            ->orderBy('created_at', 'desc')
            ->paginate(3);
        // dd($projects);
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
}
