<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SPE') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('/js/searchableTable.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/masthead.css') }}" rel="stylesheet">

    <!-- MDBootstrap Datatables  -->
    <link href="/public/css/addons/datatables.min.css" rel="stylesheet">
</head>
<body>
<!--Picture Header -->
<header class="masthead">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
            </div>
        </div>
    </div>
</header>

<!--Navigation Header -->
<nav class="navbar navbar-expand-sm navbar-light"
     style="background-color: #e3f2fd;">

    <!-- left side logo-->
    <a class="navbar-brand" href="{{ url('/home') }}">
        {{ config('app.name', 'Sporteignungsprüfung') }}
    </a>


    <!-- Right Side Of Navbar with dropdown  -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ url('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrieren') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/home">
                        {{ __('Home') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                          style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</nav>

<!--Main Content with three columns -->
<div class="container-fluid">
    <div class="row">
        <!--left column -->
        <nav class="col-md-2 d-none d-block bg-light sidebar mh-100">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    @yield('navContent')
                </ul>
            </div>
        </nav>
        <!--content column -->
        <main role="main" class="col-md-8 ml-sm-auto px-4">
        @include('Includes/messages')
        @yield('content')
        <!-- footer with impressum -->
            <footer class="my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">&copy; 2020 TU Darmstadt - Institut für Sportwissenschaft</p>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="/aboutUs">Impressum</a></li>
                </ul>
            </footer>
        </main>
        <!-- right column -->
        <div class="col-md-2 d-block bg-light sidebar mh-100">
            <!-- TU Darmstadt picture-->
            <a href="https://www.tu-darmstadt.de/" class="mb-2">
                <img src="/bilder/athene.png" alt="Mein Bild" class="img-fluid">
            </a>
            <!-- TU Darmstadt IFS picture-->
            <a href="https://www.sport.tu-darmstadt.de/sportinstitut/index.de.jsp" class="mb-1">
                <img src="/bilder/IfS-Logo_neu.jpg" alt="Mein Bild" class="img-fluid">
            </a>
        </div>
    </div>
</div>

</body>
</html>
