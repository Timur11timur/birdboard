@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center ">
        <div class="card col-6">
            <div class="card-body">
                <h1>Edit your project</h1>
                <form method="POST" action="{{ $project->path() }}" class="w-100">
                    @csrf
                    @method('PATCH')
                    @include('projects.layouts.form', ['buttonText' => 'Update Project'] )
                </form>
            </div>
        </div>
    </div>
@endsection
