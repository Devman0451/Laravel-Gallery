<section class="mobile--navmenu">
    <form class="mobile--searchbar" action="" method="get">
        <input class="searchbar--header" type="text" name="search" placeholder="Search...">
        <input class="btn-hidden" type="submit">
    </form>
    <nav class="mobile--navbar">
        <ul class="list--header list--navbar">
            <li><a href="/" class="link--header">Submissions</a></li>
            <li><a href="/about" class="link--header">About</a></li>
            <li><a href="/users" class="link--header">Users</a></li>
            <li><a href="/faq" class="link--header">FAQ</a></li>
        </ul>
    </nav>
    <ul class="mobile--signin list--header signin--list">

        @guest

            <li><a href="{{ route('login') }}" class="link--header">{{ __('Login') }}</a></li>
            @if (Route::has('register'))
                <li><a href="{{ route('register') }}" class="link--header">{{ __('Register') }}</a></li>
            @endif

        @else

            <li><a href="" class="link--header">{{ Auth::user()->username }}</a></li>
            <li><a href="edit_profile.php" class="link--header">Edit Profile</a></li>
            <li><a href="/projects/create" class="link--header">Upload</a></li>
            <li>
            <a class="link--header" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
            </li>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        @endguest

    </ul>
</section>