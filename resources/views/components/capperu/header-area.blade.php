<div>
    <header class="navbar-area">
        <nav class="navbar navbar-expand-lg">
            <div class="container nav-container">
                <div class="responsive-mobile-menu">
                    <button class="menu toggle-btn d-block d-lg-none" data-target="#themefie_main_menu"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-left"></span>
                        <span class="icon-right"></span>
                    </button>
                </div>
                <div class="logo">
                    <a class="main-logo" href="">
                        <img style="width:196px; height:61px;"
                            src="{{ asset('themes/capperu/assets/img/logo-cap.png') }}" alt="img">
                    </a>
                </div>
                <div class="nav-right-part nav-right-part-mobile">
                    <ul>
                        <li>
                            <a href="" class="btn btn-primary" title="Campus Virtual">
                                <i class="fa fa-university"></i> Campus
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('web_carrito') }}" class="btn btn-base"><i
                                    class="fa fa-cart-plus"></i>&nbsp;&nbsp;
                                <b>
                                    <span id="contadorCarritoMovil" class="contador" style="font-size: 18px;"></span>
                                </b>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="themefie_main_menu">
                    <!--
                    <div class="single-input-wrap">
                        <input type="text" placeholder="buscar programa">
                        <button><i class="fa fa-search"></i></button>
                    </div>
                    -->

                    <ul class="navbar-nav menu-open text-end">
                        <li>
                            <a href="{{ route('cms_principal') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('web_nosotros') }}">Nosotros</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Programa de Estudios</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="{{ route('web_categoria_sector', "Empresarial") }}">Sector: <b>Empresarial</b></a>
                                </li>
                                <li>
                                    <a href="{{ route('web_categoria_sector', "Derecho") }}">Sector: <b>Derecho</b></a>
                                </li>
                                <li>
                                    <a href="{{ route('web_categoria_sector', "Publico") }}">Sector: <b>Público</b></a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li>
                            <a href="{{ route('web_categorias') }}">Categorias</a>
                        </li> --}}
                        <li>
                            <a href="{{ route('web_convenios') }}">Convenios</a>
                        </li>
                        <!--
                        <li>
                            <a href="">Blog</a>
                        </li>
                        --->
                        <li>
                            <a href="{{ route('web_contacto') }}">Contacto</a>
                        </li>
                        <li></li>
                    </ul>
                </div>
                <div class="nav-right-part nav-right-part-desktop">
                    <ul>
                        <li>
                            <a href="{{ route('web_carrito') }}" class="btn btn-base">
                                <i class="fa fa-cart-plus "></i>&nbsp;&nbsp;
                                <b>
                                    <span id="contadorCarritoWeb" class="contador" style="font-size: 18px;"></span>
                                </b>
                            </a>
                        </li>
                        <li>
                            <a href="{{ env('URL_CAMPUS') }}" class="btn btn-primary">
                                Campus Virtual
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="category-navbar navbar-area d-xl-block d-none ara-header-bottom-cap" 
                style="border-bottom: 4px solid orange;">
        <nav class="navbar navbar-expand-lg">
            <div class="container nav-container">
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav menu-open" style="text-align:center;">
                        <li>
                            <a href="" style="text-transform: none; color: #fff;">
                                <i class="fa fa-envelope" aria-hidden="true" style="color: orange;"></i>
                                capperuacademica@gmail.com
                            </a>
                        </li>
                        <li>
                            <a href="" style="text-transform: none; color: #fff;">
                                <i class="fa fa-phone" aria-hidden="true" style="color: orange;"></i>
                                (01)7397026 – (043) 200324 - 977 66 24 60 - 946 94 38 87
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <style>
        .contador {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: rgba(98, 0, 255, 0.253);
            color: white;
            border-radius: 66%;
            padding: 2px 19px;
            font-size: 12px;
        }
    </style>

</div>
