@extends('layouts.celmovil')
@section('content')
    <!-- Preloader Start
    <div class="preloader">
        <div class="loading-center">
            <div class="loading-center-absolute">
                <div class="object object_one"></div>
                <div class="object object_two"></div>
                <div class="object object_three"></div>
            </div>
        </div>
    </div> -->
    <!-- Preloader End -->

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

		<!-- page banner area start -->
		<div class="page-banner">
			<img src="{{ asset('themes/celmovil/img/slider/bg3.jpg') }}" alt="Page Banner" />
		</div>
		<!-- page banner area end -->

		<!-- cart page content section start -->
		<section class="cart-page section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive table-one margin-minus section-padding-bottom">
							<table class="spacing-table text-center">
								<thead>
									<tr>
										<th>Producto</th>
										<th>Precio Unitario</th>
										<th>Cantidad</th>
										<th>QTY</th>
										<th>Subtotal</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="td-img text-left">
											<a href="#">
                                                <img style="width: 100px;" src="{{ asset('themes/celmovil/img/cart/1.jpg') }}" alt="Add Product" />
                                            </a>
											<div class="">
												<p>
                                                    <a href="#">Sensor Carbon Jenson GX1 Bike</a><br>
                                                    <b>Color:</b> Negro
                                                </p>
											</div>
										</td>
										<td>$56.00</td>
										<td>
											<form action="#" method="POST">
												<div class="plus-minus">
													<a class="dec qtybutton">-</a>
													<input type="text" value="02" name="qtybutton" class="plus-minus-box">
													<a class="inc qtybutton">+</a>
												</div>
											</form>
										</td>
										<td>$112.00</td>
										<td><i class="fa fa-trash" title="Remove this product"></i></td>
									</tr>
									<tr>
										<td class="td-img text-left">
											<a href="#">
                                                <img style="width: 100px;" src="{{ asset('themes/celmovil/img/cart/1.jpg') }}" alt="Add Product" />
                                            </a>
											<div class="">
												<p>
                                                    <a href="#">Sensor Carbon Jenson GX1 Bike</a><br>
                                                    <b>Color:</b> Negro
                                                </p>
											</div>
										</td>
										<td>$56.00</td>
										<td>
											<form action="#" method="POST">
												<div class="plus-minus">
													<a class="dec qtybutton">-</a>
													<input type="text" value="02" name="qtybutton" class="plus-minus-box">
													<a class="inc qtybutton">+</a>
												</div>
											</form>
										</td>
										<td>$112.00</td>
										<td><i class="fa fa-trash" title="Remove this product"></i></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="single-check responsive">
						<form action="mail.php" method="post">
							<div class="single-input p-bottom50 clearfix">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="estimate-text responsive">
                                            <div class="subtotal clearfix">
                                                <p>Subtotal: <span class="floatright">$156.87</span></p>
                                                <p>Grandtotal: <span class="floatright">$156.87</span></p>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="check-title">
										    <h3>Billing Address</h3>
									    </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Nombres Completos:</label>
                                                <div class="input-text">
                                                    <input type="text" name="name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>DNI:</label>
                                                <div class="input-text">
                                                    <input type="text" name="dni" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Teléfono:</label>
                                                <div class="input-text">
                                                    <input type="text" name="phone" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Email:</label>
                                                <div class="input-text">
                                                    <input type="email" name="email" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="default-btn text-right">
                                                <a class="btn-style" href="checkout.html">PROCEDER A VERIFICAR</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<!-- cart page content section end -->
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


    <script>
        function onSubmit(token) {
          document.getElementById("CartForm").submit();
        }
      </script>
    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
