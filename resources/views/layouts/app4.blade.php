<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard | VehiScan</title>

    @include('layouts.head')
</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('layouts.header4')

        @include('layouts.sidebar4')

        @yield('content')

        @include('layouts.footer')

        @include('layouts.settings')

    </div>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    @include('layouts.script')
</body>

</html>