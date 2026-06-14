<x-layout>
    <x-slot name="title">{{ __('messages.posts') }}</x-slot>

    <h1 class="mb-4 text-primary-custom fw-bold">{{ __('messages.posts') }}</h1>

    @if ($posts->count())
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <x-post-card :post="$post" />
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info" style="background-color: #e7f3f8; border-color: #0e79b2; color: #191923;">{{ __('messages.no_posts') }}</div>
    @endif
</x-layout>