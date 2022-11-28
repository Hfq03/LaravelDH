<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GEOMEET</title>

    <!-- Icono -->
    <link rel="shortcut icon" href="{{ asset('1.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('1.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Fontawesome -->
    <script src="https://kit.fontawesome.com/ee69a94543.js" crossorigin="anonymous"></script>
</head>
<body>
    @include('flash')
    <div id="app">
        <!-- https://blog.logrocket.com/five-cool-css-header-styles-with-cross-browser-compatibility/ -->
        <!-- AQUI SERIA EL HEADER -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a href="{{ route('dashboard') }}"><img src="/img/2.png" height="50" width="50"/></a>
                <a href="{{ route('dashboard') }}" style="text-decoration:none; display:flex; align-items: center;"><h1>GEOMEET</h1></a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @include('partials.language-switcher')
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
        <main>
            @yield('content')
        </main>
        @if(str_contains(url()->current(), '/login') || str_contains(url()->current(), '/password/reset') || str_contains(url()->current(), '/post'))
        
        @else
            @if(str_contains(url()->current(), '/dashboard'))
                <div class="flex-container">
                    <div><a href="{{ url('/post') }}"><i class="fa-solid fa-house fa-3x"></i></a></div>
                    <div><a href="{{ url('/likes') }}"><i class="fa-solid fa-heart fa-3x"></i></a></div>
                    <div><a href="{{ url('/nueva') }}"><i class="fa-solid fa-square-plus fa-3x"></i></a></div>
                    <div><a href="{{ url('/places') }}"><i class="fa-solid fa-location-dot fa-3x"></i></a></div>
                    <div><a href="{{ url('/files') }}"><i class="fa-solid fa-file fa-3x"></i></a></div>
                    <div><i class="fa-solid fa-circle-user fa-3x"></i></div>
                </div>
            @elseif(str_contains(url()->current(), '/post'))
                <div class="flex-container">
                    <div style="background-color: #22252C;"><a href="{{ url('/post') }}"><i class="fa-solid fa-house fa-3x" style="color: white;"></i></a></div>
                    <div><a href="{{ url('/likes') }}"><i class="fa-solid fa-heart fa-3x"></i></a></div>
                    <div><a href="{{ url('/nueva') }}"><i class="fa-solid fa-square-plus fa-3x"></i></a></div>
                    <div><a href="{{ url('/places') }}"><i class="fa-solid fa-location-dot fa-3x"></i></a></div>
                    <div><a href="{{ url('/files') }}"><i class="fa-solid fa-file fa-3x"></i></a></div>
                    <div><i class="fa-solid fa-circle-user fa-3x"></i></div>
                </div>
            @elseif (str_contains(url()->current(), '/likes'))
                <div class="flex-container">
                    <div><a href="{{ url('/post') }}"><i class="fa-solid fa-house fa-3x"></i></a></div>
                    <div style="background-color: #22252C"><i class="fa-solid fa-heart fa-3x" style="color: #e14658;"></i></div>
                    <div><a href="{{ url('/nueva') }}"><i class="fa-solid fa-square-plus fa-3x"></i></a></div>
                    <div><a href="{{ url('/places') }}"><i class="fa-solid fa-location-dot fa-3x"></i></a></div>
                    <div><a href="{{ url('/files') }}"><i class="fa-solid fa-file fa-3x"></i></a></div>
                    <div><i class="fa-solid fa-circle-user fa-3x"></i></div>
                </div>
            @elseif (str_contains(url()->current(), '/nueva'))
                <div class="flex-container">
                    <div><a href="{{ url('/post') }}"><i class="fa-solid fa-house fa-3x"></i></a></div>
                    <div><a href="{{ url('/likes') }}"><i class="fa-solid fa-heart fa-3x"></i></a></div>
                    <div style="background-color: #22252C;"><i class="fa-solid fa-square-plus fa-3x" style="color: white;"></i></div>
                    <div><a href="{{ url('/places') }}"><i class="fa-solid fa-location-dot fa-3x"></i></a></div>
                    <div><a href="{{ url('/files') }}"><i class="fa-solid fa-file fa-3x"></i></a></div>
                    <div><i class="fa-solid fa-circle-user fa-3x"></i></div>
                </div>
            @elseif (str_contains(url()->current(), '/places'))
            <div class="flex-container">
                <div><a href="{{ url('/post') }}"><i class="fa-solid fa-house fa-3x"></a></i></div>
                <div><a href="{{ url('/likes') }}"><i class="fa-solid fa-heart fa-3x"></i></i></div>
                <div><a href="{{ url('/nueva') }}"><i class="fa-solid fa-square-plus fa-3x"></i></a></div>
                <div style="background-color: #22252C;"><a href="{{ url('/places') }}"><i class="fa-solid fa-location-dot fa-3x" style="color: white;"></i></a></div>
                <div><a href="{{ url('/files') }}"><i class="fa-solid fa-file fa-3x"></i></a></div>
                <div><i class="fa-solid fa-circle-user fa-3x"></i></div>
            </div>
            @elseif (str_contains(url()->current(), '/files'))
                <div class="flex-container">
                    <div><a href="{{ url('/post') }}"><i class="fa-solid fa-house fa-3x"></i></a></div>
                    <div><a href="{{ url('/likes') }}"><i class="fa-solid fa-heart fa-3x"></i></a></div>
                    <div><a href="{{ url('/nueva') }}"><i class="fa-solid fa-square-plus fa-3x"></i></a></div>
                    <div><a href="{{ url('/places') }}"><i class="fa-solid fa-location-dot fa-3x"></i></a></div>
                    <div style="background-color: #22252C;"><a href="{{ url('/files') }}"><i class="fa-solid fa-file fa-3x" style="color: white;"></i></a></div>
                    <div><i class="fa-solid fa-circle-user fa-3x"></i></div>
                </div>
            @elseif (str_contains(url()->current(), '/profile'))
            <div class="flex-container">
                <div><a href="{{ url('/post') }}"><i class="fa-solid fa-house fa-3x"></i></a></div>
                <div><a href="{{ url('/likes') }}"><i class="fa-solid fa-heart fa-3x"></i></div>
                <div><a href="{{ url('/nueva') }}"><i class="fa-solid fa-square-plus fa-3x"></i></a></div>
                <div><a href="{{ url('/places') }}"><i class="fa-solid fa-location-dot fa-3x"></i></a></div>
                <div><a href="{{ url('/files') }}"><i class="fa-solid fa-file fa-3x"></i></a></div>
                <div style="background-color: #22252C;"><i class="fa-solid fa-circle-user fa-3x" style="color: white;"></i></div>
            </div>
            @endif
        @endif

    </div>
</body>
</html>
