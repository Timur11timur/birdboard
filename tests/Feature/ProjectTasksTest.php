<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $project = factory(Project::class)->create();

        $this->signIn();

        $task = $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id, ['body' => 'changed'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    public function testA_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');
    }

    public function testA_task_can_be_updated()
    {
        $user = factory(User::class)->create();

        $this->signIn($user);

        $project = factory(Project::class)->create(['owner_id' => $user->id]);

        $task = $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function testA_task_requires_a_body()
    {
        $this->signIn();

        $attributes = factory('App\Task')->raw(['body' => '']);

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
