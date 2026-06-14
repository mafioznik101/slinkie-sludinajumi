<x-layout>
    <x-slot name="title">{{ $post->title }}</x-slot>

    <h1 class="mb-3 text-primary-custom fw-bold">{{ $post->title }}</h1>

    <div class="card mb-4 card-custom shadow">
        <div class="card-body">
            {{-- Title Image --}}
            @if($post->title_image)
                <div class="mb-3">
                    <img src="{{ $post->titleImageUrl() }}" alt="{{ $post->title }}" class="img-fluid rounded" style="max-width: 100%; max-height: 500px; object-fit: cover;">
                </div>
            @endif

            <p style="color: #191923;"><strong>Kategorija:</strong> {{ $post->category->name }}</p>
            <p style="color: #191923;"><strong>Tips:</strong> {{ $post->type === 'service' ? 'Pakalpojums' : 'Darbs' }}</p>
            <p style="color: #191923;">
                <strong>Autors:</strong>
                <a href="{{ route('profile.show', $post->user) }}" class="text-primary-custom text-decoration-none d-inline-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle me-2" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                    </svg>
                    {{ $post->user->name }}
                </a>
            </p>
            <p class="mt-2" style="color: #191923; font-size: 1.1rem;">{{ $post->description }}</p>

            {{-- Sub Images --}}
            @if($post->sub_images && count($post->sub_images) > 0)
                <div class="mt-3">
                    <h5 class="text-primary-custom">Papildu attēli:</h5>
                    <div class="row">
                        @foreach($post->subImageUrls() as $imageUrl)
                            <div class="col-md-4 mb-3">
                                <img src="{{ $imageUrl }}" alt="Sub image" class="img-fluid rounded" style="max-height: 200px; object-fit: cover; width: 100%;">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-3">
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary-custom btn-sm">Rediģēt</a>
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
    </div>

    <h3 class="text-primary-custom">Komentāri</h3>

    @forelse($post->comments as $comment)
        <div class="card mb-2 card-custom">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <a href="{{ route('profile.show', $comment->user) }}" class="text-decoration-none d-inline-flex align-items-center" style="color: #0e79b2;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle me-1" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                        <strong>{{ $comment->user->name }}</strong>
                    </a>
                    <p class="mb-0" style="color: #191923;">{{ $comment->content }}</p>
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
        <div class="alert alert-info" style="background-color: #e7f3f8; border-color: #0e79b2; color: #191923;">Komentāru vēl nav.</div>
    @endforelse

    {{-- Comment form - only for logged-in users --}}
    @auth
        <div class="card mt-4 card-custom shadow-sm">
            <div class="card-body">
                <h5 class="text-primary-custom">Pievienot komentāru</h5>
                <form action="{{ route('comments.store', $post) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                  rows="3" placeholder="Raksti šeit..." style="border-color: #0e79b2;">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary-custom">Pievienot</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-secondary mt-4">
            <a href="{{ route('login') }}">Pieslēdzies</a>, lai komentētu.
        </div>
    @endauth
</x-layout>
