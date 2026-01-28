
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
        /* --- WhatsApp Button Moderno --- */
        #whatsapp .wtsapp{
            position: fixed;
            transition: all .3s ease;
            background-color: #25D366;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            border-radius: 50%;
            color: #fff;
            font-size: 30px;
            bottom: 80px;
            right: 20px;
            border: 0;
            z-index: 9999;
            width: 60px;
            height: 60px;
        }

        #whatsapp .wtsapp:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
        }

        #whatsapp .wtsapp:before{
            content: "";
            position: absolute;
            z-index: -1;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
            display: block;
            width: 70px;
            height: 70px;
            background-color: #25D366;
            border-radius: 50%;
            animation: pulse-border 1500ms ease-out infinite;
        }

        @keyframes pulse-border{
            0%{
                transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1);
                opacity: 0.6;
            }
            100%{
                transform: translateX(-50%) translateY(-50%) translateZ(0) scale(1.5);
                opacity: 0;
            }
        }

        /* --- INICIO: Estilos del Footer Moderno --- */
        
        .modern-footer {
            position: relative;
            /* Asegura que la imagen de fondo definida externamente se vea */
            background-size: cover;
            background-position: center;
            z-index: 1;
        }

        /* Overlay para mejorar contraste en modo claro sobre la imagen de fondo */
        .modern-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: -1;
        }

        /* Logo Area */
        .footer-logo-area {
            padding: 40px 0 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .footer-slogan {
            margin-top: 15px;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Widgets */
        .footer-widget {
            margin-bottom: 30px;
        }

        .widget-title {
            font-size: 1.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }

        .widget-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 40px;
            height: 3px;
            background-color: var(--primary-color, #ff6600);
            border-radius: 2px;
        }

        /* Contact List */
        .contact-list li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            gap: 15px;
        }

        .contact-list .icon {
            color: var(--primary-color, #ff6600);
            font-size: 1.5rem;
            margin-top: 2px;
        }

        .contact-list .text span {
            display: block;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 2px;
        }

        .contact-list a {
            color: inherit;
            transition: color 0.3s;
        }
        .contact-list a:hover {
            color: var(--primary-color, #ff6600);
        }

        /* Navigation Links */
        .footer-nav {
            padding-left: 0;
            list-style: none;
        }

        .footer-nav li {
            display: block;
            margin-bottom: 12px;
            width: 100%;
        }

        .footer-nav li a {
            position: relative;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-nav li a:hover {
            color: var(--primary-color, #ff6600);
            transform: translateX(5px);
        }

        /* Social Buttons */
        .social-links {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: inherit;
            font-size: 1.5rem;
        }

        .social-btn:hover {
            background: var(--primary-color, #ff6600);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.3);
        }

        .social-btn img {
            width: 18px;
            height: 18px;
            object-fit: contain;
        }

        /* Footer Bottom */
        .footer-bottom {
            padding: 20px 0;
            border-top: 1px solid rgba(0,0,0,0.1);
            font-size: 0.9rem;
        }

        .footer-bottom p {
            color: #ffffff !important;
        }

        /* =========================================
           MODO CLARO (Light Mode)
           ========================================= */
        /* Mantiene fondo transparente para ver la imagen de fondo */
        .modern-footer, .footer-logo-area, .footer-top {
            background-color: transparent; 
            color: #1f2937; /* Texto oscuro */
        }

        /* =========================================
           MODO OSCURO (Dark Mode)
           ========================================= */
        body.dark .modern-footer {
            color: #ffffff; /* Texto blanco */
            background: linear-gradient(to top, #000000, #111827) !important;
        }

        body.dark .modern-footer::before {
            display: none;
        }

        body.dark .footer-logo-area {
            border-bottom-color: #374151;
        }

        body.dark .footer-logo-area, 
        body.dark .footer-top,
        body.dark .footer-slogan,
        body.dark .contact-list .text span,
        body.dark .contact-list .text p,
        body.dark .contact-list a,
        body.dark .footer-nav li a {
            color: #ffffff; /* Texto blanco */
            background: none !important;
        }

        body.dark .widget-title {
            color: var(--primary-color, #ff6600); /* Títulos naranja */
        }

        body.dark .social-btn {
            background: #374151;
            color: #ffffff;
        }

        body.dark .social-btn:hover {
            background: var(--primary-color, #ff6600);
        }

        body.dark .social-btn img {
            filter: brightness(0) invert(1); /* Vuelve blanco el icono negro */
        }

        body.dark .footer-bottom {
            background-color: #000000 !important;
            border-top-color: #374151;
            color: #ffffff;
        }

        /* Ensure links hover color remains orange in dark mode */
        body.dark .footer-nav li a:hover,
        body.dark .contact-list a:hover {
            color: var(--primary-color, #ff6600);
        }
    </style>

    <!-- footer section start -->
    <footer class="modern-footer">
        <!-- Main Footer Content -->
        <div class="footer-top section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('web_inicio') }}">
                            <img style="width: 350px; max-width: 100%;" src="{{ $logo[0]->content }}" alt="Logo Celmovil" loading="lazy" />
                        </a>
                    </div>
                </div>
                <br>
                <div class="row">
                    <!-- Contacto -->
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="footer-widget">
                            <h4 class="widget-title">Contacto</h4>
                            <ul class="contact-list">
                                <li>
                                    <div class="icon"><i class="fa fa-envelope"></i></div>
                                    <div class="text">
                                        <span>E-mail:</span>
                                        <a href="mailto:ventas@celmovil.pe">ventas@celmovil.pe</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon"><i class="fa fa-phone"></i></div>
                                    <div class="text">
                                        <span>Teléfono:</span>
                                        <a href="tel:+51921197459">(+51) 921 197 459</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon"><i class="fa fa-clock-o"></i></div>
                                    <div class="text">
                                        <span>Horario:</span>
                                        <p>Lunes a Sábado: 9:30 a.m. - 7:00 p.m.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Navegación -->
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="footer-widget">
                            <h4 class="widget-title">Navegación</h4>
                            <ul class="footer-nav">
                                <li><a href="{{ route('web_inicio') }}">Inicio</a></li>
                                <li><a href="{{ route('web_nosotros') }}">Nosotros</a></li>
                                <li><a href="{{ route('web_politicas_de_privacidad') }}">Políticas de Privacidad</a></li>
                                <li><a href="{{ route('web_preguntas_frecuentes') }}">Preguntas Frecuentes</a></li>
                                <li><a href="{{ route('web_claims') }}">Libro de Reclamaciones</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Redes Sociales -->
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="footer-widget">
                            <h4 class="widget-title">Síguenos</h4>
                            <div class="social-links">
                                <a href="{{ $redesSociales[1]->content }}" target="_blank" class="social-btn facebook" title="Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                                <a href="{{ $redesSociales[3]->content }}" target="_blank" class="social-btn instagram" title="Instagram">
                                    <i class="fa fa-instagram"></i>
                                </a>
                                <a href="{{ $redesSociales[5]->content }}" target="_blank" class="social-btn youtube" title="YouTube">
                                    <i class="fa fa-youtube"></i>
                                </a>
                                <a href="{{ $redesSociales[7]->content }}" target="_blank" class="social-btn tiktok" title="TikTok">
                                    <img src="{{ $redesSociales[6]->content }}" alt="TikTok">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center" style="margin: 0;">
                            Copyright &copy; 2025 - Desarrollado por <a href="https://www.aracodeperu.com/" style="color: var(--primary-color, #ff6600); font-weight: 600;">ARACODE SMART SOLUTIONS</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </footer>
</div>
