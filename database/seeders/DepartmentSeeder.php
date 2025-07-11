<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['department_code' => 'TI', 'department_name' => 'Teknik Informatika'],
            ['department_code' => 'SI', 'department_name' => 'Sistem Informasi'],
            ['department_code' => 'TK', 'department_name' => 'Teknik Komputer'],
            ['department_code' => 'MI', 'department_name' => 'Manajemen Informatika'],
            ['department_code' => 'KA', 'department_name' => 'Komputerisasi Akuntansi'],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
