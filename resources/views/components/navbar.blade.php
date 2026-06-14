<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('posts.index') }}">Slinkie sludinājumi</a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="{{ route('posts.index') }}">Visi sludinājumi</a>

            @auth
                <a class="nav-link" href="{{ route('posts.create') }}">Pievienot</a>
                <a class="nav-link" href="{{ route('profile.show', Auth::user()) }}">Mans profils</a>
                @if(Auth::user()->isAdmin())
                    <a class="nav-link text-warning" href="{{ route('admin.index') }}">Admin</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-light ms-2">Iziet</button>
                </form>
            @else
                <a class="nav-link" href="{{ route('login') }}">Pieslēgties</a>
                <a class="nav-link" href="{{ route('register') }}">Reģistrēties</a>
            @endauth
        </div>
    </div>
</nav>