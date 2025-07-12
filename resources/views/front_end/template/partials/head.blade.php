<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logo/logo.png') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    <title>Politeknik Negeri Bengkalis - @yield('page-title')</title>
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />

    @stack('css')
</head>
