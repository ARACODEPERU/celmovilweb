@extends('layouts.capperu')

@section('content')

    <!-- preloader area start -->
    <x-capperu.preloader-area></x-capperu.preloader-area>
    <!-- preloader area end -->
    
    <x-capperu.body-overlay-area></x-capperu.body-overlay-area>

    <!-- search popup area start -->
    <x-capperu.search-popup-area></x-capperu.search-popup-area>
    <!-- //. search Popup -->
    
    <!-- Encabezado inicio -->
    <x-capperu.header-area></x-capperu.header-area>
    <!-- Encabezado fin -->

    
    <!-- Banner Area Start-->
    <section class="banner-area style-3" style="padding: 40px; background-image: url({{ asset('themes/capperu/assets/img/banner/bg-2.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 align-self-center">
                    <div class="banner-inner text-center">
                        <h1>Contacto</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- zoom courses Area Start-->
    <section class="zoom-courses-area pd-top-100 pd-bottom-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="contact-inner">
                        <form id="pageContactForm" class="contact-form" method="post" action="{{ route('apisubscriber') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 single-input-wrap">
                                    <input type="text" placeholder="Nombres completos" name="full_name">
                                </div>
                                <div class="col-md-5 single-input-wrap">
                                    <input type="text" placeholder="Teléfono" name="phone">
                                </div>
                                <div class="col-md-7 single-input-wrap">
                                    <input type="email" placeholder="E-mail" name="email">
                                </div>
                                <div class="col-md-12 single-input-wrap">
                                    <textarea rows="5" placeholder="Escribe tu mensaje" name="message"></textarea>
                                </div>    
                            </div>                                
                            <button id="submitPageContactButton" type="submit" class="btn btn-base w-100">Enviar Ahora</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-inner">
                        <div class="row">
                            <div class="col-md-2" style="font-size: 30px;">
                                <i class="fa fa-home"></i>
                            </div>
                            <div class="col-md-10">
                                <p><b>Sede Lima:</b> Av. 2 de mayo 516 Of.201 - Miraflores</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="font-size: 30px;">
                                <i class="fa fa-home"></i>
                            </div>
                            <div class="col-md-10">
                                <p><b>Sede Chimbote:</b> Av. Francisco Bolognesi 549. Of. 119</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="font-size: 30px;">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="col-md-10">
                                <p>
                                    <b>Teléfono:</b>
                                    <br>(01) 7397026
                                    <br>(043) 200324
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="font-size: 30px;">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="col-md-10">
                                <p>
                                    <b>E-mail:</b>
                                    <br>capperuacademica@gmail.com
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- zoom courses Area End -->
    <script>
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
    
    <!-- Más Populares Area Start-->
    <x-capperu.programas-populares-area></x-capperu.programas-populares-area>
    <!-- Más Populares Area End -->



    <x-capperu.footer-area></x-capperu.footer-area>

@endsection