<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
   use RefreshDatabase;

    public function testGuests_can_not_add_tasks_to_projects()
    {
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    public function testOnly_the_owner_of_the_project_can_add_tasks()
    {
        $project = factory(Project::class)->create();

        $this->signIn();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    public function testOnly_the_owner_of_the_project_can_update_the_tasks()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'changed'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    public function testA_project_can_have_tasks()
    {
        $project = app(ProjectFactory::class)
            ->create();

        $this->actingAs($project->owner)->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');
    }

    public function testA_task_can_be_updated()
    {
        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
            'body' => 'changed'
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed'
        ]);
    }

    public function testA_task_can_be_completed()
    {
        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function testA_task_can_be_marked_as_incomplete()
    {
        $project = app(ProjectFactory::class)
            ->withTasks(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed 1',
                'completed' => true
            ]);

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed 2',
                'completed' => false
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed 2',
            'completed' => false
        ]);
    }

    public function testA_task_requires_a_body()
    {
        $attributes = factory('App\Task')->raw(['body' => '']);

        $project = app(ProjectFactory::class)
            ->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
