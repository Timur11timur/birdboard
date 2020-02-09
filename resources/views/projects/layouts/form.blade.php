
    <div class="form-group">
        <label for="title" class="label">Title</label>
        <input required type="text" class="form-control" name="title" id="title" value="{{ $project->title }}" >
    </div>

    <div class="form-group">
        <label for="description" class="label">Description</label>
        <div class="control">
            <textarea required class="form-control" name="description" rows="5">{{ $project->description }}</textarea>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <button class="btn btn-primary mr-3" type="submit">{{ $buttonText }}</button>
        <a href="{{ $project->path() }}">Cancel</a>
    </div>

    <div class="mt-3">
        @if ($errors->any())
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
    </div>
</form>