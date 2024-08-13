<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProjectTest extends BaseFilamentTest
{
    use RefreshDatabase;

    #[Test]
    public function factory_can_create_a_project(): void
    {
        $project = Project::factory()->create();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => $project->name,
        ]);
    }
}
