<!---newsteller--->
<section class="newsteller style_one bg_dark_1">
    <!--===============spacing==============-->
    <div class="pd_top_40"></div>
    <!--===============spacing==============-->
    <div class="auto-container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="content">
                    <h2>Únete a nuestra lista de correos</h2>
                    <p>
                        Para recibir nuestras noticias y actualizaciones en su bandeja de
                        entrada directamente.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="item_scubscribe">
                    <div class="input_group">
                        <form id="subscriberForm" action="{{ route('apisubscriber') }}" class="mc4wp-form"
                            method="post">
                            @csrf
                            <div class="mc4wp-form-fields">
                                <input id="email" type="email" name="email" placeholder="Ingresa tu E-mail" />
                                <input id="submitButton" type="submit" value="Suscribirse" />
                            </div>
                            <span id="message" class="text-white"></span>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===============spacing==============-->
    <div class="pd_bottom_40"></div>
    <!--===============spacing==============-->
    <script>
        let form = document.getElementById('subscriberForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            var formulario = document.getElementById('subscriberForm');
            var formData = new FormData(formulario);

            // Deshabilitar el botón
            var submitButton = document.getElementById('submitButton');
            submitButton.disabled = true;
            submitButton.style.opacity = 0.25;

            // Crear una nueva solicitud XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configurar la solicitud POST al servidor
            xhr.open('POST', form.action, true);

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
                        text: response.message
                    });
                    document.getElementById('email').value = null;
                } else if (xhr.status === 422) {
                    var errorResponse = JSON.parse(xhr.responseText);
                    // Maneja los errores de validación aquí, por ejemplo, mostrando los mensajes de error en algún lugar de tu página.
                    var errorMessages = errorResponse.errors;
                    var errorMessageContainer = document.getElementById('message');
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

</section>
<!---newsteller end--->
