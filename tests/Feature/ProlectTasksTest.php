<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProlectTasksTest extends TestCase
{
   use RefreshDatabase;

    public function testA_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');
    }

    public function testA_task_requires_a_body()
    {
        $this->signIn();

        $attributes = factory('App\Task')->raw(['body' => '']);

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
