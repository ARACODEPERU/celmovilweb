<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CAP | Sitio Web</title>
    <!--fivicon icon-->
    <link rel="icon" href="{{ asset('themes/capperu/assets/img/fevicon-cap.png') }}">
    <!--fivicon icon
    <link rel="icon" href="assets/img/fevicon.png">
    -->

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/magnific.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/owl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/slick-slide.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/aracode.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/capperu/assets/css/responsive.css') }}">

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

</head>

<body class='sc5'>
    <script src="{{ asset('themes/capperu/assets/js/capperu-carrito.js') }}"></script>
    @yield('content')

    <!-- back-to-top end -->
    <div class="back-to-top">
        <span class="back-top"><i class="fas fa-angle-double-up"></i></span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- all plugins here -->
    <script src="{{ asset('themes/capperu/assets/js/jquery.3.6.min.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/imageloded.min.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/counterup.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/waypoint.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/magnific.min.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/nice-select.min.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/fontawesome.min.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/ripple.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/owl.min.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/slick-slider.min.js') }}"></script>
    <script src="{{ asset('themes/capperu/assets/js/wow.min.js') }}"></script>

    <!-- main js  -->
    <script src="{{ asset('themes/capperu/assets/js/main.js') }}"></script>

</body>

</html>
