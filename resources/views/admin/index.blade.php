<x-layout>
    <x-slot name="title">Admina panelis</x-slot>

    <h2>Admina panelis</h2>

    <h4 class="mt-4">Lietotāji ({{ $users->count() }})</h4>
    <table class="table table-bordered table-sm">
        <thead><tr><th>Vārds</th><th>E-pasts</th><th>Loma</th><th>Sludinājumi</th><th>Statuss</th><th>Darbības</th></tr></thead>
        <tbody>
        @foreach($users as $user)
            <tr class="{{ $user->is_blocked ? 'table-danger' : '' }}">
                <td><a href="{{ route('profile.show', $user) }}">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->posts_count }}</td>
                <td>{{ $user->is_blocked ? '🔒 Bloķēts' : '✅ Aktīvs' }}</td>
                <td>
                    <form action="{{ route('admin.blockUser', $user) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-sm {{ $user->is_blocked ? 'btn-success' : 'btn-warning' }}">
                            {{ $user->is_blocked ? 'Atbloķēt' : 'Bloķēt' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.destroyUser', $user) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Dzēst lietotāju?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Dzēst</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h4 class="mt-4">Visi sludinājumi ({{ $posts->count() }})</h4>
    <table class="table table-bordered table-sm">
        <thead><tr><th>Nosaukums</th><th>Autors</th><th>Kategorija</th><th>Aktīvs</th><th>Darbības</th></tr></thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->category->name }}</td>
                <td>{{ $post->is_active ? '✅' : '❌' }}</td>
                <td>
                    <form action="{{ route('admin.destroyPost', $post) }}" method="POST"
                          onsubmit="return confirm('Dzēst sludinājumu?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Dzēst</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-layout>