<x-layout>
    <x-slot name="title">Pieslēgties</x-slot>

    <h1 class="mb-4">Pieslēgties</h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">E-pasts</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Parole</label>
            <input type="password" name="password" class="form-control">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Pieslēgties</button>
    </form>
</x-layout>