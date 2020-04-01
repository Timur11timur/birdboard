<div class="card border-0 shadow p-4 d-flex align-items-stretch rounded-lg col align-content-center mt-3">
    <h3 class="card-title ml-n4 pl-3 border-info border-left border-1 py-2" style="font-size: 1.5rem;">Invite a user</h3>
    <div class="card-text text-secondary mb-3">{{ Illuminate\Support\Str::limit($project->description, 100) }}</div>
    <form method="post" action="{{ $project->path() . '/invitations ' }}">
        @csrf
        <input type="email" name="email" class="form-control mb-3" placeholder="Email address">
        <button type="submit" class="btn btn-primary">Invite</button>
    </form>
    <div>
        @if ($errors->invitations->any())
            @foreach($errors->invitations->all() as $error)
                <div class="alert alert-danger mb-0 mt-3" role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
    </div>
</div>
