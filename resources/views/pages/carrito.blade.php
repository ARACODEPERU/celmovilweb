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
        <img src="{{ $banner[0]->content }}" alt="Page Banner" />
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
                                {{-- <tr>
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
                    <form action="{{ route('web_pagar') }}" method="post">
                        @csrf
                        <div class="single-input p-bottom50 clearfix">
                            <div id="input-hidden">
                                <input type="hidden" name="product_id[]">
                                <input type="hidden" name="product_name[]">
                                <input type="hidden" name="product_category_id[]">
                                <input type="hidden" name="product_quantity[]">
                                <input type="hidden" name="product_price[]">
                            </div>
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <h4>Datos de comprador</h4>
                                    <div class="form-group">
                                        <label for="names">Nombre</label>
                                        <input name="names" id="names" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Teléfono</label>
                                        <input name="phone" id="phone" class="form-control" required />
                                    </div>

                                    <button type="submit" class="btn btn-primary g-recaptcha" style="width: 100%;"
                                        id="btn-crear-cuenta">
                                        <i class="fa fa-cart-shopping"></i>
                                        &nbsp;Comprar
                                    </button>
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
        function quantity(index, masmen, price) {
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            if (masmen == 1) {
                carrito[index].quantity = parseInt(carrito[index].quantity) + 1;
            }
            if (masmen == 0) {
                if (carrito[index].quantity > 1) {
                    carrito[index].quantity = parseInt(carrito[index].quantity) - 1;
                }
            }
            document.getElementById("p_q_" + carrito[index].id).value = carrito[index]
                .quantity; //cambiar valor en el los inputHidden del form pay
            localStorage.setItem('carrito', JSON.stringify(carrito));
            carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            console.log(carrito[index].quantity);
            console.log(carrito[index].quantity * price);
            document.getElementById(index + "qty").value = carrito[index].quantity;
            let tempSubTotal = carrito[index].quantity * price;
            document.getElementById(index + "subTotal").innerHTML = "S/ " + formatearNumero(tempSubTotal);
            getTotal();
        }
    </script>
    <script>
        function confirmSubmit(event) {
            event.preventDefault(); // Evita que el formulario se envíe automáticamente
            carrito = JSON.parse(localStorage.getItem("carrito")) || [];
            console.log(carrito);
            if (carrito.length > 0) {
                console.log(event);
                event.target.form.submit();
            } else
                alert("No has elegido ningún curso");

        }
        function formatearNumero(numero) {
    // Convertir el número a un string con dos decimales
    let numeroConDecimales = Number(numero).toFixed(2);
    // Formatear el número con separadores de miles y decimales
    return numeroConDecimales.toLocaleString('es-PE');

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
