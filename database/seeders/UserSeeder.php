<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@polbeng.ac.id',
                'password' => Hash::make('polbeng@123'),
                'role' => 'admin'
            ],
            [
                'name' => 'Petugas User',
                'email' => 'petugas@polbeng.ac.id',
                'password' => Hash::make('polbeng@123'),
                'role' => 'petugas'
            ],
            [
                'name' => 'Dosen User',
                'email' => 'dosen@polbeng.ac.id',
                'password' => Hash::make('polbeng@123'),
                'role' => 'dosen_pembimbing'
            ],
            [
                'name' => 'Kaprodi User',
                'email' => 'kaprodi@polbeng.ac.id',
                'password' => Hash::make('polbeng@123'),
                'role' => 'kaprodi'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $faker = \Faker\Factory::create('id_ID');
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => 'dosen' . $i . '@polbeng.ac.id',
                'password' => Hash::make('polbeng@123'),
                'role' => 'dosen_pembimbing'
            ]);
        }
    }
}
