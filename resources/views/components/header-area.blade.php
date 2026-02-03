
<div>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-left">
                <a href="tel:+51999999999"><i class="fa fa-phone"></i> (+51) 921 197 459</a>
                <span class="divider">|</span>
                <a href="mailto:ventas@celmovil.pe"><i class="fa fa-envelope"></i> ventas@celmovil.pe</a>
                <span><i class="fa fa-truck"></i> Envíos a todo el Perú</span>
            </div>
            <div class="top-bar-right">
                ¡Líder en Motos Eléctricas en Trujillo, La Libertad!
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header id="main-header">
        <div class="container header-container">
            <!-- Mobile Menu Trigger -->
            <div class="mobile-menu-trigger" id="mobile-menu-open">
                <i class='bx bx-menu'></i>
            </div>

            <!-- Logo -->
            <a href="{{ route('web_inicio') }}" class="header-logo">
                <img src="{{ $tel_email_logo[2]->content }}" alt="Celmovil" />
            </a>

            <!-- Desktop Navigation -->
            <nav class="desktop-nav">
                <ul class="nav-menu">
                    <li><a href="{{ route('web_inicio') }}">INICIO</a></li>
                    @forelse ($categories ?? [] as $category)
                        <li class="menu-item-has-children">
                            <a href="{{ route('web_producto_principal', $category->id) }}">
                                {{ $category->description }}
                                @if (isset($category->subcategories) && $category->subcategories->isNotEmpty())
                                    <i class='bx bx-chevron-down'></i>
                                @endif
                            </a>
                            @if (isset($category->subcategories) && $category->subcategories->isNotEmpty())
                                <div class="mega-menu">
                                    <div class="container">
                                        <div class="mega-menu-inner">
                                            <div class="mega-menu-list">
                                                <h4>Categorías</h4>
                                                <ul>
                                                    @foreach ($category->subcategories as $subcategory)
                                                        <li>
                                                            <a href="{{ route('web_producto_principal', $subcategory->id) }}">
                                                                {{ $subcategory->description }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="mega-menu-promo">
                                                <div class="promo-card">
                                                    <img src="{{ $category->image ?? asset('themes/celmovil/img/promo-placeholder.jpg') }}" alt="{{ $category->description }}">
                                                    <div class="promo-content">
                                                        <h5>Lo mejor en {{ $category->description }}</h5>
                                                        <a href="{{ route('web_producto_principal', $category->id) }}" class="btn-promo">Ver Todo</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </li>
                    @empty
                    @endforelse
                </ul>
            </nav>

            <!-- Header Icons -->
            <div class="header-actions">
                <div class="icon-btn search-trigger" id="search-open">
                    <i class='bx bx-search'></i>
                </div>
                <div class="icon-btn user-trigger">
                    <a href="{{ route('login') }}"><i class='bx bx-user'></i></a>
                </div>
                <div class="icon-btn cart-trigger" id="cart-open">
                    <i class='bx bx-shopping-bag'></i>
                    <span class="badge" id="contadorCarritoWeb">0</span>
                </div>
                <div class="icon-btn theme-toggle" id="theme-toggle">
                    <i class='bx bx-moon moon'></i>
                    <i class='bx bx-sun sun'></i>
                </div>
            </div>
        </div>


    </header>

    <!-- Search Overlay -->
    <div class="search-overlay" id="search-overlay">
        <div class="search-close" id="search-close"><i class='bx bx-x'></i></div>
        <div class="search-content">
            <h3>¿Qué estás buscando?</h3>
            <form action="#" class="search-form-overlay">
                <input type="text" placeholder="Buscar productos...">
                <button type="submit"><i class='bx bx-search'></i></button>
            </form>
        </div>
    </div>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cart-sidebar">
        <div class="cart-sidebar-header">
            <h3>Tu Carrito</h3>
            <div class="cart-close" id="cart-close"><i class='bx bx-x'></i></div>
        </div>
        <div class="cart-sidebar-body">
            <!-- The JS populates #cart-menu with li items -->
            <ul id="cart-menu" class="cart-items-list">
                <!-- Items injected by JS -->
            </ul>
        </div>
        <div class="cart-sidebar-footer">
            <div class="cart-total-row">
                <span>Total:</span>
                <span id="totalid">S/ 0.00</span>
            </div>
            <div class="cart-buttons">
                <a href="{{ route('web_carrito') }}" class="btn-cart btn-view">Ver Carrito</a>
                <a href="{{ route('web_carrito') }}" class="btn-cart btn-checkout">Finalizar Compra</a>
            </div>
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobile-menu">
        <div class="mobile-menu-header">
            <img src="{{ $tel_email_logo[2]->content }}" alt="Celmovil">
            <div class="mobile-close" id="mobile-close"><i class='bx bx-x'></i></div>
        </div>
        <div class="mobile-menu-body">
            <ul class="mobile-nav-list">
                <li><a href="{{ route('web_inicio') }}">Inicio</a></li>
                @forelse ($categories ?? [] as $category)
                    <li class="mobile-has-children">
                        <div class="mobile-link-wrapper">
                            <a href="{{ route('web_producto_principal', $category->id) }}">{{ $category->description }}</a>
                            @if (isset($category->subcategories) && $category->subcategories->isNotEmpty())
                                <span class="mobile-submenu-toggle"><i class='bx bx-plus'></i></span>
                            @endif
                        </div>
                        @if (isset($category->subcategories) && $category->subcategories->isNotEmpty())
                            <ul class="mobile-submenu">
                                @foreach ($category->subcategories as $subcategory)
                                    <li><a href="{{ route('web_producto_principal', $subcategory->id) }}">{{ $subcategory->description }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @empty
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Styles -->
    <style>
        /* Variables */
        :root {
            --primary-color: #ff6600;
            --primary-dark: #e65c00;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #ffffff;
            --bg-dark: #111827;
            --header-height: 80px;
            --transition: all 0.3s ease;
        }

        /* Reset & Base */
        ul { list-style: none; padding: 0; margin: 0; }
        a { text-decoration: none; color: inherit; }

        /* Top Bar */
        .top-bar {
            background-color: var(--primary-color);
            color: white;
            font-size: 13px;
            padding: 8px 0;
            position: relative;
            z-index: 1001;
        }
        .top-bar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-bar-right a { margin-left: 15px; }
        .top-bar-right a:hover { text-decoration: underline; }
        .top-bar .divider { margin-left: 15px; opacity: 0.5; }

        /* Main Header */
        #main-header {
            position: fixed;
            top: 35px; /* Height of top-bar approx */
            left: 0;
            width: 100%;
            height: var(--header-height);
            /* background: transparent; */
            background: #000;
            z-index: 1000;
            transition: var(--transition);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        #main-header.scrolled {
            /* background: rgba(255, 255, 255, 0.95); */
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            top: 0;
        }
        body.dark #main-header.scrolled {
            background: rgba(17, 24, 39, 0.95);
            border-bottom: 1px solid #374151;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }

        .header-logo img {
            height: 65px;
            transition: var(--transition);
        }

        /* Desktop Nav */
        .desktop-nav { display: none; }
        @media (min-width: 992px) {
            .desktop-nav { display: block; }
        }

        .nav-menu { display: flex; gap: 30px; }
        .nav-menu > li > a {
            font-weight: 600;
            font-size: 15px;
            color: white; /* Default transparent state */
            padding: 30px 0;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }
        /* #main-header.scrolled .nav-menu > li > a { color: var(--text-dark); } */
        #main-header.scrolled .nav-menu > li > a {
            color: #ffffff;
        }
        body.dark #main-header.scrolled .nav-menu > li > a { color: white; }

        .nav-menu > li:hover > a { color: var(--primary-color) !important; }

        /* Mega Menu */
        .mega-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: var(--transition);
            border-top: 2px solid var(--primary-color);
        }
        body.dark .mega-menu { background: var(--bg-dark); border-top-color: var(--primary-color); }

        .menu-item-has-children:hover .mega-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .mega-menu-inner {
            display: flex;
            padding: 30px 0;
        }
        .mega-menu-list { flex: 3; }
        .mega-menu-promo { flex: 1; }

        .mega-menu-list h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text-dark);
            text-transform: uppercase;
        }
        body.dark .mega-menu-list h4 { color: white; }

        .mega-menu-list ul {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .mega-menu-list ul li a {
            color: var(--text-light);
            font-size: 14px;
            transition: var(--transition);
        }
        .mega-menu-list ul li a:hover { color: var(--primary-color); padding-left: 5px; }

        /* Header Icons */
        .header-actions { display: flex; gap: 20px; align-items: center; }
        .icon-btn {
            font-size: 22px;
            color: white;
            cursor: pointer;
            position: relative;
            transition: var(--transition);
        }
        /* #main-header.scrolled .icon-btn { color: var(--text-dark); } */
        #main-header.scrolled .icon-btn {
            color: #FFFFFF;
        }
        body.dark #main-header.scrolled .icon-btn { color: white; }
        .icon-btn:hover { color: var(--primary-color) !important; transform: scale(1.1); }

        .badge {
            position: absolute;
            top: -5px;
            right: -8px;
            background: var(--primary-color);
            color: white;
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Dark Mode Toggle */
        .theme-toggle .sun { display: none; }
        body.dark .theme-toggle .moon { display: none; }
        body.dark .theme-toggle .sun { display: block; }

        /* Search Overlay */
        .search-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }
        .search-overlay.active { opacity: 1; visibility: visible; }
        .search-close {
            position: absolute;
            top: 30px;
            right: 30px;
            font-size: 40px;
            color: white;
            cursor: pointer;
        }
        .search-content { text-align: center; width: 100%; max-width: 800px; padding: 20px; }
        .search-content h3 { color: white; margin-bottom: 30px; font-size: 2rem; }
        .search-form-overlay { position: relative; }
        .search-form-overlay input {
            height: 100%;
            background: transparent;
            border: none;
            border-bottom: 2px solid rgba(255,255,255,0.5);
            padding: 15px 50px 15px 10px;
            font-size: 24px;
            color: white;
            outline: none;
        }
        .search-form-overlay button {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        /* Cart Sidebar */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100%;
            background: white;
            z-index: 2000;
            box-shadow: -5px 0 30px rgba(0,0,0,0.1);
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }
        body.dark .cart-sidebar { background: var(--bg-dark); border-left: 1px solid #374151; }
        .cart-sidebar.active { right: 0; }

        .cart-sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        body.dark .cart-sidebar-header { border-bottom-color: #374151; }
        .cart-sidebar-header h3 { margin: 0; font-size: 18px; font-weight: 700; }
        .cart-close { font-size: 24px; cursor: pointer; }

        .cart-sidebar-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }
        /* Styling for items injected by JS */
        .cart-items-list li {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f5f5f5;
            position: relative;
        }
        body.dark .cart-items-list li { border-bottom-color: #374151; }
        .cart-items-list li img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }
        .cart-menu-title h5 {
            font-size: 14px;
            margin: 0 0 5px;
            line-height: 1.4;
        }
        .cart-menu-title span {
            font-size: 13px;
            color: var(--primary-color);
            font-weight: 600;
        }
        .cancel-item {
            position: absolute;
            top: 0;
            right: 0;
            color: #ff4444;
            cursor: pointer;
        }
        /* Hide the JS generated buttons in the list */
        .cart-menu-btn { display: none !important; }

        .cart-sidebar-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            background: #f9f9f9;
        }
        body.dark .cart-sidebar-footer { background: #1f2937; border-top-color: #374151; }
        .cart-total-row {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .cart-buttons { display: flex; flex-direction: column; gap: 10px; }
        .btn-cart {
            text-align: center;
            padding: 12px;
            border-radius: 5px;
            font-weight: 600;
            transition: var(--transition);
        }
        .btn-view { background: #333; color: white; }
        .btn-view:hover { background: #000; }
        .btn-checkout { background: var(--primary-color); color: white; }
        .btn-checkout:hover { background: var(--primary-dark); }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }
        .sidebar-overlay.active { opacity: 1; visibility: visible; }

        /* Mobile Menu */
        .mobile-menu-trigger { display: none; font-size: 24px; color: white; cursor: pointer; }
        @media (max-width: 991px) {
            .mobile-menu-trigger { display: block; }
            /* #main-header.scrolled .mobile-menu-trigger { color: var(--text-dark); } */
            #main-header.scrolled .mobile-menu-trigger { color: #ffffff; }
            body.dark #main-header.scrolled .mobile-menu-trigger { color: white; }
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100%;
            background: white;
            z-index: 2000;
            transition: var(--transition);
            box-shadow: 5px 0 30px rgba(0,0,0,0.1);
        }
        body.dark .mobile-menu { background: var(--bg-dark); }
        .mobile-menu.active { left: 0; }

        .mobile-menu-header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }
        body.dark .mobile-menu-header { border-bottom-color: #374151; }
        .mobile-menu-header img { height: 40px; }
        .mobile-close { font-size: 24px; cursor: pointer; }

        .mobile-nav-list { padding: 20px; }
        .mobile-nav-list > li { border-bottom: 1px solid #f5f5f5; }
        body.dark .mobile-nav-list > li { border-bottom-color: #374151; }
        .mobile-link-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
        }
        .mobile-link-wrapper a { font-weight: 600; font-size: 15px; }
        .mobile-submenu-toggle {
            width: 30px;
            height: 30px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            cursor: pointer;
        }
        body.dark .mobile-submenu-toggle { background: #374151; }

        .mobile-submenu {
            display: none;
            padding-left: 15px;
            padding-bottom: 10px;
            background: #fafafa;
        }
        body.dark .mobile-submenu { background: #1f2937; }
        .mobile-submenu li a {
            display: block;
            padding: 8px 0;
            font-size: 14px;
            color: var(--text-light);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .top-bar { display: none; }
            #main-header { top: 0; background: rgba(255, 255, 255, 0.95); box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
            body.dark #main-header { background: rgba(17, 24, 39, 0.95); }
            .nav-menu > li > a { color: var(--text-dark); }
            body.dark .nav-menu > li > a { color: white; }
            .icon-btn { color: var(--text-dark); }
            body.dark .icon-btn { color: white; }
            .mobile-menu-trigger { color: var(--text-dark); }
            body.dark .mobile-menu-trigger { color: white; }
            .cart-sidebar { width: 100%; right: -100%; }
        }
    </style>

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Header Scroll Effect
            const header = document.getElementById('main-header');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    // Only remove scrolled class if not on mobile (where it's always solid)
                    if (window.innerWidth > 768) {
                        header.classList.remove('scrolled');
                    }
                }
            });

            // Initial check for scroll
            if (window.scrollY > 50 || window.innerWidth <= 768) {
                header.classList.add('scrolled');
            }

            // Search Overlay
            const searchOpen = document.getElementById('search-open');
            const searchClose = document.getElementById('search-close');
            const searchOverlay = document.getElementById('search-overlay');

            searchOpen.addEventListener('click', () => searchOverlay.classList.add('active'));
            searchClose.addEventListener('click', () => searchOverlay.classList.remove('active'));

            // Cart Sidebar
            const cartOpen = document.getElementById('cart-open');
            const cartClose = document.getElementById('cart-close');
            const cartSidebar = document.getElementById('cart-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function toggleCart() {
                cartSidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            }

            cartOpen.addEventListener('click', toggleCart);
            cartClose.addEventListener('click', toggleCart);
            sidebarOverlay.addEventListener('click', () => {
                cartSidebar.classList.remove('active');
                document.getElementById('mobile-menu').classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });

            // Mobile Menu
            const mobileOpen = document.getElementById('mobile-menu-open');
            const mobileClose = document.getElementById('mobile-close');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileOpen.addEventListener('click', () => {
                mobileMenu.classList.add('active');
                sidebarOverlay.classList.add('active');
            });

            mobileClose.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });

            // Mobile Accordion
            const toggles = document.querySelectorAll('.mobile-submenu-toggle');
            toggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const submenu = toggle.parentElement.nextElementSibling;
                    const icon = toggle.querySelector('i');

                    if (submenu.style.display === 'block') {
                        submenu.style.display = 'none';
                        icon.classList.remove('bx-minus');
                        icon.classList.add('bx-plus');
                    } else {
                        submenu.style.display = 'block';
                        icon.classList.remove('bx-plus');
                        icon.classList.add('bx-minus');
                    }
                });
            });

            // Dark Mode Logic
            const body = document.querySelector("body");
            const modeToggle = document.getElementById("theme-toggle");

            let getMode = localStorage.getItem("mode");
            if (getMode && getMode === "dark-mode") {
                body.classList.add("dark");
            }

            modeToggle.addEventListener("click", () => {
                body.classList.toggle("dark");
                if (!body.classList.contains("dark")) {
                    localStorage.setItem("mode", "light-mode");
                } else {
                    localStorage.setItem("mode", "dark-mode");
                }
            });

            // Load Cart Items (Integration with existing JS)
            // We call the existing function if it exists
            if (typeof cargarItemsCarritoBD === 'function') {
                // Ensure token is set if not already
                if (typeof token === 'undefined' || token === '') {
                    token = "{{ csrf_token() }}";
                    post_url = "{{ route('onlineshop_get_item_carrito') }}";
                    load_post_url(post_url, token);
                }
                cargarItemsCarritoBD();
                cargarContadorCarrito();
            }
        });
    </script>

    <style>
        /* ===== Dark Mode Overrides ===== */
        body.dark {
            background-color: #111827;
        }

        /* Containers with white background in light mode */
        body.dark .bg-white,
        body.dark .product-item,
        body.dark .card,
        body.dark .box-shadow,
        body.dark .main-view,
        body.dark .footer-logo-text,
        body.dark .footer-top,
        body.dark .featured-one,
        body.dark section[style*="padding: 120px 0px;"],
        body.dark section[style*="padding: 40px 0px;"],
        body.dark .grid-item .box-up span {
            background-color: #1f2937 !important;
            color: #ffffff;
        }

        /* Text color overrides */
        body.dark h1,
        body.dark h2,
        body.dark h3,
        body.dark h4,
        body.dark h5,
        body.dark h6,
        body.dark .section-title h1,
        body.dark .section-title h3,
        body.dark .product-title a h5,
        body.dark .product-title a h6,
        body.dark .grid-item,
        body.dark .contact-link p,
        body.dark .footer-menu ul li a,
        body.dark .grid-item b,
        body.dark .product-title b,
        body.dark .footer-title h4,
        body.dark .singl-pro-title,
        body.dark .categ-tag li,
        body.dark .categ-tag li a,
        body.dark .specific-pro ul li,
        body.dark .specific-pro ul li span,
        body.dark .pro-des-tab .tab-menu ul li a,
        body.dark .pro-des-tab .tab-menu ul li.active a {
            color: #ffffff !important;
        }

        body.dark .product-title p,
        body.dark .contenido p,
        body.dark .footer-logo-text p,
        body.dark .section-title p,
        body.dark .section-title span,
        body.dark .specific-pro ul li p,
        body.dark del {
            color: #ffffff !important;
        }

        /* Special cases and accents */
        body.dark .section-testimonio {
            background: linear-gradient(150deg, #4A0B06, #803300);
            /* Darker version of the gradient */
        }

        body.dark .footer-bottom {
            background-color: #111827;
            /* Match body background */
        }

        body.dark .footer-bottom p {
            color: #9CA3AF !important;
            /* gray-400 */
        }

        body.dark .footer-bottom p a {
            color: #ff6600 !important;
        }

        body.dark .btn-celmovil {
            background: #ff6600;
            color: #FFFFFF !important;
            border: 1px solid #ff6600;
        }

        body.dark .btn-celmovil:hover {
            background: #e65c00;
            border: 1px solid #e65c00;
        }

        body.dark .product-item,
        body.dark .card,
        body.dark .box-shadow {
            border: 1px solid #374151;
            /* gray-700 */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        body.dark .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        }

        body.dark span[style*="#ff6600"],
        body.dark b[style*="#ff6600"] {
            color: #ff6600 !important;
        }
    </style>

    <!-- Existing Scripts for Cart Logic Compatibility -->
    <script>
        // Re-declaring these variables here to ensure scope availability for inline scripts
        var ruta_carrito = "{{ route('web_carrito') }}";

        function confirmarEliminarCarrito() {
            if (confirm("¿Estás seguro de que deseas vaciar el carrito?")) {
                eliminarCarrito();
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                    } else {
                        entry.target.classList.remove("visible");
                    }
                });
            }, {
                threshold: 0.1
            });

            const elementsToAnimate = document.querySelectorAll(
                "section, .slider-container, .grid-item, .card, .map-contact");
            elementsToAnimate.forEach((el) => {
                el.classList.add("scroll-reveal");
                observer.observe(el);
            });
        });
    </script>
            {{-- -- BLoqueo por falta de pago -- --}}
            {{-- <style>
                /* El modal nace visible por defecto */
                #modal-overlay-bloqueo {
                    position: fixed !important;
                    top: 0;
                    left: 0;
                    width: 100vw;
                    height: 100vh;
                    background-color: #00000060; /* Fondo negro total para que no se vea nada atrás */
                    display: flex !important;
                    justify-content: center;
                    align-items: center;
                    z-index: 99999999;
                }

                /* Bloqueamos el scroll desde el segundo cero */
                html, body {
                    overflow: hidden !important;
                }

                .modal-bloqueo {
                    background: white;
                    padding: 40px;
                    border-radius: 15px;
                    text-align: center;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    box-shadow: 0 0 20px rgba(255,255,255,0.2);
                }
            </style>

<div id="modal-overlay-bloqueo">
    <div class="modal-bloqueo">
        <h2 style="color: #333; margin-bottom: 20px;">Comunicarse con el proveedor WEB</h2>
        <div id="countdown-bloqueo" style="font-size: 5rem; font-weight: bold; color: #d32f2f;">3</div>
    </div>
</div>

<script>
    // Ejecución inmediata
    (function() {
        var count = 3;
        var display = document.getElementById('countdown-bloqueo');
        var overlay = document.getElementById('modal-overlay-bloqueo');

        var timer = setInterval(function() {
            count--;
            display.textContent = count;

            if (count <= 0) {
                clearInterval(timer);
                // Solo aquí el modal desaparece
                overlay.style.setProperty('display', 'none', 'important');
                // Devolvemos el scroll
                document.documentElement.style.overflow = 'auto';
                document.body.style.overflow = 'auto';
            }
        }, 1000);
    })();
</script> --}}
          {{-- -- BLoqueo por falta de pago -- --}}

</div>
