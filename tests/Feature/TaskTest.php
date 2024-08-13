<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TaskTest extends BaseFilamentTest
{
    use RefreshDatabase;

    #[Test]
    public function factory_can_create_a_task(): void
    {
        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => $task->name,
        ]);
    }

    #[Test]
    public function factory_can_assign_task_to_user()
    {
        $task = Task::factory()->create();

        $this->assertNotNull($task->user_id);
    }
}
