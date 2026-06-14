<x-layout>
    <x-slot name="title">Rediģēt profilu</x-slot>

    <h2>Rediģēt profilu</h2>

    <form action="{{ route('profile.update') }}" method="POST" class="mt-3" style="max-width:500px">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Par mani</label>
            <textarea name="bio" class="form-control" rows="3">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Pilsēta</label>
            <input type="text" name="city" class="form-control"
                   value="{{ old('city', $user->profile->city ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Tālrunis</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ old('phone', $user->profile->phone ?? '') }}">
        </div>
        <button class="btn btn-primary">Saglabāt</button>
        <a href="{{ route('profile.show', Auth::user()) }}" class="btn btn-secondary ms-2">Atcelt</a>
    </form>
</x-layout>