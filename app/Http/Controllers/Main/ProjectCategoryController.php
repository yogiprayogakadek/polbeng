<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCategoryStoreRequest;
use App\Http\Requests\ProjectCategoryUpdateRequest;
use App\Models\ProjectCategory;
use App\Models\StudyProgram;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    public function index()
    {
        $projectCategories = ProjectCategory::with('studyProgram')->get();

        return view('main.project_category.index', compact('projectCategories'));
    }

    public function create()
    {
        $studyPrograms = StudyProgram::select('id', 'study_program_code', 'study_program_name')
            ->where('is_active', true)
            ->get()
            ->mapWithKeys(fn($d) => [
                $d->id => "$d->study_program_code - $d->study_program_name"
            ])->prepend('Choose...', '');

        return view('main.project_category.create', compact('studyPrograms'));
    }

    public function store(ProjectCategoryStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $projectCategory = [
                'study_program_id' => $data['study_program_id'],
                'project_category_name' => $data['project_category_name'],
            ];

            ProjectCategory::create($projectCategory);

            return redirect()->back()->with('success', 'Project category data was successfully saved.');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $studyPrograms = StudyProgram::select('id', 'study_program_code', 'study_program_name')
            ->where('is_active', true)
            ->get()
            ->mapWithKeys(fn($d) => [
                $d->id => "$d->study_program_code - $d->study_program_name"
            ])->prepend('Choose...', '');

        $projectCategory = ProjectCategory::findOrFail($id);

        return view('main.project_category.update', compact('studyPrograms', 'projectCategory'));
    }

    public function update(ProjectCategoryUpdateRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $projectCategory = ProjectCategory::findOrFail($id);
            $projectCategory->update([
                'study_program_id' => $data['study_program_id'],
                'project_category_name' => $data['project_category_name'],
            ]);
            return redirect()->route('projectCategory.index')->with('success', 'Project category data was successfully saved.');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $projectCategory = ProjectCategory::findOrFail($id);

        $projectCategory->is_active = !$projectCategory->is_active;
        $projectCategory->save();

        return response()->json([
            'status' => true,
            'message' => 'Project category ' . ($projectCategory->is_active ? 'activated' : 'disabled') . ' successfully.'
        ]);
    }

    public function destroy($id)
    {
        try {
            $projectCategory = ProjectCategory::findOrFail($id);

            // Delete project category data
            $projectCategory->delete();

            return response()->json([
                'status' => true,
                'message' => 'Project category data successfully deleted.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'There is an error: ' . $th->getMessage()
            ], 500);
        }
    }

    public function showRestore()
    {
        $data = ProjectCategory::onlyTrashed()->get();
        // dd($data[0]->id);
        return view('main.project_category.restore', compact('data'));
    }

    public function restore($id)
    {
        try {
            $projectCategory = ProjectCategory::onlyTrashed()->findOrFail($id);
            $projectCategory->restore();

            return response()->json([
                'status' => true,
                'message' => 'Project category data was successfully recovered.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to recover data: ' . $th->getMessage()
            ], 500);
        }
    }
}
