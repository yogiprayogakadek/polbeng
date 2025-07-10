<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logo/logo.png') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    <title>Login | Politeknik Negeri Bengkalis</title>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <div
            class="position-relative overflow-hidden auth-bg min-vh-100 w-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100 my-5 my-xl-0">
                    <div class="col-md-9 d-flex flex-column justify-content-center">
                        <div class="card mb-0 bg-body auth-login m-auto w-100">
                            <div class="row gx-0">
                                <!-- ------------------------------------------------- -->
                                <!-- Part 1 -->
                                <!-- ------------------------------------------------- -->
                                <div class="col-xl-12">
                                    <div class="row justify-content-center py-4">
                                        <div class="col-lg-11">
                                            <div class="card-body">
                                                <a href="{{ route('login') }}"
                                                    class="text-nowrap logo-img d-block mb-4 w-100 text-center">
                                                    <img src="{{ asset('assets/images/logo/logo.png') }}"
                                                        class="dark-logo" alt="Logo-Dark" height="80rem" />
                                                </a>
                                                <h3 class="lh-base mb-4 text-center">Pameran Karya | Politeknik Negeri
                                                    Bengkalis</h3>

                                                <form method="POST" action="{{ route('login') }}">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Email
                                                            Address</label>
                                                        <input type="email" name="email" class="form-control"
                                                            id="exampleInputEmail1" placeholder="Enter your email"
                                                            aria-describedby="emailHelp">
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <label for="exampleInputPassword1"
                                                                class="form-label">Password</label>
                                                            <a class="text-primary link-dark fs-2"
                                                                href="javascript:void(0)" id="forgotPassword">Forgot
                                                                Password ?</a>
                                                        </div>
                                                        <input type="password" class="form-control"
                                                            id="exampleInputPassword1" name="password"
                                                            placeholder="Enter your password">
                                                    </div>
                                                    <button type="submit"
                                                        class="btn btn-dark w-100 py-8 mb-4 rounded-1">Sign In</a>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <!-- Import Js Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/app.init.js"></script>
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/theme.js"></script>
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/app.min.js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/plugins/toastr-init.js"></script>

    {{-- Danger Alert --}}
    @if (session('error'))
        <script>
            toastr.error("{{ session('error') }}", "Login gagal", {
                closeButton: true,
            });
        </script>
    @endif

    <script>
        $('body').on('click', '#forgotPassword', function() {
            toastr.info("Gagal Login", "Hubungi admin untuk perubahan password!", {
                closeButton: true,
            });
        });
    </script>
</body>

</html>
