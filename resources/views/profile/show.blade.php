<x-layout>
    <x-slot name="title">{{ $user->name }}</x-slot>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-person-circle me-3 text-primary" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
                <h2 class="mb-0">{{ $user->name }}</h2>
            </div>
            @if($user->profile)
                <p><strong>Pilsēta:</strong> {{ $user->profile->city ?? '—' }}</p>
                <p><strong>Par mani:</strong> {{ $user->profile->bio ?? '—' }}</p>
                <p><strong>Tālrunis:</strong> {{ $user->profile->phone ?? '—' }}</p>
            @endif
            @auth
                @if(Auth::id() === $user->id)
                    <a href="{{ route('profile.edit') }}" class="btn btn-secondary btn-sm">Rediģēt profilu</a>
                @endif
            @endauth
        </div>
    </div>

    <h4>Sludinājumi</h4>
    @forelse($user->posts as $post)
        <div class="card mb-2">
            <div class="card-body">
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                <span class="badge bg-secondary">{{ $post->category->name }}</span>
            </div>
        </div>
    @empty
        <p class="text-muted">Nav aktīvu sludinājumu.</p>
    @endforelse

    <h4 class="mt-4">Atsauksmes</h4>
    @forelse($user->reviews as $review)
        <div class="card mb-2">
            <div class="card-body">
                <a href="{{ route('profile.show', $review->reviewer) }}" class="text-decoration-none d-inline-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle me-1" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                    </svg>
                    <strong>{{ $review->reviewer->name }}</strong>
                </a>
                — ⭐ {{ $review->rating }}/5
                <p class="mb-0">{{ $review->content }}</p>
                @auth
                    @if(Auth::id() === $review->reviewer_id || Auth::user()->isAdmin())
                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger mt-1">Dzēst</button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    @empty
        <p class="text-muted">Atsauksmju vēl nav.</p>
    @endforelse

    @auth
        @if(Auth::id() !== $user->id)
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Atstāt atsauksmi</h5>
                    <form action="{{ route('reviews.store', $user) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label>Vērtējums</label>
                            <select name="rating" class="form-select w-auto">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-2">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                      rows="2" placeholder="Teksts...">{{ old('content') }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button class="btn btn-primary btn-sm">Pievienot atsauksmi</button>
                    </form>
                </div>
            </div>
        @endif
    @endauth
</x-layout>