@extends('layouts.app')

@section('content')
    <header class="d-flex align-items-center mb-4">
        <p class="text-secondary mb-0 mr-4" style="font-size: 1rem;"><a href="{{ route('projects') }}" class="text-decoration-none">My Project</a> / {{ $project->title }}</p>
        <a href="{{ route('project.create') }}" class="btn btn-info text-white">Add Project</a>
    </header>
    <main class="d-flex row">
        <div class="col-lg-8">
            <div class="mb-3">
                <h2 class="text-lg font-weight-normal ml-2 text-muted" style="font-size: 1.5rem;">Tasks</h2>
                @foreach($project->tasks as $task)
                    <div class="card border-0 shadow p-2 d-flex align-items-stretch rounded-lg mb-2">
                        <form action="{{ $task->path() }}" method="POST">
                            @method('PATCH')
                            @csrf
{{--                            <h3 class="card-title ml-n2 pl-2 border-info border-left border-1 py-2 mb-0" style="font-size: 1.5rem;">{{ $task->body }}</h3>--}}
                            <div class="d-flex align-items-center mr-2">
                                <input type="text" class="form-control border-0  {{ $task->completed ? 'text-secondary': '' }}" value="{{ $task->body }}" name="body">
                                <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked': '' }}>
                            </div>
                        </form>
                    </div>
                @endforeach
                <form action="{{ $project->path() . '/tasks' }}" method="POST">
                    @csrf
                    <input placeholder="Add a new task..." class="form-control" type="text" name="body">
                </form>
            </div>
            <div class="mb-3">
                <h2 class="text-lg font-weight-normal ml-2 text-muted" style="font-size: 1.5rem;">General Notes</h2>
                <textarea class="card border-0 shadow rounded-lg mb-2 py-2 px4 d-flex col" rows="6">dfsfdsfsadas</textarea>
            </div>
        </div>
        <div class="col-lg-4">
            @include('projects.layouts.card')
        </div>
    </main>
@endsection
