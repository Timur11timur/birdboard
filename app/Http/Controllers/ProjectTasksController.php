<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    protected function store(Project $project)
    {

        if (auth()->id() != $project->owner->id) {
            abort(403);
        }

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());
    }
}
