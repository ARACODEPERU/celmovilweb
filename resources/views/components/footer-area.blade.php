<div>
    <!-- footer section start -->
    <footer>
        <!-- brand logo area start -->
        <!--
        <div class="brand-logo-area">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="brand-logo">
                            <ul class="clearfix">
                                <li>
                                    <a href="#"><img src="{{ asset('themes/celmovil/img/brand/1.png') }}" alt="Brand Logo" /></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('themes/celmovil/img/brand/2.png') }}" alt="Brand Logo" /></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('themes/celmovil/img/brand/3.png') }}" alt="Brand Logo" /></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('themes/celmovil/img/brand/4.png') }}" alt="Brand Logo" /></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('themes/celmovil/img/brand/5.png') }}" alt="Brand Logo" /></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
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
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <div class="s-footer-text">
                            <div class="footer-title">
                                <h4>Siguenos en :</h4>
                            </div>
                            <div class="social-link actions-btn clearfix">
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
                                </ul>
                            </div>
                            <h4>Boletin informativo</h4>
                            <form action="">
                                <div class="input-text">
                                    <input type="text" name="email" placeholder="Correp Electrónico" />
                                </div>
                                <div class="submit-text">
                                    <button class="btn btn-celmovil" type="submit" name="submit" style="padding: 12px 15px;">
                                        <b>Enviar</b>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="s-footer-text">
                            <div class="footer-title">
                                <h4>Contacto :</h4>
                            </div>
                            <div class="contact-link">
                                <ul>
                                    <li>
                                        <span>E-mail:</span>
                                        <p>ventas@celmovil.pe</p>
                                    </li>
                                    <li>
                                        <span>Teléfono:</span>
                                        <p> (+51) 921 197 459</p>
                                    </li>
                                    <li>
                                        <span>Dirección:</span>
                                        <p>777/a4 Bonosri Road, Danpura East USA. -25000</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2">
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
                                        <a href="{{ route('web_nosotros') }}">Home</a>
                                    </li>
                                    <li>
                                        <a href="#">Help</a>
                                    </li>
                                    <li>
                                        <a href="#">FAQ</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
                </div>
            </div>
        </div>
        <!-- footer top end -->
        <!-- footer bottom start -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="left floatleft">
                            <p>Copyright &copy; 2024 - Desarrollado por <a href="#">ARACODE SMART SOLUTIÓN</a></p>
                        </div>
                        <div class="right mayment-card floatright">
                            <ul>
                                <li>
                                    <a href="#"><img src="{{ asset('themes/celmovil/img/footer/v1.png') }}" alt="Payment Card" /></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('themes/celmovil/img/footer/v2.png') }}" alt="Payment Card" /></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('themes/celmovil/img/footer/v3.png') }}" alt="Payment Card" /></a>
                                </li>
                                <li>
                                    <a href="#"><img src="{{ asset('themes/celmovil/img/footer/v4.png') }}" alt="Payment Card" /></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            let form = document.getElementById('pageContactForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                var formulario = document.getElementById('pageContactForm');
                var formData = new FormData(formulario);

                // Deshabilitar el botón
                var submitButton = document.getElementById('submitPageContactButton');
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
                        var errorMessageContainer = document.getElementById('messagePageContact');
                        errorMessageContainer.innerHTML = 'Errores de validación:<br>';
                        for (var field in errorMessages) {
                            if (errorMessages.hasOwnProperty(field)) {
                                errorMessageContainer.innerHTML += field + ': ' + errorMessages[field]
                                    .join(', ') +
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
        });
    </script> --}}
        <!-- footer bottom end -->
    </footer>
</div>
