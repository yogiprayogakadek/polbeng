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
        User::create([
            'name' => 'I Gusti Agung Putu Mahendra',
            'email' => 'gungmahendra@polbeng.ac.id',
            'password' => Hash::make('polbeng@123')
        ]);
    }
}
