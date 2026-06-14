<x-layout>
    <x-slot name="title">Rediģēt sludinājumu</x-slot>

    <h1 class="mb-4">Rediģēt sludinājumu</h1>

    <form method="POST" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Virsraksts</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Apraksts</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description', $post->description) }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tips</label>
            <select name="type" class="form-select">
                <option value="service" {{ old('type', $post->type) === 'service' ? 'selected' : '' }}>Pakalpojums</option>
                <option value="job" {{ old('type', $post->type) === 'job' ? 'selected' : '' }}>Darba piedāvājums</option>
            </select>
            @error('type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kategorija</label>
            <select name="category_id" class="form-select">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $post->is_active) ? 'checked' : '' }}>
            <label class="form-check-label">Aktīvs</label>
        </div>

        <button type="submit" class="btn btn-primary">Atjaunināt</button>
    </form>
</x-layout>