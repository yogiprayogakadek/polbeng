<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectDetail;
use App\Models\ProjectGallery;
use App\Models\StudyProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $studyProgram = StudyProgram::inRandomOrder()->first();

        for ($i = 1; $i <= 50; $i++) {
            $startYear = fake()->numberBetween(2020, 2024);
            $endYear = $startYear + 1;
            $project = Project::create([
                'project_category_id' => ProjectCategory::inRandomOrder()->value('id'),
                'project_title' => 'Project Sample ' . $i,
                'school_year' => $startYear . '/' . $endYear,
                'semester' => 'Ganjil',
                'thumbnail' => 'assets/images/projects/dummy_datas/thumbnails/sample.png',
            ]);

            $members = [
                ['student_id_number' => '12345' . $i, 'student_name' => 'Student ' . $i],
                ['student_id_number' => '54321' . $i, 'student_name' => 'Member ' . $i],
            ];

            $projectDetail = ProjectDetail::create([
                'project_id' => $project->id,
                'members' => json_encode($members),
                'description' => 'This is a dummy project description.',
                'video_trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'presentation_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'poster_path' => 'assets/images/projects/dummy_datas/posters/sample.png',
            ]);

            // Optional galleries
            ProjectGallery::create([
                'project_detail_id' => $projectDetail->id,
                'image_path' => 'assets/images/projects/dummy_datas/galleries/sample.png',
            ]);
        }
    }
}
