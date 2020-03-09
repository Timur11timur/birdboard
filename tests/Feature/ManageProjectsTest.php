<?php

namespace Tests\Feature;

use App\Project;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker,
        RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testGuests_can_not_manage_projects()
    {
        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get('/projects/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    public function testA_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function testUnauthorised_users_cannot_delete_projects()
    {
        $project = factory(Project::class)->create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())
            ->assertStatus(403);
    }

    public function testA_user_can_delete_a_project()
    {
        $project = factory(Project::class)->create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    public function testA_user_can_update_a_project()
    {
        $project = factory(Project::class)->create();

        $atributes = [
            'title' => 'Changed',
            'description' => 'Changed',
            'notes' => 'Changed'
        ];

        $this->actingAs($project->owner)
            ->patch($project->path(), $atributes)
            ->assertRedirect($project->path());

        $this->get($project->path() . '/edit')->assertOK();

        $this->assertDatabaseHas('projects', $atributes);
    }

    public function testA_user_can_update_a_projects_general_notes()
    {
        $project = factory(Project::class)->create();

        $atributes = [
            'notes' => 'Changed'
        ];

        $this->actingAs($project->owner)
            ->patch($project->path(), $atributes);

        $this->assertDatabaseHas('projects', $atributes);
    }

    public function testA_project_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->make(['title' => ''])->toArray();

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    public function testA_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    public function testA_user_can_view_their_project()
    {
        $this->actingAs(factory('App\User')->create());

        $this->withoutExceptionHandling();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())->assertSee($project->title)->assertSee(substr($project->description, 0, 50));
    }

    public function testAn_authenticated_user_cannot_see_the_projects_of_others()
    {
        $project = factory('App\Project')->create();

        $this->actingAs(factory('App\User')->create());

        $this->get($project->path())->assertStatus(403);
    }

    public function testAn_authenticated_user_cannot_update_the_projects_of_others()
    {
        $project = factory('App\Project')->create();

        $this->signIn();

        $this->patch($project->path(), [])->assertStatus(403);
    }
}
