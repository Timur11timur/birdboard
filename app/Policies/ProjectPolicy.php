<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Project $project)
    {
        return ($user->id == $project->owner->id) ? true : false;
    }

    public function update(User $user, Project $project)
    {
        return (($user->id == $project->owner->id) || ($project->members->contains($user))) ? true : false;
    }
}
