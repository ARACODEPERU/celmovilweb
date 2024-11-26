<div>
    <style>
        input[type="radio"] {
            display: none;
        }

        input[type="radio"]:checked+.swal2-label {
            animation: colorChange 2s infinite;
            color: blue;
        }

        @keyframes colorChange {
            0% {
                color: red;
            }

            25% {
                color: blue;
            }

            50% {
                color: rgb(34, 2, 62);
            }

            75% {
                color: rgb(79, 79, 79);
            }

            100% {
                color: black;
            }
        }
    </style>
    <header>
        <script>
            ruta_carrito = "{{ route('web_carrito') }}"

            function confirmarEliminarCarrito() {
                if (confirm("¿Estás seguro de que deseas vaciar el carrito?")) {
                    eliminarCarrito();
                }
            }
        </script>
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="left floatleft">
                            <ul>
                                <li>
                                    <i class="fa fa-phone"></i>
                                    {{ $tel_email_logo[0]->content }}
                                </li>
                                <li>
                                    <i class="fa fa-envelope-o"></i>
                                    {{ $tel_email_logo[1]->content }}
                                </li>
                            </ul>
                        </div>
                        <div class="right floatright">
                            <ul>
                                <li>
                                    <i class="fa fa-gears"></i>
                                    <a href="https://www.celmovil.pe/login">Intranet</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sticky-menu" class="header-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 header-bottom-bg">
                        <div class="logo floatleft">
                            <a href="{{ route('web_inicio') }}">
                                <img style="width: 140px;" src="{{ $tel_email_logo[2]->content }}"
                                    alt="celmovil_logo" />
                            </a>
                        </div>
                        <div class="mainmenu text-center floatleft">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('web_inicio') }}"> <i class="fa fa-home"
                                                style="font-size: 18px;"></i> </a></li>
                                    <!--
                                    <li><a href="{{ route('web_nosotros') }}">Nosotros</a></li>
                                    -->
                                    @if ($categories && count($categories) > 0)
                                        @foreach ($categories as $category)
                                            <li>
                                                @if ($category->subcategories && count($category->subcategories))
                                                    <a href="">{{ $category->description }}</a>
                                                    <ul>
                                                        @foreach ($category->subcategories as $subCategory)
                                                            <li>
                                                                <a
                                                                    href="{{ route('web_producto_categoria', $subCategory->id) }}">
                                                                    {{ $subCategory->description }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <a href="{{ route('web_producto_categoria', $category->id) }}">
                                                        {{ $category->description }}
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </nav>
                        </div>
                        <div class="cart-menu-area floatright">
                            <ul>
                                <li><a href="{{ route('web_carrito') }}"><i class="pe-7s-shopbag"></i> <span hidden
                                            id="contadorCarritoWeb"></span></a>
                                    <ul class="cart-menu" id="cart-menu">
                                        <li class="cart-menu-btn">
                                            <a href="{{ route('web_carrito') }}">Ir al Carrito</a>
                                            <a style="background-color: red; color: white;" href=""
                                                onclick="confirmarEliminarCarrito()">Vaciar Carrito</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" style="background: #ff6600; ">
                <div class="row">
                    <div class="col-md-12">
                        <!-- mobile menu start -->
                        <div class="mobile-menu-area">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul>
                                        <li><a href="{{ route('web_inicio') }}">Inicio</a></li>
                                        <!--
                                        <li><a href="{{ route('web_nosotros') }}">Nosotros</a></li>
                                        -->
                                        @if ($categories && count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <li>
                                                    @if ($category->subcategories && count($category->subcategories))
                                                        <a href="">{{ $category->description }}</a>
                                                        <ul>
                                                            @foreach ($category->subcategories as $subCategory)
                                                                <li>
                                                                    <a
                                                                        href="{{ route('web_producto_categoria', $subCategory->id) }}">
                                                                        {{ $subCategory->description }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <a href="{{ route('web_producto_categoria', $category->id) }}">
                                                            {{ $category->description }}
                                                        </a>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- mobile menu end -->
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                post_url = "{{ route('onlineshop_get_item_carrito') }}";
                token = "{{ csrf_token() }}";
                load_post_url(post_url, token);
                cargarItemsCarritoBD();
            });
        </script>


        <!-- codigo de anuncio de Bloqueo -->
        <style>
            .modal-overlay-bloqueo {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 999999;
            }

            .modal-bloqueo {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999999;
            }

            .countdown-bloqueo {
                font-size: 48px;
                font-weight: bold;
                margin: 20px 0;
            }
        </style>
{{--  bloqueo por no pago
        <div id="modal-overlay-bloqueo" class="modal-overlay-bloqueo">
            <div class="modal-bloqueo">
                <h2>Comunícate con el proveedor WEB </h2>
                <div id="countdown-bloqueo" class="countdown-bloqueo">10</div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalOverlay = document.getElementById('modal-overlay-bloqueo');
                const countdownElement = document.getElementById('countdown-bloqueo');
                let countdown = 10;

                function updateCountdown() {
                    countdownElement.textContent = countdown;
                    if (countdown > 0) {
                        countdown--;
                        setTimeout(updateCountdown, 1000);
                    } else {
                        modalOverlay.style.display = 'none';
                    }
                }

                updateCountdown();
            });
        </script> --}}

    </header>
</div>
