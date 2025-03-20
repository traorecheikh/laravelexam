<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{asset('custom-app-layout.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<div id="app">
    <header class="site-header">
        <div class="header-container">
            <div class="brand-section">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="site-logo">
                <a href="{{ url('/home') }}" class="site-title">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <button class="menu-toggle" id="menuToggle">
                <span class="menu-icon"></span>
            </button>

            <nav class="main-navigation" id="mainNav">
                <div class="nav-sections">
                    <!-- Primary Navigation -->
                    <ul class="primary-menu">
                        <li class="menu-item">
                            <a href="{{ route('burgers.index') }}" class="menu-link">
                                <i class="fa-solid fa-burger"></i> Burgers
                            </a>
                        </li>
                    </ul>

                    <!-- Account Navigation -->
                    <ul class="account-menu">
                        @guest
                            @if (Route::has('login'))
                                <li class="menu-item">
                                    <a href="{{ route('login') }}" class="menu-link auth-link">
                                        <i class="fa-solid fa-right-to-bracket"></i> {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="menu-item">
                                    <a href="{{ route('register') }}" class="menu-link auth-link">
                                        <i class="fa-solid fa-user-plus"></i> {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            @cannot('gerer burgers')
                                <li class="menu-item cart-item">
                                    <a href="{{ route('panier.index') }}" class="menu-link">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <span
                                            class="cart-count">{{ session('panier') ? count(session('panier')) : 0 }}</span>
                                    </a>
                                </li>
                            @endcannot

                            <li class="menu-item user-dropdown">
                                <a href="#" class="menu-link user-menu-toggle">
                                    <i class="fa-solid fa-circle-user"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>

                                <ul class="dropdown-content">
                                    @can('gerer commandes')
                                        <li>
                                            <a href="{{ route('commande.index') }}">
                                                <i class="fa-solid fa-list-check"></i> Toutes les Commandes
                                            </a>
                                        </li>
                                    @endcan
                                    @cannot('gerer commandes')
                                        <li>
                                            <a href="{{ route('commande.index') }}">
                                                <i class="fa-solid fa-receipt"></i> Mes Commandes
                                            </a>
                                        </li>
                                    @endcannot

                                    <li class="dropdown-divider"></li>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa-solid fa-power-off"></i> {{ __('Logout') }}
                                        </a>
                                    </li>
                                </ul>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main class="site-content">
        <div class="content-container">
            @yield('content')
        </div>
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const mainNav = document.getElementById('mainNav');

        if (menuToggle && mainNav) {
            menuToggle.addEventListener('click', function () {
                mainNav.classList.toggle('active');
                menuToggle.classList.toggle('active');
            });
        }

        // User dropdown toggle
        const userMenuToggle = document.querySelector('.user-menu-toggle');

        if (userMenuToggle) {
            userMenuToggle.addEventListener('click', function (e) {
                e.preventDefault();
                this.closest('.user-dropdown').classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                const dropdown = document.querySelector('.user-dropdown');
                if (dropdown && !dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        }
    });
</script>

@stack('scripts')
</body>
</html>
