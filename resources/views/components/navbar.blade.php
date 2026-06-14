<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('posts.index') }}" style="color: #fbfef9; font-family: 'Playfair Display', serif;">
            <img src="{{ asset('images/logo.png') }}" alt="Slinkie Logo" style="height: 1.5em; margin-right: 0.5rem;">
            {{ __('messages.app_name') }}
        </a>

        <div class="navbar-nav ms-auto d-flex align-items-center">
            <a class="nav-link" href="{{ route('posts.index') }}" style="color: #fbfef9;">{{ __('messages.all_posts') }}</a>

            @auth
                <a class="nav-link" href="{{ route('posts.create') }}" style="color: #fbfef9;">{{ __('messages.add_post') }}</a>
                <a class="nav-link" href="{{ route('profile.show', Auth::user()) }}" style="color: #fbfef9;">{{ __('messages.my_profile') }}</a>
                @if(Auth::user()->isAdmin())
                    <a class="nav-link" href="{{ route('admin.index') }}" style="color: #0e79b2; font-weight: 600;">{{ __('messages.admin') }}</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-primary-custom ms-2">{{ __('messages.logout') }}</button>
                </form>
            @else
                <a class="nav-link" href="{{ route('login') }}" style="color: #fbfef9;">{{ __('messages.login') }}</a>
                <a class="nav-link" href="{{ route('register') }}" style="color: #fbfef9;">{{ __('messages.register') }}</a>
            @endauth

            <!-- Language Switcher -->
            <div class="dropdown ms-3">
                <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-color: #fbfef9; color: #fbfef9;">
                    {{ strtoupper(app()->getLocale()) }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                    <li><a class="dropdown-item {{ app()->getLocale() == 'lv' ? 'active' : '' }}" href="{{ route('language.switch', 'lv') }}">Latviešu (LV)</a></li>
                    <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('language.switch', 'en') }}">English (EN)</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>