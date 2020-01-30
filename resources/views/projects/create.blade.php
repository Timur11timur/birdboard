@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create a project</h1>
        <form method="POST" action="/projects" class="col-4">
            @csrf
            <div class="form-group">
                <label for="title" class="label">Title</label>
                <input type="text" class="form-control" name="title" id="title" >
            </div>

            <div class="form-group">
                <label for="description" class="label">Description</label>
                <div class="control">
                    <textarea class="form-control" name="description" rows="5"></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <button class="btn btn-primary mr-3" type="submit">Create Project</button>
                <a href="{{ route('projects') }}">Cancel</a>
            </div>

        </form>
    </div>
@endsection
