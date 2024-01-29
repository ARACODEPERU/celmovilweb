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
							<table class="spacing-table text-center" id="divCartHidden">
								<thead>
									<tr>
										<th>Producto</th>
										<th>Precio Unitario</th>
										<th>Cantidad</th>
										<th>SubTotal</th>
										<th>Remover</th>
									</tr>
								</thead>
								<tbody id="cart">
									{{--<tr>
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
									</tr> --}}
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
                                                <p>Subtotal ELIMINAR NO VA: <span class="floatright" id="SubTotal">156.87</span></p>
                                                <p>Grandtotal: <span class="floatright" id="totalid">156.87</span></p>
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
                                            <button class="btn btn-primary g-recaptcha" style="width: 100%;" id="btn-crear-cuenta"
                                            disabled>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                &nbsp;Crear Cuenta
                                            </button>
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
            document.addEventListener("DOMContentLoaded", function() {
                post_url = "{{ route('onlineshop_get_item_carrito') }}";
                token = "{{ csrf_token() }}";
                cargarItemsCarritoBD(post_url, token);
            });

        </script>
    <script>
        function quantity(index, masmen, price){
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            if(masmen == 1){
                carrito[index].quantity += 1;
            }
            if(masmen == 0){
                if(carrito[index].quantity > 1){
                    carrito[index].quantity -= 1;
                }
            }
            localStorage.setItem('carrito', JSON.stringify(carrito));
            carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            console.log(carrito[index].quantity);
            console.log(carrito[index].quantity*price);
            document.getElementById(index+"qty").value=carrito[index].quantity;
            let tempSubTotal = carrito[index].quantity*price;
            document.getElementById(index+"subTotal").innerHTML="S/ "+tempSubTotal;
            getTotal();
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
