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
            ['study_program_id' => 1, 'project_category_name' => 'Aplikasi Web', 'thumbnail' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 1, 'project_category_name' => 'Aplikasi Mobile', 'thumbnail' => 'https://images.unsplash.com/photo-1512941937669-90bcdf591782?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 1, 'project_category_name' => 'Keamanan Siber', 'thumbnail' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 2, 'project_category_name' => '3D Aset', 'thumbnail' => 'https://images.unsplash.com/photo-1616469829581-73993eb86b02?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 2, 'project_category_name' => 'Animasi 2D 3D', 'thumbnail' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 2, 'project_category_name' => 'Motion Graphic', 'thumbnail' => 'https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 3, 'project_category_name' => 'Augmented Reality', 'thumbnail' => 'https://images.unsplash.com/photo-1478416272538-5f7e51dc5400?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 3, 'project_category_name' => 'Virtual Reality', 'thumbnail' => 'https://images.unsplash.com/photo-1592477342004-bd7ba780f2b3?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 3, 'project_category_name' => 'Game', 'thumbnail' => 'https://images.unsplash.com/photo-1493711662062-fa541adb3fc8?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 4, 'project_category_name' => 'ERP & Pengembangan Aplikasi', 'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 4, 'project_category_name' => 'Data Mining', 'thumbnail' => 'https://images.unsplash.com/photo-1551288049-bbda48336202?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 5, 'project_category_name' => 'Desain Grafis', 'thumbnail' => 'https://images.unsplash.com/photo-1626785774573-4b799315f30d?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 5, 'project_category_name' => 'Ilustrasi', 'thumbnail' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 5, 'project_category_name' => 'Video Live-Action', 'thumbnail' => 'https://images.unsplash.com/photo-1492724441997-5dc865305da7?auto=format&fit=crop&w=800&q=80'],
            ['study_program_id' => 5, 'project_category_name' => 'Concept Art', 'thumbnail' => 'https://images.unsplash.com/photo-1605301091855-d60dec69e8bb?auto=format&fit=crop&w=800&q=80'],
        ];

        foreach ($categories as $category) {
            ProjectCategory::create($category);
        }
    }
}
