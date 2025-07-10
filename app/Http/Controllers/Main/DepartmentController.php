<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $data = Department::all();

        return view('main.department.index', compact('data'));
    }

    public function create()
    {
        return view('main.department.create');
    }

    public function store(DepartmentStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $department = [
                'department_code' => $data['department_code'],
                'department_name' => $data['department_name'],
            ];

            Department::create($department);

            return redirect()->back()->with('success', 'Department data was successfully saved.');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('main.department.update', compact('department'));
    }

    public function update(DepartmentUpdateRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $department = Department::findOrFail($id);
            $department->update([
                'department_code' => $data['department_code'],
                'department_name' => $data['department_name'],
            ]);
            return redirect()->route('department.index')->with('success', 'Department data was successfully saved.');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $department = Department::findOrFail($id);

        $department->is_active = !$department->is_active;
        $department->save();

        return response()->json([
            'status' => true,
            'message' => 'Department ' . ($department->is_active ? 'activated' : 'disabled') . ' successfully.'
        ]);
    }

    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);

            // Delete department data
            $department->delete();

            return response()->json([
                'status' => true,
                'message' => 'Department data successfully deleted.'
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
        $data = Department::onlyTrashed()->get();
        // dd($data[0]->id);
        return view('main.department.restore', compact('data'));
    }

    public function restore($id)
    {
        try {
            $department = Department::onlyTrashed()->findOrFail($id);
            $department->restore();

            return response()->json([
                'status' => true,
                'message' => 'Department data was successfully recovered.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to recover data: ' . $th->getMessage()
            ], 500);
        }
    }
}
