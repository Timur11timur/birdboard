<?php

namespace Tests\Unit;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user()
    {
        $user = $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => $user->id]);

        $this->assertEquals($user->id, $project->activity->first()->user->id);
    }
}
