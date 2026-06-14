<x-layout>
    <x-slot name="title">{{ __('messages.login') }}</x-slot>

    <h1 class="mb-4 text-primary-custom">{{ __('messages.login') }}</h1>

    <form action="{{ route('login') }}" method="POST" class="card-custom p-4 shadow-sm" style="max-width: 500px;">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">{{ __('messages.email') }}</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" style="border-color: #0e79b2;">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold" style="color: #191923;">{{ __('messages.password') }}</label>
            <input type="password" name="password" class="form-control" style="border-color: #0e79b2;">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary-custom">{{ __('messages.login') }}</button>
    </form>
</x-layout>