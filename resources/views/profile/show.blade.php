<x-layout>
    <x-slot name="title">{{ $user->name }}</x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <h2>{{ $user->name }}</h2>
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
                <strong>{{ $review->reviewer->name }}</strong>
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