@extends('layouts.celmovil')
@section('content')
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <!-- page banner area start -->
    <div class="page-banner">
        <img width="800px" src="https://www.pinfuvote.net/wp-content/uploads/2020/04/gracias-por-tu-compra.jpg" alt="Page Banner" />
    </div>
    <!-- page banner area end -->

    <!-- cart page content section start -->
    <section class="cart-page section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive table-one margin-minus section-padding-bottom">
                        <table class="spacing-table text-center">
                            <thead>
                                <tr>
                                    <th>Productos Adquiridos</th>
                                    <th>Cantidad</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @if (count($products) > 0)
                                    @foreach ($products as $product) --}}
                                        <tr>
                                            <td class="td-img text-left">
                                                <a href="#">
                                                    <img style="width: 100px;" src="{{ asset('themes/celmovil/img/slider/bg3.jpg') }}"
                                                        alt="Add Product" />
                                                </a>
                                                <div class="">
                                                    <p>
                                                        <a href="#">Moto Deportiva 1500W</a><br>
                                                        <b>Color:</b> Negro
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <p>3</p>
                                            </td>
                                            <td>S/ 4500.00</td>
                                        </tr>




                                        <tr>
                                            <td class="td-img text-left">
                                                <a href="#">
                                                    <img style="width: 100px;" src="{{ asset('themes/celmovil/img/slider/bg3.jpg') }}"
                                                        alt="Add Product" />
                                                </a>
                                                <div class="">
                                                    <p>
                                                        <a href="#">Trimoto Electrica Familiar</a><br>
                                                        <b>Color:</b> Rojo
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <p>3</p>
                                            </td>
                                            <td>S/ 1900.00</td>
                                        </tr>
                                    {{-- @endforeach
                                @endif --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="padding: 20px; background: #f8f8f8;">
                        <h3>Tu Compra ha sido Exitosa</h3>
                        <p>Agradecemos su preferencia por nuestros productos. Por favor, ahora espera que nuestro personal se comunicará contigo en las proximas horas.</p>
                        <br>
                        <p>Centro de Atención al Cliente: 955 555 555</p><br>
                        <h4>Total:</h4>
                        <p style="color: orange; font-size: 16px;"><b>S/ 6400.00</b></p>
                    </div>
                    <div id="cardPaymentBrick_container"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart page content section end -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
