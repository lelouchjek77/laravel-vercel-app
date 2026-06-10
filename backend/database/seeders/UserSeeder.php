<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Owner',
            'email' => 'owner@test.com',
            'password' => bcrypt('password123')
        ]);

        User::create([
            'name' => 'Collaborator',
            'email' => 'collaborator@test.com',
            'password' => bcrypt('password123')
        ]);
    }
}
