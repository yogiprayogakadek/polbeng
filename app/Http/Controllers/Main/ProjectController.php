<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectStoreRequest;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectDetail;
use App\Models\ProjectGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('projectCategory')->get();
        return view('main.project.index', compact('projects'));
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
                        'image_path' => 'assets/images/users/galleries/' . $filename,
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

        $view = view('main.project.partials.project_details_modal', compact('project'))->render();

        return response()->json($view);
    }
}
