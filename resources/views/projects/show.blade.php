@extends('layouts.app')

@section('content')
    <header class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-secondary mb-0 mr-4" style="font-size: 1rem;"><a href="{{ '/projects' }}" class="text-decoration-none">My Project</a> / {{ $project->title }}</p>
        <div>
            @foreach($project->members as $member)
                <img src="{{ gravatar_url($member->email) }}" alt="{{ $member->name }}'s avatar" class="rounded-circle">
            @endforeach
            <img src="{{ gravatar_url($project->owner->email) }}" alt="{{ $project->owner->name }}'s avatar" class="rounded-circle">
            <a href="{{ $project->path()  . "/edit" }}" class="btn btn-info text-white ml-2">Edit Project</a>
        </div>
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
                            <div class="d-flex align-items-center mr-2">
                                <input type="text" class="form-control border-0 {{ $task->completed ? 'text-secondary': '' }}"  {{ $task->completed ? 'style=text-decoration:line-through;': '' }} value="{{ $task->body }}" name="body">
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
                <form method="POST" action=" {{ $project->path() }}">
                    @csrf
                    @method('PATCH')
                    <textarea class="card border-0 shadow rounded-lg mb-3 py-2 px4 d-flex col" rows="6" name="notes">{{ $project->notes }}</textarea>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>

                <div class="mt-3">
                    @if ($errors->default->any())
                        @foreach($errors->default->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @include('projects.layouts.card')

            @include('projects.layouts.activity')

            @can ('manage', $project) {{--looking on policies--}}
                @include('projects.layouts.invite')
            @endcan
        </div>
    </main>
@endsection
