<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dashboard/datatable-net.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md auction-bg-theme-color navbar-light shadow-sm" style = "z-index: 1">
            <div class="container">
                <a class="navbar-brand auction-bg-theme-font-color " href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link auction-bg-theme-font-color" href="{{ route('auctions.live') }}">Live auction</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link auction-bg-theme-font-color" href="{{ route('auctions.upcoming') }}">Upcoming auction</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link auction-bg-theme-font-color" href="{{ route('auctions.history') }}">Auction history</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link auction-bg-theme-font-color submit-product-btn" href="{{route('products.create')}}">
                                <span>Submit a product.<span>
                            </a>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle auction-bg-theme-font-color" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('profile.products.live') }}">
                                    My Auctions
                                </a>
                                <a class="dropdown-item" href="{{ route('profile.products.bids') }}">
                                    My Bids
                                </a>
                                <a class="dropdown-item" href="{{ route('profile.account.info') }}">
                                    My Profile
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" style = "z-index: 1000">
                        @include('layouts.messages')
                    </div>
                </div>
            </div>
            @yield('content')
        </main>
        <div class = "auction-footer navbar-light text-center">
            <p>© mysitename.com - 2023. All rights reserved. IGNOU.</p>
            <p>(Indira Gandhi National Open University)</p>

        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('js/dashboard/datatable.js') }}"></script>

<script>
    $(document).ready(function() {
         new DataTable('#example');
    });
    </script>
@yield('js')

</html>