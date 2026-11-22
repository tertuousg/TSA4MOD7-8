<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;
    public function definition(): array { return ['title' => fake()->sentence(4), 'description' => fake()->paragraph(), 'due_date' => fake()->dateTimeBetween('now','+2 weeks'), 'priority' => fake()->randomElement(['low','medium','high']), 'status' => 'pending', 'is_archived' => false]; }
}
