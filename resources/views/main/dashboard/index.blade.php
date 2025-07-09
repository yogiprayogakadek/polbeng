@extends('template.master')

@section('page-title', 'Dashboard')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@section('content')

@endsection

@push('script')
    <script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            // $('#breadcrumb').hide()
            setTimeout(() => {
                $('[id^="mini-"]').removeClass('selected');
                $('#dashboard').addClass('selected');
                $('body').attr('data-sidebartype', 'mini-sidebar');

                $('.container-fluid').css('max-width', '1500px');
            }, 1000);
        });
    </script>
@endpush
