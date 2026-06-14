<x-layout>
    <x-slot name="title">{{ $post->title }}</x-slot>

    <h1 class="mb-3">{{ $post->title }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Kategorija:</strong> {{ $post->category->name }}</p>
            <p><strong>Tips:</strong> {{ $post->type }}</p>
            <p><strong>Autors:</strong> {{ $post->user->name }}</p>
            <p>{{ $post->description }}</p>

            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Rediģēt</a>
        </div>
    </div>

    <h3>Komentāri</h3>

    @forelse($post->comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <strong>{{ $comment->user->name }}</strong>
                <p class="mb-0">{{ $comment->content }}</p>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Komentāru vēl nav.</div>
    @endforelse
</x-layout>