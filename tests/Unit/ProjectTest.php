<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function testItHasAPath()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    public function testIsBelongsToAnOwner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }

    public function testItCanAddAtask()
    {
        $project = factory('App\Project')->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }
}
