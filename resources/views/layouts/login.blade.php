
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Simple Laravel 10 User Roles and Permissions - AllPHPTricks.com</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo url('theme')?>/dist/assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?php echo url('theme')?>/dist/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo url('theme')?>/dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo url('theme')?>/dist/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="<?php echo url('theme')?>/dist/assets/js/plugin.js"></script>

            <!-- App favicon -->
            <link rel="shortcut icon" href="<?php echo url('theme')?>/dist/assets/images/favicon.ico">

<!-- Bootstrap Css -->
<link href="<?php echo url('theme')?>/dist/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="<?php echo url('theme')?>/dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="<?php echo url('theme')?>/dist/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<!-- App js -->
<script src="<?php echo url('theme')?>/dist/assets/js/plugin.js"></script>
</head>
<body>
    @if ($message = Session::get('success'))
        <div class="alert alert-success text-center" role="alert">
            {{ $message }}
        </div>
    @endif

    
    @yield('content')


         <!-- JAVASCRIPT -->
         <script src="<?php echo url('theme')?>/dist/assets/libs/jquery/jquery.min.js"></script>
        <script src="<?php echo url('theme')?>/dist/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo url('theme')?>/dist/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo url('theme')?>/dist/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo url('theme')?>/dist/assets/libs/node-waves/waves.min.js"></script>
        
        <!-- App js -->
        <script src="<?php echo url('theme')?>/dist/assets/js/app.js"></script>
</body>
</html>