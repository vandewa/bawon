<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Ruang Desa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ruang Desa" />
    <meta name="author" content="Wonosobo" />

    <!-- favicon -->
    <link href="{{ asset('logo.ico') }}" rel="shortcut icon">
    <!-- Bootstrap -->
    <link href="{{ asset('starty/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('starty/css/tiny-slider.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('starty/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://unicons.iconscout.com/release/v3.0.6/css/line.css" rel="stylesheet" />
    <link href="{{ asset('starty/css/animate.css') }}" rel="stylesheet" />
    <link href="{{ asset('starty/css/animations-delay.css') }}" rel="stylesheet" />
    <!-- Main Css -->
    <link href="{{ asset('starty/css/style.min.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />

    @stack('styles')

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1 0 auto;
        }

        .footer {
            flex-shrink: 0;
        }
    </style>

    @vite([])
</head>

<body>
    <div class="page-wrapper">
        <!-- Navbar Start -->
        <header id="topnav" class="defaultscroll sticky">
            <div class="container">
                <!-- Logo container-->
                <a class="logo" href="{{ route('home') }}">
                    <img src="{{ asset('logo.png') }}" class="logo-light-mode" alt="" height="40">
                    <img src="{{ asset('logo.png') }}" class="logo-dark-mode" alt="" height="40">
                </a>
                <!-- End Logo container-->
                <div class="menu-extras">
                    <div class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </div>
                </div>

                <div id="navigation">
                    <!-- Navigation Menu-->
                    <ul class="navigation-menu">
                        <li><a href="{{ route('home') }}" class="sub-menu-item">Beranda</a></li>
                        <li><a href="#" class="sub-menu-item">Paket Pekerjaan</a></li>
                        <li><a href="{{ route('daftar-penyedia') }}" class="sub-menu-item">Daftar Penyedia</a></li>
                        <li><a href="{{ route('daftar-hitam') }}" class="sub-menu-item">Daftar Hitam</a></li>
                        <li><a href="{{ route('regulasi') }}" class="sub-menu-item">Regulasi</a></li>
                        <li><a href="{{ route('kontak-kami') }}" class="sub-menu-item">Kontak Kami</a></li>
                        <li><a href="{{ route('login') }}" class="sub-menu-item">Masuk/Daftar</a></li>
                    </ul><!--end navigation menu-->
                </div><!--end navigation-->
            </div><!--end container-->
        </header><!--end header-->
        <!-- Navbar End -->

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer Start -->
        <footer class="footer bg-footer">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-py-30">
                            <div class="container text-center">
                                <div class="row justify-content-center">
                                    <div class="col">
                                        <div class="text-center">
                                            <p class="mb-0">© {{ date('Y') }} Ruang Desa.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer><!--end footer-->
        <!-- Footer End -->

        <!-- Back to top -->
        <a href="javascript:void(0)" onclick="topFunction()" id="back-to-top" class="back-to-top rounded-pill">
            <i class="mdi mdi-arrow-up"></i>
        </a>
        <!-- Back to top -->
    </div>

    <!-- javascript -->
    <script src="{{ asset('starty/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('starty/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('starty/js/feather.min.js') }}"></script>
    <script src="{{ asset('starty/js/plugins.init.js') }}"></script>
    <script src="{{ asset('starty/js/app.js') }}"></script>

    @stack('js')
</body>

</html>
