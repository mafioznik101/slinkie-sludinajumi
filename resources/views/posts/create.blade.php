<x-layout>
    <x-slot name="title">Jauns sludinājums</x-slot>

    <h1 class="mb-4">Jauns sludinājums</h1>

    <form method="POST" action="{{ route('posts.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Virsraksts</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Apraksts</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tips</label>
            <select name="type" class="form-select">
                <option value="">Izvēlies tipu</option>
                <option value="service" {{ old('type') === 'service' ? 'selected' : '' }}>Pakalpojums</option>
                <option value="job" {{ old('type') === 'job' ? 'selected' : '' }}>Darba piedāvājums</option>
            </select>
            @error('type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Kategorija</label>
            <select name="category_id" class="form-select">
                <option value="">Izvēlies kategoriju</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Saglabāt</button>
    </form>
</x-layout>