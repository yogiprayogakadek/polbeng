<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudyProgramStoreRequest;
use App\Http\Requests\StudyProgramUpdateRequest;
use App\Models\Department;
use App\Models\StudyProgram;
use Illuminate\Http\Request;

class StudyProgramController extends Controller
{
    public function index()
    {
        $data = StudyProgram::with('department')->get();

        return view('main.study_program.index', compact('data'));
    }

    public function create()
    {
        // $departments = Department::pluck('department_code', 'id')->prepend('Choose department code/name...', '');
        $departments = Department::select('id', 'department_code', 'department_name')
            ->where('is_active', true)
            ->get()
            ->mapWithKeys(fn($d) => [
                $d->id => "$d->department_code - $d->department_name"
            ])->prepend('Choose...', '');
        // dd($departments);
        return view('main.study_program.create', compact('departments'));
    }

    public function store(StudyProgramStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $studyProgram = [
                'department_id' => $data['department_id'],
                'study_program_code' => $data['study_program_code'],
                'study_program_name' => $data['study_program_name'],
            ];

            StudyProgram::create($studyProgram);

            return redirect()->back()->with('success', 'Study program data was successfully saved.');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $departments = Department::select('id', 'department_code', 'department_name')
            ->where('is_active', true)
            ->get()
            ->mapWithKeys(fn($d) => [
                $d->id => "$d->department_code - $d->department_name"
            ])->prepend('Choose...', '');

        $studyProgram = StudyProgram::findOrFail($id);

        return view('main.study_program.update', compact('departments', 'studyProgram'));
    }

    public function update(StudyProgramUpdateRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $studyProgram = StudyProgram::findOrFail($id);
            $studyProgram->update([
                'department_id' => $data['department_id'],
                'study_program_code' => $data['study_program_code'],
                'study_program_name' => $data['study_program_name'],
            ]);
            return redirect()->route('studyProgram.index')->with('success', 'Study program data was successfully saved.');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $studyProgram = StudyProgram::findOrFail($id);

        $studyProgram->is_active = !$studyProgram->is_active;
        $studyProgram->save();

        return response()->json([
            'status' => true,
            'message' => 'Study program ' . ($studyProgram->is_active ? 'activated' : 'disabled') . ' successfully.'
        ]);
    }

    public function destroy($id)
    {
        try {
            $studyProgram = StudyProgram::findOrFail($id);

            // Delete study program data
            $studyProgram->delete();

            return response()->json([
                'status' => true,
                'message' => 'Study program data successfully deleted.'
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
        $data = StudyProgram::onlyTrashed()->get();
        // dd($data[0]->id);
        return view('main.study_program.restore', compact('data'));
    }

    public function restore($id)
    {
        try {
            $studyProgram = StudyProgram::onlyTrashed()->findOrFail($id);
            $studyProgram->restore();

            return response()->json([
                'status' => true,
                'message' => 'Study program data was successfully recovered.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to recover data: ' . $th->getMessage()
            ], 500);
        }
    }
}
