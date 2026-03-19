<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('main.user.index', compact('data'));
    }

    public function create()
    {
        return view('main.user.create');
    }

    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        try {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);

            return redirect()->route('user.index')->with('success', 'User data was successfully saved.');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('main.user.update', compact('user'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();

        try {
            $user = User::findOrFail($id);
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            return redirect()->route('user.index')->with('success', 'User data was successfully saved.');
        } catch (\Throwable $th) {
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'User data successfully deleted.'
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
        $data = User::onlyTrashed()->get();
        return view('main.user.restore', compact('data'));
    }

    public function restore($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore();

            return response()->json([
                'status' => true,
                'message' => 'User data was successfully recovered.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to recover data: ' . $th->getMessage()
            ], 500);
        }
    }
}
