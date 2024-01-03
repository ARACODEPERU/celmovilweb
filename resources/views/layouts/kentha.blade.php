<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Kentha | Sitio Web</title>
    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('themes/kentha/assets/images/isotipo.png') }}" type="image/x-icon">
    <!-- Fav Icon -->
    <!-- Google Fonts -->
    <link rel='stylesheet'
        href='https://fonts.googleapis.com/css?family=Spartan%3A400%2C500%2C600%2C700%2C800%2C900%7CInter%3A300%2C400%2C500%2C600%2C700%2C800%2C900&subset=latin%2Clatin-ext'
        type='text/css' media='all' />
    <!-- Google Fonts -->
    <!-- Style -->
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/bootstrap.min.css') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/owl.css') }}' type='text/css' media='all' />
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/swiper.min.css') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/jquery.fancybox.min.css') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/icomoon.css') }}' type='text/css' media='all' />
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/flexslider.css') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/font-awesome.min.css') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/style.css') }}' type='text/css' media='all' />
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/scss/elements/theme-css.css') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' id="creote-color-switcher-css"
        href='{{ asset('themes/kentha/assets/css/scss/elements/color-switcher/color.css') }}' type='text/css'
        media='all' />
    <!-- Style-->
    <!----woocommerce---->
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/woocommerce-layout.css') }}' type='text/css'
        media='all' />
    <link rel='stylesheet' href='{{ asset('themes/kentha/assets/css/woocommerce.css') }}' type='text/css'
        media='all' />
    <!----woocommerce---->
</head>

<body class="home theme-creote page-home-default-one">


    @yield('content')
    <!---========================== javascript ==========================-->
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/jquery-3.6.0.min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/bootstrap.min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/jquery.fancybox.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/jQuery.style.switcher.min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/jquery.flexslider-min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/color-scheme.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/owl.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/swiper.min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/isotope.min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/countdown.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/simpleParallax.min.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/appear.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/jquery.countTo.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/sharer.js') }}'></script>
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/validation.js') }}'></script>
    <!-- map script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-CE0deH3Jhj6GN4YvdCFZS7DpbXexzGU"></script>
    <script src="{{ asset('themes/kentha/assets/js/gmaps.js') }}"></script>
    <script src="{{ asset('themes/kentha/assets/js/map-helper.js') }}"></script>
    <!-- main-js -->
    <script type='text/javascript' src='{{ asset('themes/kentha/assets/js/creote-extension.js') }}'></script>
    <!---========================== javascript ==========================-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
