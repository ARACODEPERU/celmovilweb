<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CelMovil || Perú</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('themes/celmovil/img/favicon.ico') }}">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->
    <!-- all css here -->
    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('themes/celmovil/style.css') }}">
    <!-- modernizr js -->
    <script src="{{ asset('themes/celmovil/js/vendor/modernizr-2.8.3.min.js') }}"></script>

    @yield('styles')
</head>

<body class="black-version">

    @yield('content')

    <!-- all js here -->
    <!-- jquery latest version -->
    <script src="{{ asset('themes/celmovil/js/vendor/jquery-1.12.3.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('themes/celmovil/js/bootstrap.min.js') }}"></script>
    <!-- camera slider JS -->
    <script src="{{ asset('themes/celmovil/js/camera.min.js') }}"></script>

    <!-- jquery.easing js -->
    <script src="{{ asset('themes/celmovil/js/jquery.easing.1.3.js') }}"></script>
    <!-- slick slider js -->
    <script src="{{ asset('themes/celmovil/js/slick.min.js') }}"></script>
    <!-- jquery-ui js -->
    <script src="{{ asset('themes/celmovil/js/jquery-ui.min.js') }}"></script>
    <!-- magnific-popup js -->
    <script src="{{ asset('themes/celmovil/js/magnific-popup.min.js') }}"></script>
    <!-- countdown js -->
    <script src="{{ asset('themes/celmovil/js/countdown.js') }}"></script>
    <!-- meanmenu js -->
    <script src="{{ asset('themes/celmovil/js/jquery.meanmenu.js') }}"></script>
    <!-- plugins js -->
    <script src="{{ asset('themes/celmovil/js/plugins.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('themes/celmovil/js/main.js') }}"></script>

    <!-- Google Map JS -->
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA_Agsvf36du-7l_mp8iu1a-rXoKcWfs2I"></script>
    <!-- Custom map-script js -->
    <script src="{{ asset('themes/celmovil/js/map-script.js') }}"></script>
    @yield('scripts')
</body>

</html>
