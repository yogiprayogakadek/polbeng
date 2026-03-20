<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

@include('template.partials.head')

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <!-- Sidebar Start -->
        @include('template.partials.sidebar')
        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <header class="topbar">
                <div class="with-vertical">
                    <!-- ---------------------------------- -->
                    <!-- Start Vertical Layout Header -->
                    <!-- ---------------------------------- -->
                    @include('template.partials.navbar')
                    <!-- ---------------------------------- -->
                    <!-- End Vertical Layout Header -->
                    <!-- ---------------------------------- -->

                    <!-- ------------------------------- -->
                    <!-- apps Dropdown in Small screen -->
                    <!-- ------------------------------- -->
                    <!--  Mobilenavbar -->

                </div>

            </header>
            <!--  Header End -->

            <div class="body-wrapper">
                <div class="container-fluid">
                    <style>
                        .glass-breadcrumb {
                            background: rgba(255, 255, 255, 0.7);
                            backdrop-filter: blur(10px);
                            -webkit-backdrop-filter: blur(10px);
                            border: 1px solid rgba(255, 255, 255, 0.4);
                            border-radius: 1.25rem;
                            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.03);
                        }
                        .breadcrumb-item + .breadcrumb-item::before {
                            content: "\F64D";
                            font-family: "Tabler Icons";
                            font-size: 0.8rem;
                            color: #94a3b8;
                            margin: 0 0.5rem;
                        }
                        .page-title-gradient {
                            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                        }
                    </style>

                    <div class="card glass-breadcrumb border-0 py-3 mb-4" id="breadcrumb">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="px-4 d-sm-flex align-items-center justify-space-between">
                                    <h4 class="mb-3 mb-sm-0 fw-bold tracking-tight text-dark">
                                        @yield('page-title')
                                    </h4>
                                    <nav aria-label="breadcrumb" class="ms-auto">
                                        <ol class="breadcrumb mb-0 align-items-center">
                                            <li class="breadcrumb-item d-flex align-items-center">
                                                <a class="text-muted text-decoration-none d-flex hover-primary transition-all"
                                                    href="{{ route('dashboard.admin') }}">
                                                    <iconify-icon icon="solar:home-2-bold-duotone"
                                                        class="fs-6"></iconify-icon>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item" aria-current="page">
                                                <span class="badge rounded-pill fw-bold fs-2 bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                                                    @yield('page-title')
                                                </span>
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    @yield('content')

                    <div id="printLoader" class="text-center align-content-center">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-3 fw-semibold text-primary">
                            Sedang memproses...
                        </div>
                    </div>



                    <!-- Modal -->
                    <div class="modal fade" id="modalPrint" tabindex="-1" data-bs-backdrop="static" role="dialog"
                        aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title">Cetak Absensi</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="formPrint">
                                    <div class="modal-body modal-render">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                            class="btn bg-danger-subtle text-danger  waves-effect text-start"
                                            data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="button"
                                            class="btn bg-primary-subtle text-primary  waves-effect text-start btn-cetak">Cetak</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <script>
                function handleColorTheme(e) {
                    document.documentElement.setAttribute("data-color-theme", e);
                }
            </script> --}}
        </div>

    </div>

    @include('template.partials.script')
</body>

</html>
