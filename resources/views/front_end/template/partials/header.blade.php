<header class="header-fp p-0 w-100 bg-light-gray">
    <nav class="navbar navbar-expand-lg py-10">
        <div class="container-fluid d-flex justify-content-between">
            <a href="{{ route('frontend.homepage') }}" class="text-nowrap logo-img">
                <img src="{{ asset('assets/images/logo/main-logo.png') }}" height="40px" alt="Logo" />
            </a>
            <button class="navbar-toggler border-0 p-0 shadow-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                <i class="ti ti-menu-2 fs-8"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 gap-xl-7 gap-8 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fs-4 fw-bold text-dark link-primary"
                            href="{{ route('frontend.homepage') }}">Home</a>
                    </li>

                    <!-- Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fs-4 fw-bold text-dark link-primary" href="#"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Department
                        </a>
                        <ul class="dropdown-menu">
                            @foreach (listDepartment() as $department)
                                <li><a class="dropdown-item" href="#">{{ $department->department_name }}</a></li>
                            @endforeach
                        </ul>
                    </li>

                </ul>

                {{-- Optional Login --}}
                {{-- <a href="../main/authentication-login.html" class="btn btn-dark btn-sm py-2 px-9">Log In</a> --}}
            </div>
        </div>
    </nav>
</header>
