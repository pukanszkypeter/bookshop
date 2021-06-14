<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('My Bookshop', 'My Bookshop') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset("images/logo.png") }}" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fa.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #ffdd99;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="margin-right: 0.2rem">
                    <img width="30px" src="{{ asset("images/logo.png") }}">
                    {{ config('My Bookshop', 'My Bookshop') }}
                </a>

                @guest
                    <h5><span class="badge bg-primary text-white" style="margin-right: 1rem;margin-top: 0.5rem"> Guest Page </span></h5>
                @else
                    @if(Auth::user()->isLibrarian())
                        <h5><span class="badge bg-danger  text-white" style="margin-right: 1rem;margin-top: 0.5rem"> Librarian Page </span></h5>
                    @else
                        <h5><span class="badge bg-success text-white" style="margin-right: 1rem;margin-top: 0.5rem"> Reader Page </span></h5>
                    @endif
                @endguest

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @guest
                            <li class="nav-item">
                                <a id="nav-books" class="nav-link" href="{{ route('books.index') }}">Books</a>
                            </li>
                        @else
                            @if(Auth::user()->isLibrarian())
                                <li class="nav-item">
                                    <a id="nav-books" class="nav-link" href="{{ route('books.index') }}">Books</a>
                                </li>
                                <li>
                                    <a id="nav-rentals" class="nav-link" href="{{ route('librarian.borrows.index.pending') }}">Rental managment</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a id="nav-books" class="nav-link" href="{{ route('books.index') }}">Books</a>
                                </li>
                                <li>
                                    <a id="nav-rentals" class="nav-link" href="{{ route('reader.borrows.index.pending') }}">My rentals</a>
                                </li>
                            @endif
                        @endguest
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a id="nav-login" class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a id="nav-register" class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if(Auth::user()->isLibrarian())
                            <li class="nav-item">
                                <h5><span class="badge bg-danger  text-white" style="margin-top: 0.65rem"> Librarian </span></h5>
                            </li>
                            @else
                            <li class="nav-item">
                                <h5><span class="badge bg-success text-white" style="margin-top: 0.65rem"> Reader </span></h5>
                            </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->isLibrarian())
                                        <a class="dropdown-item" href="{{ route('librarian.profile') }}">
                                            Profile
                                        </a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('reader.profile') }}">
                                            Profile
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <div class="container mb-4">
                <hr style="background-color: #ffdd99;">
                <div class="d-flex flex-column align-items-center">
                    <div>
                        <span class="small">Basic Bookshop</span>
                        <span class="mx-1">·</span>
                        <span class="small">Laravel {{ app()->version() }}</span>
                        <span class="mx-1">·</span>
                        <span class="small">PHP {{ phpversion() }}</span>
                    </div>

                    <div>
                        <span class="small">Serverside webprogramming 2020-21-2</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
