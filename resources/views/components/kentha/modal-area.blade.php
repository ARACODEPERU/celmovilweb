<div>
    <div class="crt_mobile_menu">
        <div class="menu-backdrop"></div>
        <nav class="menu-box">
            <div class="close-btn"><i class="icon-close"></i></div>
            <form role="search" method="get" action="#">
                <input type="search" class="search" placeholder="Search..." value="" name="s"
                    title="Search" />
                <button type="submit" class="sch_btn"> <i class="icon-search"></i></button>
            </form>
            <div class="menu-outer">
                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
            </div>
        </nav>
    </div>
    <!---==============mobile menu end =================-->
    <!---==============search popup =================-->
    <div id="search-popup" class="search-popup">
        <div class="close-search"><i class="fa fa-times"></i></div>
        <div class="popup-inner">
            <div class="overlay-layer"></div>
            <div class="search-form">
                <fieldset>
                    <form role="search" method="get" action="#">
                        <input type="search" class="search" placeholder="Search..." value="" name="s"
                            title="Search" />
                        <button type="submit" class="sch_btn"> <i class="icon-search"></i></button>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
    <!---==============search popup end =================-->
    <!---==============modal popup =================-->
    <style>
        .sweet-modal-zindex {
            z-index: 100000 !important;
            /* Asegúrate de que el z-index sea mayor que el de los modales */
        }
    </style>
    <div class="modal_popup one">
        <div class="modal-popup-inner">
            <div class="close-modal"><i class="fa fa-times"></i></div>
            <div class="modal_box">
                <div class="row">
                    <div class="col-lg-5 col-md-12 form_inner">
                        <div class="form_content">
                            <form class="contact-form" id="contactForm" method="post">
                                @csrf
                                <p>
                                    <label> Nombre Completo<br />
                                        <input type="text" id="full_name" name="full_name" value=""
                                            size="40" aria-required="true" aria-invalid="false"
                                            placeholder="Nombre Completo" />
                                        <br />
                                        <i class="fa fa-user"></i><br />
                                    </label>
                                </p>
                                <p>
                                    <label> Teléfono<br />
                                        <input type="text" id="phone" name="phone" value=""
                                            size="40" aria-required="true" aria-invalid="false"
                                            placeholder="Teléfono" />
                                        <br />
                                        <i class="fa fa-folder"></i><br />
                                    </label>
                                </p>
                                <p><label> E-mail<br />
                                        <input type="email" id="email" name="email" value=""
                                            size="40" aria-required="true" aria-invalid="false"
                                            placeholder="E-mail" />
                                        <br />
                                        <i class="fa fa-envelope"></i><br />
                                    </label>
                                </p>
                                <p>
                                    <label> Tu Mensaje)<br />
                                        <textarea id="message" name="message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea"
                                            aria-invalid="false" placeholder="Tu Mensaje"></textarea>
                                        <br />
                                        <i class="fa fa-comments"></i><br />
                                    </label>
                                </p>
                                <p id="messageContact"></p>
                                <p><input id="submitContactButton" type="submit" value="Submit" /></p>

                            </form>

                        </div>
                    </div>
                    <div class="col-lg-7 col-md-12 about_company_inner">
                        <div class="abt_content">
                            <div class="logo">
                                <img src="{{ asset('themes/kentha/assets/images/HVAC_logo.png') }}" alt="img"
                                    class="Logo_Kentha">
                            </div>
                            <div class="text">
                                <p> {{ $data[6]->item->content }}
                                </p>
                                <a href="nosotros">Sobre Nosotros</a>
                            </div>


                            <div class="social_media_v_one style_two">
                                <ul>
                                    <li>
                                        <a href="{{ $redes_sociales[7]->item->content }}">
                                            <span class="fa fa-facebook"></span>
                                            <small>facebook</small>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $redes_sociales[8]->item->content }}">
                                            <span class="fa fa-instagram"></span>
                                            <small>instagram</small>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $redes_sociales[9]->item->content }}">
                                            <span class="fa fa-twitter"></span>
                                            <small>twitter</small>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $redes_sociales[10]->item->content }}">
                                            <span class="fa fa-linkedin"></span>
                                            <small>Linkedin</small>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $redes_sociales[11]->item->content }}">
                                            <span class="fa fa-youtube-play"></span>
                                            <small>Youtube</small>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="pd_bottom_40"></div>
                            <div class="copright">
                                © 2023 Aracode Perú. Todos los derechos reservados.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let form = document.getElementById('contactForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            var formulario = document.getElementById('contactForm');
            var formData = new FormData(formulario);

            // Deshabilitar el botón
            var submitButton = document.getElementById('submitContactButton');
            submitButton.disabled = true;
            submitButton.style.opacity = 0.25;

            // Crear una nueva solicitud XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configurar la solicitud POST al servidor
            xhr.open('POST', "{{ route('apisubscriber') }}", true);

            // Configurar la función de callback para manejar la respuesta
            xhr.onload = function() {
                // Habilitar nuevamente el botón
                submitButton.disabled = false;
                submitButton.style.opacity = 1;
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: 'success',
                        title: 'Enhorabuena',
                        text: response.message,
                        customClass: {
                            container: 'sweet-modal-zindex' // Clase personalizada para controlar el z-index
                        }
                    });
                    formulario.reset();
                } else if (xhr.status === 422) {
                    var errorResponse = JSON.parse(xhr.responseText);
                    // Maneja los errores de validación aquí, por ejemplo, mostrando los mensajes de error en algún lugar de tu página.
                    var errorMessages = errorResponse.errors;
                    var errorMessageContainer = document.getElementById('messageContact');
                    errorMessageContainer.innerHTML = 'Errores de validación:<br>';
                    for (var field in errorMessages) {
                        if (errorMessages.hasOwnProperty(field)) {
                            errorMessageContainer.innerHTML += field + ': ' + errorMessages[field].join(', ') +
                                '<br>';
                        }
                    }
                } else {
                    console.error('Error en la solicitud: ' + xhr.status);
                }


            };

            // Enviar la solicitud al servidor
            xhr.send(formData);
        });
    </script>

    <!---==============modal popup end=================-->
    <!---==============cart=================-->
    <div class="side_bar_cart" id="mini_cart">
        <div class="cart_overlay"></div>
        <div class="cart_right_conten">
            <div class="close">
                <div class="close_btn_mini"><i class="icon-close"></i></div>
            </div>
            <div class="cart_content_box">
                <div class="contnet_cart_box">
                    <div class="widget_shopping_cart_content">
                        <p class="woocommerce-mini-cart__empty-message">No products in the cart.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---==============cart=================-->

    <!-- Back to top with progress indicator-->
    <div class="prgoress_indicator">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
</div>
