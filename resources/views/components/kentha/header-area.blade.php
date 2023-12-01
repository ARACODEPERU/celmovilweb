@if (isset($data))
    <div class="header_area" id="header_contents">
        <header class="main-header header header_v13">
            <section class="header_top">
                <div class="medium-container">
                    <div class="header_top_inner">
                        <div class="top_left">
                            <ul class="top-links clearfix">
                                <li>
                                    <a href="{{ route('login') }}" target="_blank" class="get_a_quote"> <i
                                            class="fa fa-sign-in" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href="https://kentha.cl/public/" target="_blank" class="get_a_quote"> Kentha
                                        Marketing </a>
                                </li>

                                <li></li>
                                <li>Bienvenidos a Kentha servicios HVAC</li>
                            </ul>
                        </div>
                        <div class="top_right text-right">
                            <ul class="contact_info_two">
                                <li class="single">
                                    <p>
                                        <span class="icon-telephone"></span>
                                        <a href="tel:{{ $data[4]->item->content }}">
                                            {{ $data[4]->item->content }}
                                        </a>
                                    </p>
                                </li>
                                <li class="single">
                                    <p>
                                        <span class="icon-mail"></span>
                                        <a href="mailto:{{ $data[5]->item->content }}">{{ $data[5]->item->content }}</a>
                                    </p>
                                </li>
                                <li class="single">
                                    <p>
                                        <span class="icon-location2"></span>
                                        {{ $data[3]->item->content }}
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section class="navbar_outer get_sticky_header">
                <div class="medium-container">
                    <nav class="inner_box">
                        <div class="header_logo_box">
                            <a href="{{ route('cms_principal') }}" class="logo navbar-brand">
                                <img src="{{ asset('themes/kentha/assets/images/HVAC_logo.png') }}" alt="Creote"
                                    class="logo_default">
                                <img src="{{ asset('themes/kentha/assets/images/HVAC_logo.png') }}" alt="Creote"
                                    class="logo__sticky">
                            </a>
                        </div>
                        <div class="navbar_togglers hamburger_menu">
                            <span class="line"></span>
                            <span class="line"></span>
                            <span class="line"></span>
                        </div>
                        <div class="header_content header_content_collapse">
                            <div class="header_menu_box">
                                <div class="navigation_menu">
                                    <ul id="myNavbar" class="navbar_nav">
                                        <li class="active menu-item menu-item-has-children dropdown nav-item">
                                            <a href="{{ route('cms_principal') }}" class="dropdown-toggle nav-link">
                                                <span>Home</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-has-children dropdown nav-item">
                                            <a href="{{ route('web_nosotros') }}" class="dropdown-toggle nav-link">
                                                <span>Nosotros</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-has-children dropdown nav-item">
                                            <a href="{{ route('web_servicios') }}" class="dropdown-toggle nav-link">
                                                <span>Servicios</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-has-children dropdown nav-item">
                                            <a href="{{ route('web_proyectos') }}" class="dropdown-toggle nav-link">
                                                <span>Proyectos</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-has-children dropdown nav-item">
                                            <a href="{{ route('blog_principal') }}" class="dropdown-toggle nav-link">
                                                <span>Blog</span>
                                            </a>
                                        </li>
                                        <li class="menu-item menu-item-has-children dropdown nav-item">
                                            <a href="{{ route('web_contacto') }}" class="dropdown-toggle nav-link">
                                                <span>Contacto</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <ul class="navbar_right navbar_nav">
                                <li>
                                    <button type="button" class="contact-toggler">
                                        <i class="icon-menu1"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>

                    </nav>


                </div>

            </section>
        </header>
        <!-- end of the loop -->
    </div>
@endif
