<?php

namespace Database\Factories;

use App\Models\Customer;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->sentence(),
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'project_manager_id' => Role::where('name', 'project manager')->first()->users()->inRandomOrder()->first()->id,
        ];
    }
}
