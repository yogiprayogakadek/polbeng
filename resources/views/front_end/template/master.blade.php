<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

@include('front_end.template.partials.head')

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>

    <!-- -------------------------------------------- -->
    <!-- Header start -->
    <!-- -------------------------------------------- -->
    @include('front_end.template.partials.header')
    <!-- -------------------------------------------- -->
    <!-- Header End -->
    <!-- -------------------------------------------- -->

    <!-- ------------------------------------- -->
    <!-- Responsive Header Start -->
    <!-- ------------------------------------- -->
    @include('front_end.template.partials.header_responsive')
    <!-- ------------------------------------- -->
    <!-- Responsive Header End -->
    <!-- ------------------------------------- -->

    <div class="main-wrapper overflow-hidden">
        @yield('content')
    </div>

    <!-- ------------------------------------- -->
    <!-- Footer Start -->
    <!-- ------------------------------------- -->
    @include('front_end.template.partials.footer')
    <!-- ------------------------------------- -->
    <!-- Footer End -->
    <!-- ------------------------------------- -->

    <!-- Scroll Top -->
    <a href="javascript:void(0)"
        class="top-btn btn btn-primary d-flex align-items-center justify-content-center round-54 p-0 rounded-circle">
        <i class="ti ti-arrow-up fs-7"></i>
    </a>

    @include('front_end.template.partials.script')
</body>

</html>
