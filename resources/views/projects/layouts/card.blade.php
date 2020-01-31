<div class="card border-0 shadow p-4 d-flex align-items-stretch rounded-lg col">
    <a href="{{ $project->path() }}" class="text-decoration-none">
        <h3 class="card-title ml-n4 pl-3 border-info border-left border-1 py-2" style="font-size: 1.5rem;">{{ $project->title }}</h3>
        <div class="card-text text-secondary">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
    </a>
</div>
