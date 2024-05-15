<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name') }}
        {{ isset($pageTitle) ? ' | ' . $pageTitle : '' }} {{ isset($pageSubTitle) ? ' ' . $pageSubTitle : '' }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    @include('layouts.partials.favicon')

    <!-- plugin css -->
    <link href="{{ asset(mix('plugins/css/fortawesome/fontawesome.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('plugins/css/overlayscrollbars/OverlayScrollbars.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('plugins/css/select2/select2.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('plugins/css/select2-bootstrap4-theme/select2-bootstrap4.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('plugins/css/sweetalert2/sweetalert2.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('plugins/css/sweetalert2/theme-bootstrap-4/bootstrap-4.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('plugins/css/waitme/waitMe.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('plugins/css/datatables.net-bs4/dataTables.bootstrap4.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('plugins/css/icheck-bootstrap/icheck-bootstrap.min.css')) }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset(mix('plugins/css/daterangepicker/daterangepicker.css')) }}">
    <link rel="stylesheet"
        href="{{ asset(mix('plugins/css/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('plugins/css/chart/Chart.min.css')) }}">
    <link href="{{ asset(mix('css/app.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('css/style.min.css')) }}" rel="stylesheet" />

    @stack('plugin-styles')

    @stack('style')
</head>

<body data-base-url="{{ url('/') }}"
    class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
    <div class="wrapper" id="app">

        {{-- navbar --}}
        @include('layouts.partials.navbar')
        {{-- end navbar --}}

        {{-- sidebar --}}
        @include('layouts.partials.sidebar')
        {{-- end of sidebar --}}

        <div class="content-wrapper">
            @include('layouts.partials.header')

            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>

            @include('layouts.partials.footer')
        </div>

    </div>

    @include('layouts.partials.modal')

    <script src="{{ asset(mix('js/app.min.js')) }}"></script>
    <script src="{{ asset(mix('plugins/js/bs-custom-file-input/bs-custom-file-input.min.js')) }}"></script>
    <script>
        var loading =
            '<div class="spinner-border text-warning" role="status"><span class="sr-only">Loading...</span></div>';
        $.fn.select2.defaults.set('theme', 'bootstrap');
        $('.select2').select2({
            theme: 'bootstrap4'
        });
        bsCustomFileInput.init();
    </script>
    <script src="{{ asset(mix('plugins/js/overlayscrollbars/jquery.overlayScrollbars.min.js')) }}"></script>
    <script src="{{ asset(mix('plugins/js/waitme/waitMe.min.js')) }}"></script>
    <script src="{{ asset(mix('plugins/js/daterangepicker/daterangepicker.js')) }}"></script>
    <script src="{{ asset(mix('plugins/js/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.js')) }}"></script>
    <script src="{{ asset(mix('js/adminlte.min.js')) }}"></script>
    <script src="{{ asset(mix('plugins/js/chart/Chart.bundle.min.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="{{ asset(mix('plugins/js/vue/vue.js')) }}"></script>
    <script src="{{ asset(mix('plugins/js/jquery-validation/jquery.validate.min.js')) }}"></script>

    @stack('plugin-scripts')
    @stack('custom-scripts')
</body>

</html>
