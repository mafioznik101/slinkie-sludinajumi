<x-layout>
    <x-slot name="title">Sludinājumi</x-slot>

    <h1 class="mb-4">Sludinājumi</h1>

    @if ($posts->count())
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <x-post-card :post="$post" />
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Nav pieejamu sludinājumu.</div>
    @endif
</x-layout>