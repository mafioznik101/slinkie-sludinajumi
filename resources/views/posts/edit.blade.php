<x-layout>
    <x-slot name="title">Rediģēt sludinājumu</x-slot>

    <h1 class="mb-4 text-primary-custom">Rediģēt sludinājumu</h1>

    <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" class="card-custom p-4 shadow-sm" id="postEditForm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">Virsraksts</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required style="border-color: #0e79b2;">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">Apraksts</label>
            <textarea name="description" class="form-control" rows="5" required style="border-color: #0e79b2;">{{ old('description', $post->description) }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">Tips</label>
            <select name="type" class="form-select" required style="border-color: #0e79b2;">
                <option value="service" {{ old('type', $post->type) === 'service' ? 'selected' : '' }}>Pakalpojums</option>
                <option value="job" {{ old('type', $post->type) === 'job' ? 'selected' : '' }}>Darba piedāvājums</option>
            </select>
            @error('type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">Kategorija</label>
            <select name="category_id" class="form-select" required style="border-color: #0e79b2;">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">Virsraksta attēls</label>
            @if($post->title_image)
                <div class="mb-2">
                    <img src="{{ $post->titleImageUrl() }}" alt="Current title image" class="img-thumbnail" style="max-width: 200px;">
                    <p class="text-muted small">Pašreizējais virsraksta attēls</p>
                </div>
            @endif
            <input type="file" name="title_image" id="title_image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp" style="border-color: #0e79b2;">
            <small class="form-text text-muted">Atstājiet tukšu, lai saglabātu pašreizējo attēlu. Maksimālais izmērs: 2MB</small>
            @error('title_image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">Papildu attēli (līdz 3)</label>
            @if($post->sub_images && count($post->sub_images) > 0)
                <div class="mb-2">
                    <div class="row">
                        @foreach($post->subImageUrls() as $imageUrl)
                            <div class="col-md-4 mb-2">
                                <img src="{{ $imageUrl }}" alt="Sub image" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                        @endforeach
                    </div>
                    <p class="text-muted small">Pašreizējie papildu attēli</p>
                </div>
            @endif
            <input type="file" name="sub_images[]" id="sub_images" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp" multiple style="border-color: #0e79b2;">
            <small class="form-text text-muted">Atstājiet tukšu, lai saglabātu pašreizējos attēlus. Jauni attēli aizstās vecos.</small>
            @error('sub_images') <small class="text-danger">{{ $message }}</small> @enderror
            @error('sub_images.*') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $post->is_active) ? 'checked' : '' }} style="border-color: #0e79b2;">
            <label class="form-check-label fw-bold" style="color: #191923;">Aktīvs</label>
        </div>

        <button type="submit" class="btn btn-primary-custom">Atjaunināt</button>
        <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary" style="background-color: #666; border-color: #666;">Atcelt</a>
    </form>

    <script>
        document.getElementById('postEditForm').addEventListener('submit', function(e) {
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            const titleImage = document.getElementById('title_image');
            const subImages = document.getElementById('sub_images');
            
            // Check title image
            if (titleImage.files.length > 0) {
                const file = titleImage.files[0];
                if (file.size > maxSize) {
                    e.preventDefault();
                    alert('Virsraksta attēla izmērs ir pārāk liels! Maksimālais atļautais izmērs ir 2MB. Jūsu faila izmērs: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                    return false;
                }
            }
            
            // Check sub images
            if (subImages.files.length > 0) {
                for (let i = 0; i < subImages.files.length; i++) {
                    const file = subImages.files[i];
                    if (file.size > maxSize) {
                        e.preventDefault();
                        alert('Papildu attēla "' + file.name + '" izmērs ir pārāk liels! Maksimālais atļautais izmērs ir 2MB. Faila izmērs: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                        return false;
                    }
                }
                
                // Check if more than 3 sub images
                if (subImages.files.length > 3) {
                    e.preventDefault();
                    alert('Jūs varat augšupielādēt maksimums 3 papildu attēlus. Jūs izvēlējāties ' + subImages.files.length + ' attēlus.');
                    return false;
                }
            }
        });
    </script>
</x-layout>
