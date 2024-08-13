<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->optional()->date(),
            'status' => $this->faker->randomElement(TaskStatus::cases()),
            'project_id' => Project::query()->inRandomOrder()->first()->id ?? Project::factory(),
            'user_id' => User::query()->inRandomOrder()->first()->id ?? User::factory(),
            ];
    }
}
