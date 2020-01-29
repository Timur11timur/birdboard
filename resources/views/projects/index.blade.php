@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary mb-0" style="font-size: 1rem;">My Project</h2>
        <a href="{{ route('project.create') }}" class="btn btn-info text-white">Add Project</a>
    </div>
    <div class="d-flex row">
        @forelse ($projects as $project)
            <div class="col-lg-4 pb-4">
                <div class="card border-0 shadow p-4 d-flex align-items-stretch h-100 rounded-lg">
                    <a href="{{ $project->path() }}" class="text-decoration-none">
                        <h3 class="card-title ml-n4 pl-3 border-info border-left border-1 py-2" style="font-size: 1.5rem;">{{ $project->title }}</h3>
                        <div class="card-text text-secondary">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
                    </a>
                </div>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
@endsection
