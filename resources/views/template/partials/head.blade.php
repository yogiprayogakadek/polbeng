<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logo/logo.png') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    {{-- <link rel="stylesheet"
        href="https://bootstrapdemos.adminmart.com/matdash/dist/assets/css/plugins/atom-one-dark.min.css"> --}}

    @stack('css')
    <title>Politeknik Negeri Bengkalis - @yield('page-title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #printLoader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(4px);
            background: rgba(255, 255, 255, 0.6);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            display: none;
            /* tampilkan hanya ketika butuh */
        }
    </style>

</head>
