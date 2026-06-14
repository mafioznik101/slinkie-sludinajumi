@props(['post'])

<div class="card mb-3 shadow-sm card-custom">
    @if($post->title_image)
        <img src="{{ $post->titleImageUrl() }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
    @endif
    <div class="card-body">
        <h5 class="card-title text-primary-custom fw-bold">{{ $post->title }}</h5>
        <h6 class="card-subtitle mb-2" style="color: #666;">
            {{ $post->category->name }} | {{ $post->type === 'service' ? 'Pakalpojums' : 'Darbs' }}
        </h6>
        <p class="card-text" style="color: #191923;">{{ Str::limit($post->description, 120) }}</p>
        <ul class="list-unstyled mb-3" style="color: #191923;">
            <li>
                <strong>Autors:</strong>
                <a href="{{ route('profile.show', $post->user) }}" class="text-decoration-none text-primary-custom d-inline-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle me-1" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                    </svg>
                    {{ $post->user->name }}
                </a>
            </li>
            <li><strong>Datums:</strong> {{ $post->created_at?->format('Y-m-d') }}</li>
        </ul>
        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary-custom">Skatīt</a>
    </div>
</div>
