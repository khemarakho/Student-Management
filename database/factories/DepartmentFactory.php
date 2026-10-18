<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments = [
            'Computer Science',
            'Information Technology',
            'Software Engineering',
            'Business Administration',
            'Accounting & Finance',
            'Architecture & Design',
            'Civil Engineering',
            'Graphic Design & Multimedia',
            'Electrical Engineering',
            'Data Science & AI',
        ];

        return [
            'dept_name' => fake()->unique()->randomElement($departments).' '.fake()->unique()->randomNumber(2),
            'manager_id' => 'MGR-'.fake()->numberBetween(100, 999),
            'location_id' => 'BLD-'.fake()->randomElement(['A', 'B', 'C', 'D']).'-'.fake()->numberBetween(101, 505),
        ];
    }
}
