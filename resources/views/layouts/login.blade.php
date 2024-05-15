<!DOCTYPE html>
<html class="h-100">

<head>
    <title>{{ config('app.name') }} | Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    @include('layouts.partials.favicon')

    <!-- plugin css -->
    <link href="{{ asset(mix('plugins/css/fortawesome/fontawesome.min.css')) }}" rel="stylesheet" />
    <!-- end plugin css -->

    @stack('plugin-styles')

    <!-- common css -->
    <link href="{{ asset(mix('css/app.min.css')) }}" rel="stylesheet" />
    <!-- end common css -->

    @stack('style')
</head>

<body data-base-url="{{ url('/') }}" class="h-100">
    <div class="main-wrapper h-100" id="app">
        <div class="page-wrapper full-page h-100">
            @yield('content')
        </div>
    </div>

    <!-- base js -->
    <script src="{{ asset(mix('js/app.min.js')) }}"></script>
    <script src="{{ asset(mix('js/adminlte.min.js')) }}"></script>
    <!-- end base js -->

    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->
    @stack('custom-scripts')
</body>

</html>
