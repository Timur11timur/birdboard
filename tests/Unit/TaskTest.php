<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testATaskBelongsToAProject()
    {
        $task = factory('App\Task')->create();

        $this->assertInstanceOf('App\Project', $task->project);
    }

    public function testItHasAPath()
    {
        $task = factory('App\Task')->create();

        $this->assertEquals('/projects/' . $task->project->id . "/tasks/" . $task->id, $task->path());
    }
}
