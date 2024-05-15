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

    <link href="{{ asset(mix('plugins/css/fortawesome/fontawesome.min.css')) }}" rel="stylesheet" />
    <link href="{{ asset(mix('css/app.min.css')) }}" rel="stylesheet" />
</head>

<body data-base-url="{{ url('/') }}"
    class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">

    @yield('content')

    <script src="{{ asset(mix('js/app.min.js')) }}"></script>
    <script src="{{ asset(mix('js/adminlte.min.js')) }}"></script>
</body>

</html>
