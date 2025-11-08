<div>


    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen'></i>
            <span class="logo navLogo">
                <a href="{{ route('web_inicio') }}">
                    <img style="width: 140px;" src="{{ $tel_email_logo[2]->content }}" alt="celmovil_logo" />
                </a>
            </span>
            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo">
                        <a href="{{ route('web_inicio') }}">
                            <img style="width: 140px;" src="{{ $tel_email_logo[2]->content }}" alt="celmovil_logo" />
                        </a>
                    </span>
                    <i class='bx bx-x siderbarClose'></i>
                </div>
                <ul class="nav-links">
                    <li><a href="{{ route('web_inicio') }}">Home</a></li>
                    @if ($categories && count($categories) > 0)
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('web_producto_principal', $category->id) }}">
                                    {{ $category->description }}
                                </a>
                                @if ($category->subcategories && count($category->subcategories) > 0)
                                    <ul class="sub-menu">
                                        @foreach ($category->subcategories as $subcategory)
                                            <li>
                                                <a href="{{ route('web_producto_principal', $subcategory->id) }}">
                                                    {{ $subcategory->description }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="darkLight-searchBox">
                <div class="dark-light">
                    <i class='bx bx-moon moon'></i>
                    <i class='bx bx-sun sun'></i>
                </div>
                <div class="searchBox">

                    <div class="searchToggle">
                        <div class="cart-menu-area floatright" style="margin-top: -80px;">
                            <ul>
                                <li>
                                    <a href="{{ route('web_carrito') }}">
                                        <i class="pe-7s-shopbag"></i>
                                        <span hidden id="contadorCarritoWeb"></span>
                                    </a>
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
                    <div class="search-field">
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <style>
        /* ===== Colours ===== */
        :root {
            --body-color: #F2F2F2;
            --nav-color: #000;
            --side-nav: #242526;
            --text-color: #FFF;
            --search-bar: #F2F2F2;
            --search-text: #010718;
        }

        body {
            height: 100vh;
            background-color: var(--body-color);
        }

        body.dark {
            --body-color: #18191A;
            --nav-color: #000;
            --side-nav: #242526;
            --text-color: #CCC;
            --search-bar: #242526;
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 70px;
            width: 100%;
            background-color: var(--nav-color);
            z-index: 100;
        }

        body.dark nav {
            border: 1px solid #393838;
        }

        nav .nav-bar {
            position: relative;
            height: 100%;
            width: 100%;
            background-color: var(--nav-color);
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        nav .nav-bar .sidebarOpen {
            color: var(--text-color);
            font-size: 25px;
            padding: 5px;
            cursor: pointer;
            display: none;
        }

        nav .nav-bar .logo a {
            font-size: 25px;
            font-weight: 500;
            color: var(--text-color);
            text-decoration: none;
        }

        .menu .logo-toggle {
            display: none;
        }

        .nav-bar .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-bar .nav-links li {
            margin: 0 5px;
            list-style: none;
            position: relative;
            /* Required for sub-menu positioning */
        }

        .nav-links li a {
            position: relative;
            font-size: 17px;
            font-weight: 400;
            color: var(--text-color);
            text-decoration: none;
            padding: 10px;
        }

        .nav-links li a::before {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            height: 6px;
            width: 6px;
            border-radius: 50%;
            background-color: var(--text-color);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .nav-links li:hover a::before {
            opacity: 1;
        }

        /* Estilos para el submenú */
        .sub-menu {
            display: none;
            /* Ocultar submenú por defecto */
            position: absolute;
            top: 100%;
            /* Posicionar debajo del elemento padre */
            left: 0;
            background-color: #444;
            /* Color de fondo del submenú */
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 100;
            border-radius: 5px;
            /* Bordes redondeados */
        }

        .nav-links li:hover .sub-menu {
            display: block;
            /* Mostrar submenú al pasar el ratón */
        }

        .sub-menu li {
            margin: 0;
            /* Sin margen */
            padding: 5px 0;
            /* Espaciado entre elementos */
            width: 320px;
        }

        .sub-menu li a {
            padding: 10px 15px;
            /* Espaciado interno en enlaces */
            font-size: 15px;
            /* Tamaño de fuente para submenú */
            color: var(--text-color);
            /* Color del texto */
            text-decoration: none;
            /* Sin subrayado */
            display: block;
            /* Hacer que el enlace ocupe toda la fila */
            transition: background-color 0.3s ease;
            /* Transición suave */
        }

        .sub-menu li a:hover {
            background-color: #ff6600;
            /* Color de fondo al pasar el ratón */
            color: #fff;
            /* Cambiar color del texto al pasar el ratón */
        }

        .sub-menu li a::before {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            height: 0px;
            width: 0px;
            border-radius: 50%;
            background-color: var(--text-color);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .nav-bar .darkLight-searchBox {
            display: flex;
            align-items: center;
        }

        .darkLight-searchBox .dark-light,
        .darkLight-searchBox .searchToggle {
            height: 40px;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
        }

        .dark-light i,
        .searchToggle i {
            position: absolute;
            color: var(--text-color);
            font-size: 22px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dark-light i.sun {
            opacity: 0;
            pointer-events: none;
        }

        .dark-light.active i.sun {
            opacity: 1;
            pointer-events: auto;
        }

        .dark-light.active i.moon {
            opacity: 0;
            pointer-events: none;
        }

        .searchToggle i.cancel {
            opacity: 0;
            pointer-events: none;
        }

        .searchToggle.active i.cancel {
            opacity: 1;
            pointer-events: auto;
        }

        searchToggle.active i.search {
            opacity: 0;
            pointer-events: none;
        }

        .searchBox {
            position: relative;
        }

        .searchBox .search-field {
            position: absolute;
            bottom: -85px;
            right: 5px;
            height: 50px;
            width: 300px;
            display: flex;
            align-items: center;
            background-color: var(--nav-color);
            padding: 3px;
            border-radius: 6px;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .searchToggle.active~.search-field {
            bottom: -74px;
            opacity: 1;
            pointer-events: auto;
        }

        .search-field::before {
            content: '';
            position: absolute;
            right: 14px;
            top: -4px;
            height: 12px;
            width: 12px;
            background-color: var(--nav-color);
            transform: rotate(-45deg);
            z-index: -1;
        }

        .search-field input {
            height: 100%;
            width: 100%;
            padding: 0 45px 0 15px;
            outline: none;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 400;
            color: var(--search-text);
            background-color: var(--search-bar);
        }

        body.dark .search-field input {
            color: var(--text-color);
        }

        .search-field i {
            position: absolute;
            color: var(--nav-color);
            right: 15px;
            font-size: 22px;
            cursor: pointer;
        }

        body.dark .search-field i {
            color: var(--text-color);
        }

        /* Responsive Styles */
        @media (max-width: 790px) {
            nav .nav-bar .sidebarOpen {
                display: block;
            }

            .menu {
                position: fixed;
                height: 100%;
                width: 320px;
                left: -100%;
                top: 0;
                padding: 20px;
                background-color: var(--side-nav);
                z-index: 100;
                transition: all 0.4s ease;
            }

            nav.active .menu {
                left: 0;
                /* Slide in from the left */
            }

            nav.active .nav-bar .navLogo a {
                opacity: 0;
                transition: all 0.3s ease;
            }

            .menu .logo-toggle {
                display: block;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .logo-toggle .siderbarClose {
                color: var(--text-color);
                font-size: 24px;
                cursor: pointer;
            }

            .nav-bar .nav-links {
                flex-direction: column;
                padding-top: 30px;
            }

            .nav-links li a {
                display: block;
                margin-top: 20px;
            }

            .sub-menu {
                position: static;
                /* Ajustar para móviles */
                box-shadow: none;
                /* Quitar sombra para móviles */
            }

            .nav-links li:hover .sub-menu {
                display: block;
                /* Mostrar submenú al hacer clic o tocar */
            }
        }
    </style>



    <script>
        const body = document.querySelector("body"),
            nav = document.querySelector("nav"),
            modeToggle = document.querySelector(".dark-light"),
            searchToggle = document.querySelector(".searchToggle"),
            sidebarOpen = document.querySelector(".sidebarOpen"),
            siderbarClose = document.querySelector(".siderbarClose");

        // Recuperar el modo guardado en localStorage
        let getMode = localStorage.getItem("mode");
        if (getMode && getMode === "dark-mode") {
            body.classList.add("dark");
        }

        // Cambiar entre modo oscuro y claro
        modeToggle.addEventListener("click", () => {
            modeToggle.classList.toggle("active");
            body.classList.toggle("dark");
            // Guardar la preferencia del usuario
            if (!body.classList.contains("dark")) {
                localStorage.setItem("mode", "light-mode");
            } else {
                localStorage.setItem("mode", "dark-mode");
            }
        });

        // Alternar la búsqueda
        searchToggle.addEventListener("click", () => {
            searchToggle.classList.toggle("active");
        });

        // Abrir el menú lateral
        sidebarOpen.addEventListener("click", () => {
            nav.classList.add("active");
        });

        // Cerrar el menú lateral
        siderbarClose.addEventListener("click", () => {
            nav.classList.remove("active");
        });

        // Cerrar el menú al hacer clic fuera de él
        body.addEventListener("click", e => {
            let clickedElm = e.target;
            if (!clickedElm.classList.contains("sidebarOpen") && !clickedElm.closest('.menu')) {
                nav.classList.remove("active");
            }
        });

        // Alternar submenús en pantallas móviles
        document.querySelectorAll('.nav-links > li > a').forEach(item => {
            item.addEventListener('click', event => {
                const submenu = item.nextElementSibling;
                if (submenu) {
                    submenu.classList.toggle('active');
                    event.preventDefault(); // Evitar el comportamiento por defecto si hay submenú
                }
            });
        });
    </script>








    {{-- HEADER ANTIGUO --}}
    {{-- <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen'></i>
            <span class="logo navLogo">
                <a href="{{ route('web_inicio') }}">
                    <img style="width: 140px;" src="{{ $tel_email_logo[2]->content }}" alt="celmovil_logo" />
                </a>
            </span>
            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo">
                        <a href="{{ route('web_inicio') }}">
                            <img style="width: 140px;" src="{{ $tel_email_logo[2]->content }}" alt="celmovil_logo" />
                        </a>
                    </span>
                    <i class='bx bx-x siderbarClose'></i>
                </div>
                <ul class="nav-links">
                    <li><a href="{{ route('web_inicio') }}">Home</a></li>
                    @if ($categories && count($categories) > 0)
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('web_producto_principal', $category->id) }}">
                                    {{ $category->description }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="darkLight-searchBox">
                <div class="dark-light">
                    <i class='bx bx-moon moon'></i>
                    <i class='bx bx-sun sun'></i>
                </div>
                <div class="searchBox">
                    
                    <div class="searchToggle">
                        <div class="cart-menu-area floatright" style="margin-top: -80px;">
                        <ul>
                            <li>
                                <a href="{{ route('web_carrito') }}">
                                    <i class="pe-7s-shopbag"></i>
                                    <span hidden id="contadorCarritoWeb"></span>
                                </a>
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
                    <div class="search-field">
                    </div> 
                </div>
            </div>
        </div>
    </nav> --}}


    {{-- <style>
        :root {
            --body-color: #F2F2F2;
            --nav-color: #000;
            --side-nav: #242526;
            --text-color: #FFF;
            --search-bar: #F2F2F2;
            --search-text: #010718;
        }

        body {
            height: 100vh;
            background-color: var(--body-color);
        }

        body.dark {
            --body-color: #18191A;
            --nav-color: #000;
            --side-nav: #242526;
            --text-color: #CCC;
            --search-bar: #242526;
        }

        nav {
            position: fixed;
            top: 0;
            left: 0;
            height: 70px;
            width: 100%;
            background-color: var(--nav-color);
            z-index: 100;
        }

        body.dark nav {
            border: 1px solid #393838;
        }

        nav .nav-bar {
            position: relative;
            height: 100%;
            width: 100%;
            background-color: var(--nav-color);
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        nav .nav-bar .sidebarOpen {
            color: var(--text-color);
            font-size: 25px;
            padding: 5px;
            cursor: pointer;
            display: none;
        }

        nav .nav-bar .logo a {
            font-size: 25px;
            font-weight: 500;
            color: var(--text-color);
            text-decoration: none;
        }

        .menu .logo-toggle {
            display: none;
        }

        .nav-bar .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-bar .nav-links li {
            margin: 0 5px;
            list-style: none;
        }

        .nav-links li a {
            position: relative;
            font-size: 17px;
            font-weight: 400;
            color: var(--text-color);
            text-decoration: none;
            padding: 10px;
        }

        .nav-links li a::before {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            height: 6px;
            width: 6px;
            border-radius: 50%;
            background-color: var(--text-color);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .nav-links li:hover a::before {
            opacity: 1;
        }

        .nav-bar .darkLight-searchBox {
            display: flex;
            align-items: center;
        }

        .darkLight-searchBox .dark-light,
        .darkLight-searchBox .searchToggle {
            height: 40px;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
        }

        .dark-light i,
        .searchToggle i {
            position: absolute;
            color: var(--text-color);
            font-size: 22px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dark-light i.sun {
            opacity: 0;
            pointer-events: none;
        }

        .dark-light.active i.sun {
            opacity: 1;
            pointer-events: auto;
        }

        .dark-light.active i.moon {
            opacity: 0;
            pointer-events: none;
        }

        .searchToggle i.cancel {
            opacity: 0;
            pointer-events: none;
        }

        .searchToggle.active i.cancel {
            opacity: 1;
            pointer-events: auto;
        }

        .searchToggle.active i.search {
            opacity: 0;
            pointer-events: none;
        }

        .searchBox {
            position: relative;
        }

        .searchBox .search-field {
            position: absolute;
            bottom: -85px;
            right: 5px;
            height: 50px;
            width: 300px;
            display: flex;
            align-items: center;
            background-color: var(--nav-color);
            padding: 3px;
            border-radius: 6px;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .searchToggle.active~.search-field {
            bottom: -74px;
            opacity: 1;
            pointer-events: auto;
        }

        .search-field::before {
            content: '';
            position: absolute;
            right: 14px;
            top: -4px;
            height: 12px;
            width: 12px;
            background-color: var(--nav-color);
            transform: rotate(-45deg);
            z-index: -1;
        }

        .search-field input {
            height: 100%;
            width: 100%;
            padding: 0 45px 0 15px;
            outline: none;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 400;
            color: var(--search-text);
            background-color: var(--search-bar);
        }

        body.dark .search-field input {
            color: var(--text-color);
        }

        .search-field i {
            position: absolute;
            color: var(--nav-color);
            right: 15px;
            font-size: 22px;
            cursor: pointer;
        }

        body.dark .search-field i {
            color: var(--text-color);
        }

        @media (max-width: 790px) {
            nav .nav-bar .sidebarOpen {
                display: block;
            }

            .menu {
                position: fixed;
                height: 100%;
                width: 320px;
                left: -100%;
                top: 0;
                padding: 20px;
                background-color: var(--side-nav);
                z-index: 100;
                transition: all 0.4s ease;
            }

            nav.active .menu {
                left: -0%;
            }

            nav.active .nav-bar .navLogo a {
                opacity: 0;
                transition: all 0.3s ease;
            }

            .menu .logo-toggle {
                display: block;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .logo-toggle .siderbarClose {
                color: var(--text-color);
                font-size: 24px;
                cursor: pointer;
            }

            .nav-bar .nav-links {
                flex-direction: column;
                padding-top: 30px;
            }

            .nav-links li a {
                display: block;
                margin-top: 20px;
            }
        }
    </style>

    <script>
        const body = document.querySelector("body"),
            nav = document.querySelector("nav"),
            modeToggle = document.querySelector(".dark-light"),
            searchToggle = document.querySelector(".searchToggle"),
            sidebarOpen = document.querySelector(".sidebarOpen"),
            siderbarClose = document.querySelector(".siderbarClose");
        let getMode = localStorage.getItem("mode");
        if (getMode && getMode === "dark-mode") {
            body.classList.add("dark");
        }
        modeToggle.addEventListener("click", () => {
            modeToggle.classList.toggle("active");
            body.classList.toggle("dark");
            if (!body.classList.contains("dark")) {
                localStorage.setItem("mode", "light-mode");
            } else {
                localStorage.setItem("mode", "dark-mode");
            }
        });
        searchToggle.addEventListener("click", () => {
            searchToggle.classList.toggle("active");
        });


        sidebarOpen.addEventListener("click", () => {
            nav.classList.add("active");
        });
        body.addEventListener("click", e => {
            let clickedElm = e.target;
            if (!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")) {
                nav.classList.remove("active");
            }
        });
    </script> --}}








    {{-- CARRITO --}}
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
        {{-- <div id="sticky-menu" class="header-bottom">
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
                                    <li>
                                        <a href="{{ route('web_inicio') }}">
                                            <i class="fa fa-home" style="font-size: 18px;"></i>
                                        </a>
                                    </li>
                                    @if ($categories && count($categories) > 0)
                                        @foreach ($categories as $category)
                                            <li>
                                                <a href="{{ route('web_producto_principal', $category->id) }}">
                                                    {{ $category->description }}
                                                </a>
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
                        <div class="mobile-menu-area">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul>
                                        <li><a href="{{ route('web_inicio') }}">Inicio</a></li>
                                        @if ($categories && count($categories) > 0)
                                            @foreach ($categories as $category)
                                                <li>
                                                    <a href="{{ route('web_producto_principal', $category->id) }}">
                                                        {{ $category->description }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                post_url = "{{ route('onlineshop_get_item_carrito') }}";
                token = "{{ csrf_token() }}";
                load_post_url(post_url, token);
                cargarItemsCarritoBD();
            });
        </script>


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

        {{-- bloqueo por no pago --}}
        {{-- <div id="modal-overlay-bloqueo" class="modal-overlay-bloqueo">
            <div class="modal-bloqueo">
                <h2>En breve continuamos... </h2>
                <div id="countdown-bloqueo" class="countdown-bloqueo">15</div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalOverlay = document.getElementById('modal-overlay-bloqueo');
                const countdownElement = document.getElementById('countdown-bloqueo');
                let countdown = 15;

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
