<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryUpdateRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectDetail;
use App\Models\ProjectGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        // $projects = Project::with('projectCategory')->get();
        // return view('main.project.index', compact('projects'));

        return view('main.project.index');
    }

    public function projectData(Request $request)
    {
        if ($request->ajax()) {
            $projects = Project::with(['projectCategory.studyProgram', 'detail'])
                ->select('projects.*');

            return DataTables::eloquent($projects)
                ->addIndexColumn()
                ->addColumn('thumbnail', function ($project) {
                    // return '<img src="' . resolveAssetPath($project->thumbnail) . '" width="70" class="img-thumbnail">';
                    return '<img src="' . asset('storage/' . $project->thumbnail) . '" width="70" class="img-thumbnail">';
                })
                ->addColumn('category_name', function ($project) {
                    return $project->projectCategory->studyProgram->study_program_name . ' - ' . $project->projectCategory->project_category_name;
                })
                ->addColumn('project_detail', function ($project) {
                    return '<button class="btn btn-outline-primary modal-btn"
                            data-url="' . route('project.detail', $project->id) . '"
                            data-modal-id="projectDetailModal" data-bs-toggle="tooltip"
                            data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                            data-bs-title="Project Detail">
                            <iconify-icon icon="solar:eye-line-duotone" width="1em"
                                height="1em"></iconify-icon>
                        </button>';
                })
                ->addColumn('galleries', function ($project) {
                    if ($project->detail) {
                        return '<button class="btn btn-outline-primary modal-btn"
                                data-url="' . route('project.galleries.modal', $project->detail->id) . '"
                                data-modal-id="projectGalleriesModal" data-bs-toggle="tooltip"
                                data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                data-bs-title="Project Galleries">
                                <iconify-icon icon="solar:album-line-duotone" width="1em"
                                    height="1em"></iconify-icon>
                            </button>';
                    }
                    return '-';
                })
                ->addColumn('status', function ($project) {
                    return '<span class="badge text-bg-' . ($project->is_active ? 'primary' : 'warning') . '">' . ($project->is_active ? 'Active' : 'Disabled') . '</span>';
                })
                ->addColumn('action', function ($project) {
                    $toggleBtn = '<button type="button"
                            class="btn ' . ($project->is_active ? 'bg-primary-subtle' : 'bg-warning-subtle text-warning') . ' btn-toggle-status"
                            data-id="' . $project->id . '" data-name="' . $project->project_title . '"
                            data-status="' . ($project->is_active ? 'disable' : 'activate') . '"
                            data-url="' . route('project.toggleStatus', $project->id) . '"
                            data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                            data-bs-placement="top"
                            data-bs-title="' . ($project->is_active ? 'Disable Project' : 'Activate Project') . '">
                            <iconify-icon
                                icon="' . ($project->is_active ? 'solar:bill-cross-bold-duotone' : 'solar:bill-check-bold-duotone') . '"
                                width="1em" height="1em">
                            </iconify-icon>
                        </button>';

                    $editBtn = '<a href="' . route('project.edit', $project->id) . '">
                            <button class="btn btn-outline-success" data-bs-toggle="tooltip"
                                data-bs-custom-class="custom-tooltip" data-bs-placement="top"
                                data-bs-title="Edit">
                                <iconify-icon icon="solar:clapperboard-edit-linear" width="1em"
                                    height="1em"></iconify-icon>
                            </button>
                        </a>';

                    $deleteBtn = '<button type="button" class="btn bg-danger-subtle text-danger btn-delete"
                            data-id="' . $project->id . '" data-name="' . $project->project_title . '"
                            data-url="' . route('project.destroy', $project->id) . '" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Delete Project">
                            <iconify-icon icon="solar:trash-bin-trash-bold-duotone" width="1em"
                                height="1em"></iconify-icon>
                        </button>';

                    return $toggleBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['thumbnail', 'project_detail', 'galleries', 'status', 'action'])
                ->filterColumn('category_name', function ($query, $keyword) {
                    $query->whereHas('projectCategory.studyProgram', function ($q) use ($keyword) {
                        $q->where('study_program_name', 'like', "%{$keyword}%")
                            ->orWhere('project_category_name', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('school_year', function ($query, $keyword) {
                    $query->where('school_year', 'like', "%{$keyword}%");
                })
                ->filterColumn('semester', function ($query, $keyword) {
                    $query->where('semester', 'like', "%{$keyword}%");
                })
                ->filterColumn('project_title', function ($query, $keyword) {
                    $query->where('project_title', 'like', "%{$keyword}%");
                })
                ->filterColumn('status', function ($query, $keyword) {
                    $status = strtolower($keyword);
                    if (str_contains($status, 'active')) {
                        $query->where('is_active', 1);
                    } elseif (str_contains($status, 'disabled') || str_contains($status, 'inactive')) {
                        $query->where('is_active', 0);
                    }
                })
                ->make(true);
        }
    }

    public function create()
    {
        $projectCategories = ProjectCategory::pluck('project_category_name', 'id')->prepend('Choose...', '');
        $years = array_reverse(range(2010, date('Y')));
        $semester = ['Ganjil', 'Genap'];

        return view('main.project.create', compact('projectCategories', 'years', 'semester'));
    }

    public function store(ProjectStoreRequest $request)
    {
        $data = $request->validated();
        // dd($data);

        DB::beginTransaction();

        try {
            $projectData = [
                'project_category_id' => $data['project_category_id'],
                'project_title' => $data['project_title'],
                'school_year' => $data['school_year'],
                'semester' => $data['semester'],
                'thumbnail' => $data['thumbnail'],
            ];

            // check if project has thumbnail
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/assets/images/projects/thumbnails', $filename);

                $projectData['thumbnail'] = 'assets/images/projects/thumbnails/' . $filename;
            }

            // save project
            $project = Project::create($projectData);

            if (!$project) {
                DB::rollBack();
                return back()->withInput()->with('error', 'Failed while saving data.');
            }

            // INITIATE PROJECT DATA

            // members
            $studentNames = $request->student_name;
            $studentIds = $request->student_id_number;

            $members = [];

            $total = max(count($studentNames), count($studentIds));

            for ($i = 0; $i < $total; $i++) {
                $name = $studentNames[$i] ?? null;
                $id = $studentIds[$i] ?? null;

                if (!empty($name) && !empty($id)) {
                    $members[] = [
                        'student_id_number' => $id,
                        'student_name' => $name,
                    ];
                }
            }

            $projectDetailData = [
                'project_id' => $project->id,
                'members' => json_encode($members),
                'description' => $data['description'],
                'video_trailer_url' => $data['video_trailer_url'],
                'presentation_video_url' => $data['presentation_video_url'],
            ];

            // check if project has poster
            if ($request->hasFile('poster_path')) {
                $file = $request->file('poster_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/assets/images/projects/posters', $filename);

                $projectDetailData['poster_path'] = 'assets/images/projects/posters/' . $filename;
            }

            // save project detail
            $projectDetail = ProjectDetail::create($projectDetailData);

            if (!$projectDetail) {
                DB::rollBack();
                return back()->withInput()->with('error', 'Failed while saving data.');
            }

            // INITIATE GALLERIES
            if ($request->hasFile('galleries')) {
                foreach ($request->file('galleries') as $file) {
                    $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/assets/images/projects/galleries', $filename);

                    $projectGallery = ProjectGallery::create([
                        'project_detail_id' => $projectDetail->id,
                        'image_path' => 'assets/images/projects/galleries/' . $filename,
                    ]);
                    if (!$projectGallery) {
                        DB::rollBack();
                        return back()->withInput()->with('error', 'Failed while saving data.');
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Project data was successfully saved.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th->getMessage(), $th->getFile(), $th->getLine());
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }


    // DETAILS
    public function detail($id)
    {
        $project = Project::findOrFail($id);

        $view = view('main.project.partials.project_detail_modal', compact('project'))->render();

        return response()->json($view);
    }

    // GALLERIES
    public function galleries($projectDetailID)
    {
        // check data
        $galleries = ProjectGallery::where('project_detail_id', $projectDetailID)->get();
        if ($galleries->isEmpty()) {
            return response()->json([
                'status' => 404,
                'html' => '<p class="text-center text-muted">No galleries found.</p>',
            ]);
        }

        // Render partial
        $view = view('main.project.partials.project_galleries_modal_content', compact('galleries', 'projectDetailID'))->render();

        return response()->json([
            'status' => 200,
            'html' => $view,
        ]);
    }

    // 2nd option
    // public function galleries($projectDetailID)
    // {
    //     $galleries = ProjectGallery::where('project_detail_id', $projectDetailID)->get();
    //     $view = view('main.project.partials.project_galleries_modal_content', compact('galleries'))->render();

    //     return response()->json(['html' => $view]);
    // }

    // show gallery modal for the first time
    public function showGalleriesModal($projectDetailID)
    {
        $galleries = ProjectGallery::where('project_detail_id', $projectDetailID)->get();
        return view('main.project.partials.project_galleries_modal', compact('galleries', 'projectDetailID'));
    }

    // delete galleries
    public function galleriesDelete($id)
    {
        $gallery = ProjectGallery::findOrFail($id);

        try {
            // Hapus file jika ada
            if (Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            $gallery->delete();

            return response()->json([
                'status' => 200,
                'title' => 'Success',
                'message' => 'Image deleted!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'title' => 'Failed',
                'message' => 'Failed to delete image'
            ]);
        }
    }

    // ADD this content to gallery modal
    public function addPhoto()
    {
        $view = view('main.project.partials.project_galleries_add_photo_content')->render();

        return response()->json([
            'html' => $view
        ]);
    }

    // Update/Add Gallery
    public function storeGalleryPhotos(GalleryUpdateRequest $request)
    {
        // INITIATE GALLERIES
        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/assets/images/projects/galleries', $filename);

                $projectGallery = ProjectGallery::create([
                    'project_detail_id' => $request->projectDetailID,
                    'image_path' => 'assets/images/projects/galleries/' . $filename,
                ]);
                if (!$projectGallery) {
                    DB::rollBack();
                    return back()->withInput()->with('error', 'Failed while saving data.');
                }
            }
        }
    }

    // EDIT PROJECT
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $projectMembers = json_decode($project->detail->members, true) ?? [];
        // dd($projectMembers);
        $projectCategories = ProjectCategory::pluck('project_category_name', 'id')->prepend('Choose...', '');
        $years = array_reverse(range(2010, date('Y')));
        $semester = ['Ganjil', 'Genap'];

        return view('main.project.update', compact('project', 'projectCategories', 'projectMembers', 'years', 'semester'));
    }

    public function update(ProjectUpdateRequest $request, $id)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $project = Project::findOrFail($id);
            $projectDetail = ProjectDetail::where('project_id', $project->id)->firstOrFail();

            // ===== Update Project =====
            $project->project_category_id = $data['project_category_id'];
            $project->project_title = $data['project_title'];
            $project->school_year = $data['school_year'];
            $project->semester = $data['semester'];

            // Handle Thumbnail (delete the old one if there is one and upload a new one)
            if ($request->hasFile('thumbnail')) {
                if ($project->thumbnail && Storage::disk('public')->exists(str_replace('assets/', '', $project->thumbnail))) {
                    Storage::disk('public')->delete(str_replace('assets/', '', $project->thumbnail));
                }

                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/assets/images/projects/thumbnails', $filename);

                $project->thumbnail = 'assets/images/projects/thumbnails/' . $filename;
            }

            $project->save();

            // ===== Update Members =====
            $studentNames = $request->student_name ?? [];
            $studentIds = $request->student_id_number ?? [];
            $members = [];

            $total = max(count($studentNames), count($studentIds));
            for ($i = 0; $i < $total; $i++) {
                $name = $studentNames[$i] ?? null;
                $idNumber = $studentIds[$i] ?? null;

                if (!empty($name) && !empty($idNumber)) {
                    $members[] = [
                        'student_id_number' => $idNumber,
                        'student_name' => $name,
                    ];
                }
            }

            // ===== Update Project Detail =====
            $projectDetail->members = json_encode($members);
            $projectDetail->description = $data['description'];
            $projectDetail->video_trailer_url = $data['video_trailer_url'];
            $projectDetail->presentation_video_url = $data['presentation_video_url'];

            // Poster Handle (delete the old one if any and upload the new one)
            if ($request->hasFile('poster_path')) {
                if ($projectDetail->poster_path && Storage::disk('public')->exists(str_replace('assets/', '', $projectDetail->poster_path))) {
                    Storage::disk('public')->delete(str_replace('assets/', '', $projectDetail->poster_path));
                }

                $file = $request->file('poster_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/assets/images/projects/posters', $filename);

                $projectDetail->poster_path = 'assets/images/projects/posters/' . $filename;
            }

            $projectDetail->save();

            DB::commit();
            return redirect()->route('project.index')->with('success', 'Project data was successfully updated.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withInput()->with('error', 'There is an error: ' . $th->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        $project = Project::findOrFail($id);

        $project->is_active = !$project->is_active;
        $project->save();

        return response()->json([
            'status' => true,
            'message' => 'Project ' . ($project->is_active ? 'activated' : 'disabled') . ' successfully.'
        ]);
    }

    public function destroy($id)
    {
        try {
            $project = Project::findOrFail($id);

            // Delete project data
            $project->delete();

            return response()->json([
                'status' => true,
                'message' => 'Project data successfully deleted.'
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
        $data = Project::with('projectCategory')->onlyTrashed()->get();
        // dd($data[0]->id);
        return view('main.project.restore', compact('data'));
    }

    public function restore($id)
    {
        try {
            $project = Project::onlyTrashed()->findOrFail($id);
            $project->restore();

            return response()->json([
                'status' => true,
                'message' => 'Project data was successfully recovered.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to recover data: ' . $th->getMessage()
            ], 500);
        }
    }
}
