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
    <section class="banner-area style-3"
        style="padding: 40px; background-image: url({{ asset('themes/capperu/assets/img/banner/bg-2.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 align-self-center">
                    <div class="banner-inner text-center">
                        <h1>Carrito de Compras</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->
    {{-- codigo de recapcha --}}
    <script type="text/javascript">
        function callbackThen(response) {

            // read HTTP status

            console.log(response.status);

            // read Promise object

            response.json().then(function(data) {

                console.log(data);

            });

        }

        function callbackCatch(error) {

            console.error('Error:', error)

        }
    </script>

    <!-- zoom courses Area Start-->
    <section class="zoom-courses-area pd-top-100 pd-bottom-50">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <b id="total_productos">03 programas en el carrito</b>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="row" id="cart">

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-inner" style="margin-top: 9px;">
                        <form class="row" method="POST" action="{{ route('onlineshop_client_account_store') }}" >
                            @csrf
                            <div id="divCartHidden" style="display: none">
                            </div>
                            <div class="col-md-12">
                                <div id="form-register-payment" class="contact-form">
                                    <div class="row">
                                        <div class="col-md-12 single-input-wrap">
                                            <input type="text" name="names" value="{{ old('names') }}"
                                                placeholder="Nombres" required>
                                            @error('names')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 single-input-wrap">
                                            <input type="text" name="app" value="{{ old('app') }}"
                                                placeholder="Ap. Paterno" required>
                                            @error('app')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 single-input-wrap">
                                            <input type="text" name="apm" value="{{ old('apm') }}"
                                                placeholder="Ap. Materno" required>
                                            @error('apm')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 single-input-wrap">
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                placeholder="Teléfono" required>
                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 single-input-wrap">
                                            <input type="text" name="email" value="{{ old('email') }}"
                                                placeholder="E-mail" required>
                                            @error('email')
                                                <span>{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 single-input-wrap">
                                            <select class="form-select" name="document_type"
                                                aria-label="Default select example">
                                                <option value=""> Tipo de Documento</option>
                                                <option {{ old('document_type') == '1' ? 'selected' : '' }} value="1">
                                                    DNI</option>
                                                <option {{ old('document_type') == '0' ? 'selected' : '' }} value="0">
                                                    Carnet de extranjeria</option>
                                                <option {{ old('document_type') == '6' ? 'selected' : '' }} value="6">
                                                    Ruc</option>
                                            </select>
                                            @error('document_type')
                                                <span>{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <br>
                                        <br>
                                        <div class="col-md-12 single-input-wrap">
                                            <input type="text" name="number" value="{{ old('number') }}"
                                                placeholder="Número" required>
                                            @error('number')
                                                <span>{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="font-size: 20px;">
                                <i class="fa fa-heart"></i> Total:
                            </div>
                            <div class="col-md-12" style="font-size: 25px;">
                                <p><b id="totalid"></b></p>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary" style="width: 100%;" id="btn-crear-cuenta" disabled>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    &nbsp;&nbsp;Crear Cuenta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        cargarItemsCarritoBD();

        function cargarItemsCarritoBD() {
            document.getElementById('cart').innerHTML =
                ""; // BORRAR contenido de la vista, antes de cargar de la base de datos
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            myIds = [];
            carrito.forEach(function(item) {
                // Hacer algo con cada elemento del carrito

                myIds.push(parseInt(item.id));
            });
            
            btnCrear = document.getElementById("btn-crear-cuenta");
                        btnCrear.setAttribute("disabled", "disabled");
            realizarConsulta(myIds);
        }

        function realizarConsulta(ids) {
            // Realizar la petición Ajax
            var csrfToken = "{{ csrf_token() }}";


            $.ajax({
                url: "{{ route('onlineshop_get_item_carrito') }}",
                type: 'POST',
                data: {
                    ids: ids
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(respuesta) {
                    // Obtén una referencia al elemento div por su ID
                    var divCartHidden = document.getElementById("divCartHidden");

                    respuesta.items.forEach(function(item) {
                        // Accede a las propiedades del objeto
                        renderProducto(item);
                        // Crea un elemento input oculto
                        let inputHidden = document.createElement("input");
                        // Establece los atributos del input
                        inputHidden.type = "hidden";
                        inputHidden.name = "item_id[]"; // Asigna el nombre que desees
                        inputHidden.value = item.id; // Asigna el valor que desees
                        // Agrega el input al div
                        divCartHidden.appendChild(inputHidden);
                    });
                    
                    btnCrear = document.getElementById("btn-crear-cuenta");
                        btnCrear.removeAttribute("disabled");

                },
                error: function(xhr) {
                    // Ocurrió un error al realizar la consulta
                    console.log(xhr.responseText);
                    // Aquí puedes manejar el error de alguna manera
                }
            });

        }

        function renderProducto(respuesta) {

            var cart = document.getElementById('cart');
            if (cart != null) {
                var id = respuesta.id;
                var teacher = respuesta.teacher;
                var teacher_id = respuesta.teacher_id;
                var avatar = respuesta.avatar;
                var image = respuesta.image;
                var name = respuesta.name;
                var price = respuesta.price;
                var modalidad = respuesta.additional;
                var url_campus = "";
                var url_descripcion_programa = "/descripcion-programa/"+id; // esta ruta deberá corregirse si se cambia el el get de la RUTA :S
                cart.innerHTML += `
            <div class="col-md-12" style="padding: 10px;" id="` + id + `_pc">
                            <div class="row contact-inner" style="padding: 10px; border: 1px solid #f2f2f2;">
                                <div class="col-md-2">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <img style="height: 90px; object-fit: cover;" src="` + image + `" alt="img"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6><a href="`+url_descripcion_programa+`" target="_blank">` + name + `</a></h6>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 user-details"> 
                                            <img style="width: 30px; height: 30px; border-radius: 50%;" src="` +
                    url_campus + avatar + `" alt="img">
                                            <a>` + teacher + `</a>
                                        </div>
                                        <div class="col-md-4">
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <a href="">
                                                <span style="color:orange;">
                                                    <b>` + modalidad + `</b>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <b>S/. ` + price + `</b>&nbsp;&nbsp;
                                                        <a onclick="eliminarproducto({ id: ` + id + `, nombre: '` +
                    name + `', precio: ` + price + ` });"  class="btn btn-danger">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        `;
            }
        }
    </script>

<script>
    function confirmSubmit(event) {
  event.preventDefault(); // Evita que el formulario se envíe automáticamente
  carrito = JSON.parse(localStorage.getItem("carrito")) || [];
  console.log(carrito);
 if(carrito.length>0){
    console.log(event);
    event.target.form.submit();
 }else
 alert("No has elegido ningún curso");   
  
}
</script>

    <!-- zoom courses Area End -->


    <!-- Más Populares Area Start-->
    <x-capperu.programas-populares-area></x-capperu.programas-populares-area>
    <!-- Más Populares Area End -->



    <x-capperu.footer-area></x-capperu.footer-area>


    <style>
        .text-1XN644 {
            color: #f2f2f2 !important;
        }
    </style>
    {!! htmlScriptTagJsApi([
        'callback_then' => 'callbackThen',
    
        'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection
