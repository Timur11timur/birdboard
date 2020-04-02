<div class="card border-0 shadow p-4 d-flex align-items-stretch rounded-lg col align-content-center">
    <a href="{{ $project->path() }}" class="text-decoration-none h-100">
        <h3 class="card-title ml-n4 pl-3 border-info border-left border-1 py-2" style="font-size: 1.5rem;">{{ $project->title }}</h3>
        <div class="card-text text-secondary mb-3">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
    </a>
    @can('manage', $project)
        <footer class="align-self-end">
            <form method="post" action="{{ $project->path() }}" class="d-flex justify-content-end">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-link p-0">Delete</button>
            </form>
        </footer>
    @endcan
</div>
