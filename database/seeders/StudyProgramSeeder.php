<?php

namespace Database\Seeders;

use App\Models\StudyProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studyPrograms = [
            ['department_id' => 1, 'study_program_code' => 'TRPL', 'study_program_name' => 'Teknologi Rekayasa Perangkat Lunak'],
            ['department_id' => 1, 'study_program_code' => 'MI', 'study_program_name' => 'Manajemen Informatika'],
            ['department_id' => 2, 'study_program_code' => 'SK', 'study_program_name' => 'Sistem Komputer'],
            ['department_id' => 3, 'study_program_code' => 'TKJ', 'study_program_name' => 'Teknik Komputer Jaringan'],
            ['department_id' => 4, 'study_program_code' => 'KA', 'study_program_name' => 'Komputerisasi Akuntansi'],
        ];

        foreach ($studyPrograms as $program) {
            StudyProgram::create($program);
        }
    }
}
