@props(['post'])

<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <h5 class="card-title">{{ $post->title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">
            {{ $post->category->name }} | {{ $post->type }}
        </h6>
        <p class="card-text">{{ Str::limit($post->description, 120) }}</p>
        <ul class="list-unstyled mb-3">
            <li><strong>Autors:</strong> {{ $post->user->name }}</li>
            <li><strong>Datums:</strong> {{ $post->created_at?->format('Y-m-d') }}</li>
        </ul>
        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Skatīt</a>
    </div>
</div>