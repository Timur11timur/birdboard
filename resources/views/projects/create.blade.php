@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center ">
        <div class="card col-6">
            <div class="card-body">
                <h1>Create a project</h1>
                <form method="POST" action="/projects" class="w-100">
                    @csrf
                    @include('projects.layouts.form', ['project' => new App\Project, 'buttonText' => 'Create Project'])
                </form>
            </div>
        </div>
    </div>
@endsection
