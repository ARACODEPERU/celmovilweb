<div>
    
    
    <div id="whatsapp">
        <a href="https://api.whatsapp.com/send?phone=51{{ $redesSociales[9]->content }}&text=Hola&nbsp;CelMovil!&nbsp;me&nbsp;pueden&nbsp;ayudar?" 
            target="_blanck" 
            class="wtsapp" 
            data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa fa-whatsapp"></i>
        </a>
    </div>

    <style type="text/css">
        #whatsapp .wtsapp{
            position: fixed;
            transform: all .5s ease;
            background-color: #25D366;
            display: block;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            border-radius: 50px;
            border-right: none;
            color: #fff;
            font-weight: 700;
            font-size: 30px;
            bottom: 40px;
            right: 20px;
            border: 0;
            z-index: 9999;
            width: 50px;
            height: 50px;
            line-height: 50px;
        }

        #whatsapp .wtsapp:before{
            content: "";
            position: absolute;
            z-index: -1;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
            display: block;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            border-radius: 50%;
            -webkit-animation: pulse-border 1500ms ease-out infinite;
            animation: pulse-border 1500ms ease-out infinite;
        }

        #whatsapp .wtsapp:focus{
            border: none;
            outline: none;
        }

        @keyframes pulse-border{
            0%{
                transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1);
                opacity: 1;
            }
            100%{
                transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1.5);
                opacity: 0;
            }
        }

        /* --- INICIO: Estilos del Footer Moderno --- */

        /* Modo Claro (Por defecto) - Mantiene imagen de fondo original */
        .footer-logo-text, .footer-top {
            /* background-color: #1f2937; Eliminado para mostrar imagen de fondo */
            position: relative;
            color: #000000; /* Texto negro para modo claro */
        }
        
        .footer-bottom {
            background-color: #111827; /* gray-900 */
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .footer-title h4 {
            color: #000000;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .footer-logo-text p, .contact-link p, .footer-menu ul li a {
            color: #000000;
        }
        
        .footer-menu ul li a:hover {
            color: #ff6600;
            padding-left: 5px;
            transition: all 0.3s ease;
        }
        
        .footer-bottom p {
            color: #9CA3AF; /* gray-400 */
        }
        
        .footer-bottom p a {
            color: #ff6600;
        }

        /* Modo Noche (Dark Mode) - Reemplaza imagen con degradado moderno */
        body.dark .footer-logo-text, 
        body.dark .footer-top {
            background-image: none !important; /* Elimina imagen de fondo */
            background-color: transparent !important;
            background: linear-gradient(145deg, var(--surface-color) 0%, var(--body-color) 100%) !important; /* Degradado con colores del tema */
            position: relative;
        }
        
        /* Efecto de brillo sutil en modo noche */
        body.dark .footer-top::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 60%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(255, 102, 0, 0.08), transparent 50%);
            pointer-events: none;
        }

        body.dark .footer-bottom {
            background-color: var(--body-color) !important; /* Coincide con el fondo del body */
            border-top: 1px solid var(--surface-color);
        }

        body.dark .footer-title h4 {
            color: #f3f4f6 !important; /* gray-100 */
        }

        body.dark .footer-logo-text p, 
        body.dark .contact-link p, 
        body.dark .footer-menu ul li a {
            color: #9ca3af !important; /* gray-400 */
        }

        body.dark .footer-menu ul li a:hover {
            color: #ff6600 !important;
        }
        /* --- FIN: Estilos del Footer --- */

    </style>



    <!-- footer section start -->
    <footer>
        <!-- brand logo area end -->
        <div class="footer-logo-text">
            <div class="container text-center">
                <a href="{{ route('web_inicio') }}"><img style="width: 250px;" src="{{ $logo[0]->content }}" alt="Logo" /></a>
                <p>{{ $logo[1]->content }}</p>
            </div>
        </div>
        <!-- footer top start -->
        <div class="footer-top section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="s-footer-text">
                            <div class="footer-title">
                                <h4>Contacto :</h4>
                            </div>
                            <div class="contact-link">
                                <ul>
                                    <li>
                                        <span style="color: #ff6600;"><b>E-mail:</b></span>
                                        <p>ventas@celmovil.pe</p>
                                    </li>
                                    <li>
                                        <span style="color: #ff6600;"><b>Teléfono:</b></span>
                                        <p> (+51) 921 197 459</p>
                                    </li>
                                    <li>
                                        <span style="color: #ff6600;"><b>Horario:</b></span>
                                        <p>Lunes a Sabado: 9:30 a.m. - 7:00 p.m.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-3">
                        <div class="s-footer-text">
                            <div class="footer-title">
                                <h4>NAVEGAR :</h4>
                            </div>
                            <div class="footer-menu">
                                <ul>
                                    <li>
                                        <a href="{{ route('web_inicio') }}">Inicio</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('web_nosotros') }}">Nosotros</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('web_politicas_de_privacidad') }}">Politicas de Privacidad</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('web_preguntas_frecuentes') }}">Preguntas Frecuentes</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('web_claims') }}">Libro de Reclamaciones</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="s-footer-text">
                            <div class="footer-title">
                                <h4>Siguenos en :</h4>
                            </div>
                            <div class="social-link actions-btn clearfix">
                                <ul>
                                    <li style="padding: 8px;">
                                        <a  target="_blanck" href="{{ $redesSociales[1]->content }}">
                                            <img src="{{ $redesSociales[0]->content }}" alt="Facebook">
                                        </a>
                                    </li>
                                    <li style="padding: 8px;">
                                        <a target="_blanck" href="{{ $redesSociales[3]->content }}">
                                            <img src="{{ $redesSociales[2]->content }}" alt="Instagram">
                                        </a>
                                    </li>
                                    <li style="padding: 8px;">
                                        <a target="_blanck" href="{{ $redesSociales[5]->content }}">
                                            <img src="{{ $redesSociales[4]->content }}" alt="Youtube">
                                        </a>
                                    </li>
                                    <li style="padding: 8px;">
                                        <a target="_blanck" href="{{ $redesSociales[7]->content }}">
                                            <img src="{{ $redesSociales[6]->content }}" alt="Tiktok">
                                        </a>
                                    </li>
                                </ul>
                                <!--
                                <ul>
                                    <li>
                                        <a href="https://www.facebook.com/Motoselectricastrujillo" target="_blank"><i class="fa fa-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/celmovil_2/" target="_blank"><i class="fa fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://www.tiktok.com/@celmovil_motos?lang=es" target="_blank"><i class="fa fa-tiktok"></i></a>
                                    </li>
                                    <li>
                                        <a href="https://www.youtube.com/channel/UClkH7YMr5QhaCkx-VqB375w" target="_blank"><i class="fa fa-youtube"></i></a>
                                    </li>
                                </ul>-->
                            </div>
                            {{-- <h4>Boletin informativo</h4>
                            <form action="">
                                <div class="input-text">
                                    <input type="text" name="email" placeholder="Correp Electrónico" />
                                </div>
                                <div class="submit-text">
                                    <button class="btn btn-celmovil" type="submit" name="submit" style="padding: 12px 15px;">
                                        <b>Enviar</b>
                                    </button>
                                </div>
                            </form> --}}
                        </div>
                    </div>
                    <!--
                    <div class="col-xs-12 col-sm-2 col-md-3">
                        <div class="s-footer-text">
                            <div class="footer-title">
                                <h4>My Account</h4>
                            </div>
                            <div class="footer-menu">
                                <ul>
                                    <li>
                                        <a href="#">My Orer</a>
                                    </li>
                                    <li>
                                        <a href="cart.html">My Cart</a>
                                    </li>
                                    <li>
                                        <a href="wishlist.html">Wishlist</a>
                                    </li>
                                    <li>
                                        <a href="login.html">Login</a>
                                    </li>
                                    <li>
                                        <a href="login">Register</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
        <!-- footer top end -->
        <!-- footer bottom start -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center" style="padding: 15px 0px;">Copyright &copy; 2025 - Desarrollado por
                            <a href="#">ARACODE SMART SOLUTIONS</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- footer bottom end -->
    </footer>
</div>
