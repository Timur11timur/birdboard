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

    public function testItCanBeCompleted()
    {
        $task = factory('App\Task')->create();

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->fresh()->completed);
    }

    public function testItCanBeMakredAsInomplete()
    {
        $task = factory('App\Task')->create(['completed' => true]);

        $this->assertTrue($task->completed);

        $task->incomplete();

        $this->assertFalse($task->fresh()->completed);
    }
}
