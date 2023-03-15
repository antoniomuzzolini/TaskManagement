<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // test pm user
        User::factory()->create([
            'name' => 'Test PM',
            'email' => 'pm@example.com',
        ])->assignRole('project manager');

        // creating pm users
        User::factory(4)->create()->each(function ($user) {
            $user->assignRole('project manager');
        });
        
        // test dev user
        User::factory()->create([
            'name' => 'Test DEV',
            'email' => 'dev@example.com',
        ])->assignRole('developer');

        // creating dev users
        User::factory(19)->create()->each(function ($user) {
            $user->assignRole('developer');
        });
        
    }
}
