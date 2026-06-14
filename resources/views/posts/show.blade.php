<x-layout>
    <x-slot name="title">{{ $post->title }}</x-slot>

    <h1 class="mb-3">{{ $post->title }}</h1>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Kategorija:</strong> {{ $post->category->name }}</p>
            <p><strong>Tips:</strong> {{ $post->type === 'service' ? 'Pakalpojums' : 'Darbs' }}</p>
            <p><strong>Autors:</strong>
                <a href="{{ route('profile.show', $post->user) }}">{{ $post->user->name }}</a>
            </p>
            <p class="mt-2">{{ $post->description }}</p>

            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Rediģēt</a>
            @endcan

            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Dzēst sludinājumu?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Dzēst</button>
                </form>
            @endcan
        </div>
    </div>

    <h3>Komentāri</h3>

    @forelse($post->comments as $comment)
        <div class="card mb-2">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <strong>{{ $comment->user->name }}</strong>
                    <p class="mb-0">{{ $comment->content }}</p>
                </div>
                @auth
                    @if(Auth::id() === $comment->user_id || Auth::user()->isAdmin())
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                              onsubmit="return confirm('Dzēst komentāru?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">✕</button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    @empty
        <div class="alert alert-info">Komentāru vēl nav.</div>
    @endforelse

    {{-- Comment form - only for logged-in users --}}
    @auth
        <div class="card mt-4">
            <div class="card-body">
                <h5>Pievienot komentāru</h5>
                <form action="{{ route('comments.store', $post) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                  rows="3" placeholder="Raksti šeit...">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Pievienot</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-secondary mt-4">
            <a href="{{ route('login') }}">Pieslēdzies</a>, lai komentētu.
        </div>
    @endauth
</x-layout>