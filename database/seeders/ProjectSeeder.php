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
        $projectCategories = ProjectCategory::all();
        $totalProjects = 3200; // Bisa diubah jadi lebih banyak
        $categoryCount = $projectCategories->count();

        // Hitung berapa banyak project per kategori
        $projectsPerCategory = (int) ceil($totalProjects / $categoryCount);

        $faker = fake();

        foreach ($projectCategories as $category) {
            for ($i = 0; $i < $projectsPerCategory; $i++) {
                $startYear = $faker->numberBetween(2020, 2024);
                $endYear = $startYear + 1;

                $project = Project::create([
                    'project_category_id' => $category->id,
                    'project_title' => $faker->sentence(4),
                    'school_year' => "$startYear/$endYear",
                    'semester' => $faker->randomElement(['Ganjil', 'Genap']),
                    'thumbnail' => 'assets/images/projects/dummy_datas/thumbnails/sample.png',
                ]);

                // Generate anggota antara 2–5 orang
                $memberCount = $faker->numberBetween(2, 5);
                $members = [];

                for ($j = 0; $j < $memberCount; $j++) {
                    $members[] = [
                        'student_id_number' => $faker->unique()->numerify('20######'),
                        'student_name' => $faker->name(),
                    ];
                }

                // Deskripsi panjang dan bervariasi (2–5 paragraf)
                $description = $faker->paragraphs($faker->numberBetween(2, 5), true);

                $projectDetail = ProjectDetail::create([
                    'project_id' => $project->id,
                    'members' => json_encode($members),
                    'description' => $description,
                    'video_trailer_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'presentation_video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'poster_path' => 'assets/images/projects/dummy_datas/posters/sample.png',
                ]);

                // Galeri dummy
                ProjectGallery::create([
                    'project_detail_id' => $projectDetail->id,
                    'image_path' => 'assets/images/projects/dummy_datas/galleries/sample.png',
                ]);
            }
        }
    }
}
