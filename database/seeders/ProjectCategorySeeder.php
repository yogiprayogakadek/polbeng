<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['study_program_id' => 1, 'project_category_name' => 'Aplikasi Web'],
            ['study_program_id' => 1, 'project_category_name' => 'Aplikasi Mobile'],
            ['study_program_id' => 1, 'project_category_name' => 'Keamanan Siber'],
            ['study_program_id' => 2, 'project_category_name' => '3D Aset'],
            ['study_program_id' => 2, 'project_category_name' => 'Animasi 2D 3D'],
            ['study_program_id' => 2, 'project_category_name' => 'Motion Graphic'],
            ['study_program_id' => 3, 'project_category_name' => 'Augmented Reality'],
            ['study_program_id' => 3, 'project_category_name' => 'Virtual Reality'],
            ['study_program_id' => 3, 'project_category_name' => 'Game'],
            ['study_program_id' => 4, 'project_category_name' => 'ERP & Pengembangan Aplikasi'],
            ['study_program_id' => 4, 'project_category_name' => 'Data Mining'],
            ['study_program_id' => 5, 'project_category_name' => 'Desain Grafis'],
            ['study_program_id' => 5, 'project_category_name' => 'Ilustrasi'],
            ['study_program_id' => 5, 'project_category_name' => 'Video Live-Action'],
            ['study_program_id' => 5, 'project_category_name' => 'Concept Art'],
        ];

        foreach ($categories as $category) {
            ProjectCategory::create($category);
        }
    }
}
