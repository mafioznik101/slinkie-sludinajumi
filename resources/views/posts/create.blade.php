<x-layout>
    <x-slot name="title">{{ __('messages.new_post') }}</x-slot>

    <h1 class="mb-4 text-primary-custom">{{ __('messages.new_post') }}</h1>

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="card-custom p-4 shadow-sm" id="postForm">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">{{ __('messages.heading') }}</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required style="border-color: #0e79b2;">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">{{ __('messages.description') }}</label>
            <textarea name="description" class="form-control" rows="5" required style="border-color: #0e79b2;">{{ old('description') }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">{{ __('messages.type') }}</label>
            <select name="type" class="form-select" required style="border-color: #0e79b2;">
                <option value="">{{ __('messages.select_type') }}</option>
                <option value="service" {{ old('type') === 'service' ? 'selected' : '' }}>{{ __('messages.service') }}</option>
                <option value="job" {{ old('type') === 'job' ? 'selected' : '' }}>{{ __('messages.job') }}</option>
            </select>
            @error('type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">{{ __('messages.category') }}</label>
            <select name="category_id" class="form-select" required style="border-color: #0e79b2;">
                <option value="">{{ __('messages.select_category') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">{{ __('messages.title_image') }}</label>
            <input type="file" name="title_image" id="title_image" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp" required style="border-color: #0e79b2;">
            <small class="form-text text-muted">{{ __('messages.image_requirements') }}</small>
            @error('title_image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">{{ __('messages.sub_images') }}</label>
            <input type="file" name="sub_images[]" id="sub_images" class="form-control" accept="image/jpeg,image/png,image/jpg,image/webp" multiple style="border-color: #0e79b2;">
            <small class="form-text text-muted">{{ __('messages.sub_images_info') }}</small>
            @error('sub_images') <small class="text-danger">{{ $message }}</small> @enderror
            @error('sub_images.*') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary-custom">{{ __('messages.create_post') }}</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary" style="background-color: #666; border-color: #666;">{{ __('messages.cancel') }}</a>
    </form>

    <script>
        document.getElementById('postForm').addEventListener('submit', function(e) {
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            const titleImage = document.getElementById('title_image');
            const subImages = document.getElementById('sub_images');
            
            const locale = '{{ app()->getLocale() }}';
            const messages = {
                lv: {
                    titleImageTooBig: 'Virsraksta attēla izmērs ir pārāk liels! Maksimālais atļautais izmērs ir 2MB. Jūsu faila izmērs: ',
                    subImageTooBig: 'Papildu attēla "',
                    tooBig: '" izmērs ir pārāk liels! Maksimālais atļautais izmērs ir 2MB. Faila izmērs: ',
                    tooManyImages: 'Jūs varat augšupielādēt maksimums 3 papildu attēlus. Jūs izvēlējāties ',
                    images: ' attēlus.'
                },
                en: {
                    titleImageTooBig: 'Title image size is too large! Maximum allowed size is 2MB. Your file size: ',
                    subImageTooBig: 'Additional image "',
                    tooBig: '" size is too large! Maximum allowed size is 2MB. File size: ',
                    tooManyImages: 'You can upload a maximum of 3 additional images. You selected ',
                    images: ' images.'
                }
            };
            
            const msg = messages[locale] || messages.lv;
            
            // Check title image
            if (titleImage.files.length > 0) {
                const file = titleImage.files[0];
                if (file.size > maxSize) {
                    e.preventDefault();
                    alert(msg.titleImageTooBig + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                    return false;
                }
            }
            
            // Check sub images
            if (subImages.files.length > 0) {
                for (let i = 0; i < subImages.files.length; i++) {
                    const file = subImages.files[i];
                    if (file.size > maxSize) {
                        e.preventDefault();
                        alert(msg.subImageTooBig + file.name + msg.tooBig + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                        return false;
                    }
                }
                
                // Check if more than 3 sub images
                if (subImages.files.length > 3) {
                    e.preventDefault();
                    alert(msg.tooManyImages + subImages.files.length + msg.images);
                    return false;
                }
            }
        });
    </script>
</x-layout>
