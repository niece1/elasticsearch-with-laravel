<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    <!-- Head -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name'))</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Fontawesome -->
        <script src="https://kit.fontawesome.com/0f7f320048.js" crossorigin="anonymous"></script>
        @stack('styles')
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <!-- /.Head -->

    <!-- Body -->
    <body>
        
        <!-- Header -->
        <header>
            <div class="menu-wrapper">
                <div class="logo">
                    <a href="/">
                        elastic<span class="logo-span">search</span>
                    </a>
                </div>
                <!-- Navigation -->
                <nav>
                    <ul>
                        <li class="sub-menu">
                            <a href="/">Home</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="search">
                                <i class="fas fa-search"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.Navigation -->
                <div class="menu-toggle">
                    <div class="hamburger-menu">
                    </div>
                </div>
            </div>
            <!-- Search overlay -->
            <div class="search-overlay">
                <span class="close-search">&times;</span>
                <form action="{{ route('search') }}" method="GET"  class="search-input" autocomplete="off">
                    <div class="input-wrapper" data-text="">
                        <input type="text" name="q" value="{{ request()->input('q') }}" id="search" placeholder="Search..." required>
                    </div>
                </form>
            </div>
            <!-- /.Search overlay -->
        </header>
        <!-- /.Header -->
        
        <!-- Main -->
        <main>
            @yield('content')
        </main>
        <!-- /.Main -->

        <!-- Footer -->
        <footer>
                <div class="footer_wrapper_upper">
                    <div class="footer_about">
                        <a href="{{ url('/') }}" class="logo-footer">Elastic</a>
                        <p>Qui iste nostrum mollitia voluptatem optio similique repellat. Assumenda maiores eos ...</p>
                        <a href="#">
                            <span>Read more</span>
                        </a>
                    </div>
                    <div class="footer_links">
                        <h5>Categories</h5>
                        <ul>
                            <li>
                                <a href="#">
                                    <span>Incidents</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>Discounts</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>Manufacturing</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>Ads</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer_links">
                        <h5>Links</h5>
                        <ul>
                            <li>
                                <a href="{{ url('/') }}">
                                    <span>Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>About</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>Contacts</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="footer_wrapper_down">
                    
                    <div class="footer_copyright">
                        <p>&#169; {{ date('Y') }} Elastic</p>
                        <p>
                            Noa Digital. Made with love for a better web.
                        </p>
                    </div>
                </div>
            </footer>   
         <!-- /.Footer-->
         
         <!--Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- /.Scripts -->
        
    </body>
    <!-- /.Body -->

</html>
