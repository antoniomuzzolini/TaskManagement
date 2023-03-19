<?php

namespace Database\Factories;

use App\Models\Project;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status_values = ['backlog', 'to do', 'in progress', 'done'];
        $priority_values = ['high', 'medium', 'low'];
        return [
            'title' => fake()->word(),
            'description' => fake()->sentence(),
            'status' => fake()->randomElement($status_values),
            'priority' => fake()->randomElement($priority_values),
            'project_id' => Project::inRandomOrder()->first()->id,
            'developer_id' => Role::where('name', 'developer')->first()->users()->inRandomOrder()->first()->id,
        ];
    }
}
