<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>CelMovil || Perú</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('themes/celmovil/img/logoIcon.png') }}">
    <!-- Place favicon.ico in the root directory -->
    <!-- all css here -->

    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('themes/celmovil/style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/celmovil/responsive.css') }}">
    <!-- modernizr js -->
    <script src="{{ asset('themes/celmovil/js/vendor/modernizr-2.8.3.min.js') }}"></script>

    @yield('styles')
</head>

<body class="black-version">

    @yield('content')
<!-- COOKIES -->

<div id="cookie-consent" class="cookiesMessage_cookiesDisclaimer__pF8_x">
    <h5 class="cookiesMessage_cookiesDisclaimerHeader__y_YCo">USO DE COOKIES</h5>
    <p class="cookiesMessage_cookiesDisclaimerBody__nxps1">Usamos cookies propias y de terceros para funciones esenciales
        de este sitio y mejorar tu experiencia al navegar por <a href="{{ env('APP_URL') }}">{{ env('APP_NAME') }}</a>.
        Revisa nuestro<!-- --> <a target="_blank" href="{{ route('cookies_policy') }}">Aviso de Cookies</a> para obtener
        más información al respecto.</p>
    <div class="cookiesMessage_cookiesDisclaimerButton__NwcdV">
        <button id="accept-cookies" class="cookiesMessage_cookiesDisclaimerButtonAccept__u3I5b"
            type="button">Aceptar</button>
    </div>
</div>
<style>
    .cookiesMessage_cookiesDisclaimer__pF8_x {
        display: flex;
        flex-direction: column;
        gap: 18px;
        font-family: Barlow, sans-serif;
        background-color: hsla(0, 0%, 100%, .9);
        position: fixed;
        color: #464646;
        bottom: 0;
        width: 100%;
        padding: 1rem 6rem;
        z-index: 999999;
        box-sizing: border-box;
    }
</style>

<script>
    document.getElementById('cookie-consent').style.display = "none";
    document.addEventListener('DOMContentLoaded', function() {
        const cookieConsent = document.getElementById('cookie-consent');
        const acceptButton = document.getElementById('accept-cookies');
        var consent = localStorage.getItem('cookieConsent');
        if (!(consent === 'true')) {
            cookieConsent.style.display = "block";
        }

        function showCookieConsent() {
            if (localStorage.getItem('cookieConsent') !== 'true') {
                cookieConsent.classList.remove('hidden');
                setTimeout(() => {
                    cookieConsent.style.transform = 'translateY(0)';
                    cookieConsent.style.opacity = '1';
                }, 100);
            }
        }

        function hideCookieConsent() {
            cookieConsent.style.transform = 'translateY(100%)';
            cookieConsent.style.display = 'none';
            setTimeout(() => {
                cookieConsent.classList.add('hidden');
            }, 300);
        }

        function acceptCookies() {
            localStorage.setItem('cookieConsent', 'true');
            hideCookieConsent();
        }

        acceptButton.addEventListener('click', acceptCookies);

        showCookieConsent();
    });
</script>

<!-- Fin de Cookies -->

    <!-- all js here -->
    <script src="{{ asset('themes/celmovil/js/celmovil-carrito.js') }}"></script>
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
