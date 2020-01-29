@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2 class="text-secondary mb-0">My Project</h2>
        <a href="{{ route('project.create') }}" class="btn btn-success">Add Project</a>
    </div>
    <div class="d-flex row">
        @forelse ($projects as $project)
            <div class="col-4 pb-4">
                <div class="card border-light shadow p-4 d-flex align-items-stretch" style="height: 100%">
                    <h3 class="card-title">{{ $project->title }}</h3>
                    <div class="card-text text-secondary">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
                </div>
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </div>
@endsection
