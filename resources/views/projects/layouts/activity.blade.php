<div class="card border-0 shadow p-4 d-flex align-items-stretch rounded-lg col mt-3">
    @foreach($project->activity as $activity)
        <p>@include("projects.activity.{$activity->description}") <span class="text-secondary">{{ $activity->created_at->diffForHumans(null, true) }}</span></p>
    @endforeach
</div>
