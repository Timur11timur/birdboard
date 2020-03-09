@extends('layouts.app')

@section('content')
    <header class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary mb-0" style="font-size: 1rem;">My Project</h2>
        <a href="{{ '/projects/create' }}" class="btn btn-info text-white">Add Project</a>
    </header>
    <main class="d-flex row">
        @forelse ($projects as $project)
            <div class="col-lg-4 pb-4 d-flex align-items-stretch">
                @include('projects.layouts.card')
            </div>
        @empty
            <div>No projects yet.</div>
        @endforelse
    </main>
@endsection
