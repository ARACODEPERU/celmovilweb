<div>
    <section class="contact-section">
        <div class="pd_top_90"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 mb-5 mb-lg-5 mb-xl-0">
                    <div class="contact_form_box_all type_one">
                        <div class="contact_form_box_inner">
                            <div class="contact_form_shortcode">
                                <form id="pageContactForm" method="post" action="{{ route('apisubscriber') }}"
                                    role="form">
                                    <div class="messages"></div>
                                    @csrf
                                    <div class="controls">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label> Nombre Completo<br /></label>
                                                    <input id="full_name" type="text" name="full_name"
                                                        placeholder="Nombre Completo *" required="required"
                                                        data-error="Nombre Completo" />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label> Teléfono<br /></label>
                                                    <input type="text" id="phone" name="phone"
                                                        placeholder="Teléfono *" required="required"
                                                        data-error="Teléfono" />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label> E-mail<br /></label>
                                                    <input type="text" id="email" name="email"
                                                        required="required" placeholder="E-mail *"
                                                        data-error="Enter E-mail Id" />
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label> Tu Mensaje<br /></label>
                                                    <textarea id="message" name="message" placeholder="Tu Mensaje" rows="3" required="required"
                                                        data-error="Tu Mensaje"></textarea>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <p id="messagePageContact"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group mg_top apbtn">
                                                    <button id="submitPageContactButton" class="theme_btn"
                                                        type="submit">
                                                        Enviar Ahora
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--
            <div class="col-xl-6 col-lg-6 pd_left_30">
              <div class="title_all_box style_one dark_color">
                <div class="title_sections left">
                  <div class="before_title">Contacta con</div>
                  <h2>nuestro equipo de expertos</h2>
                  <p>
                    Envíe un mensaje a través del formulario dado. Si su consulta es
                    urgente, utilice los datos de contacto a continuación.
                  </p>
                </div>
              </div>
    
              <div class="contact_box_content style_one">
                <div class="contact_box_inner icon_yes">
                  <div class="icon_bx">
                    <span class="icon-placeholder"></span>
                  </div>
                  <div class="contnet">
                    <h3>Dirección</h3>
                    <p>Providencia 1208 Of. 1603 - Santiago.</p>
                  </div>
                </div>
              </div>
              <div class="pd_bottom_15"></div>
              <div class="contact_box_content style_one">
                <div class="contact_box_inner icon_yes">
                  <div class="icon_bx">
                    <span class="icon-phone-call"></span>
                  </div>
                  <div class="contnet">
                    <h3>Consultas generales</h3>
                    <p>Teléfono: +98 060 712 34 &amp; E-mail: contacto@kentha.cl</p>
                  </div>
                </div>
              </div>
              <div class="pd_bottom_15"></div>
              <div class="contact_box_content style_one">
                <div class="contact_box_inner icon_yes">
                  <div class="icon_bx">
                    <span class="fa fa-clock-o"></span>
                  </div>
                  <div class="contnet">
                    <h3>Horario de atennción</h3>
                    <p>Lun - Sab: 09.00 am a 06.00 pm (Domingos: Closed)</p>
                  </div>
                </div>
              </div>
              <div class="pd_bottom_40"></div>
              <div class="social_media_v_one style_two">
                <ul>
                  <li>
                    <a href="#">
                      <span class="fa fa-facebook"></span>
                      <small>facebook</small>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <span class="fa fa-twitter"></span>
                      <small>twitter</small>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <span class="fa fa-skype"></span>
                      <small>skype</small>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <span class="fa fa-instagram"></span>
                      <small>instagram</small>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            -->
                <div class="col-xl-6 col-lg-6 pd_left_30">
                    <div class="title_all_box style_one dark_color">
                        <div class="title_sections left">
                            <div class="before_title">{{ $data[0]->item->content }}</div>
                            <h2>{{ $data[1]->item->content }}</h2>
                            <p>
                                {{ $data[2]->item->content }}
                            </p>
                        </div>
                    </div>

                    <div class="contact_box_content style_one">
                        <div class="contact_box_inner icon_yes">
                            <div class="icon_bx">
                                <span class="icon-placeholder"></span>
                            </div>
                            <div class="contnet">
                                <h3>Dirección</h3>
                                <p>{{ $data[3]->item->content }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pd_bottom_15"></div>
                    <div class="contact_box_content style_one">
                        <div class="contact_box_inner icon_yes">
                            <div class="icon_bx">
                                <span class="icon-phone-call"></span>
                            </div>
                            <div class="contnet">
                                <h3>Consultas generales</h3>
                                <p>Teléfono: {{ $data[4]->item->content }} <br>
                                    E-mail: {{ $data[5]->item->content }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pd_bottom_15"></div>
                    <div class="contact_box_content style_one">
                        <div class="contact_box_inner icon_yes">
                            <div class="icon_bx">
                                <span class="fa fa-clock-o"></span>
                            </div>
                            <div class="contnet">
                                <h3>Horario de atennción</h3>
                                <p>{{ $data[6]->item->content }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pd_bottom_40"></div>
                    <div class="social_media_v_one style_two">
                        <ul>
                            <li>
                                <a href="{{ $data[7]->item->content }}">
                                    <span class="fa fa-facebook"></span>
                                    <small>facebook</small>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $data[8]->item->content }}">
                                    <span class="fa fa-instagram"></span>
                                    <small>instagram</small>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $data[9]->item->content }}">
                                    <span class="fa fa-twitter"></span>
                                    <small>twitter</small>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $data[10]->item->content }}">
                                    <span class="fa fa-linkedin"></span>
                                    <small>Linkedin</small>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $data[11]->item->content }}">
                                    <span class="fa fa-youtube-play"></span>
                                    <small>Youtube</small>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="pd_top_70"></div>
    </section>
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
</div>
