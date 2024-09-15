@extends('layouts.celmovil')
@section('content')
    <!-- Preloader Start
                                                                                                                                                                                                                                <div class="preloader">                                                                                                                                                                              </div>
                                                                                                                                                                                                                                                            </div> -->
    <!-- Preloader End -->

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <!-- page banner area start -->
    <div class="page-banner">
        <img style="width: 100%; height: 250px;" src="{{ $banner[0]->content }}" alt="Page Banner" />
    </div>
    <!-- page banner area end -->
    <section class="best-sell-area popular-product section-padding-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                    <div class="section-title text-center">
                        <h3><span>{{ isset($products) && isset($products[0]) ? $products[0]->category_description : '' }}</span></h3>
                        <div class="shape">
                        </div>
                        <p>
                            ¿Listo para experimentar lo último en estilo, tecnología y comodidad?
                            <br>¡Visítanos hoy mismo y déjate sorprender por nuestros productos más populares!
                        </p>
                    </div>
                </div>
            </div>
            <div class="text-center tab-content">
                <div class="tab-pane fade active in">
                    <div class="single-products">
                        <div class="row">
                            @if (count($products) > 0)
                                @foreach ($products as $product)
                                    <div class="col-xs-12 col-md-3" style="padding: 15px;">
                                        <div class="product-item" style="padding: 15px;">
                                            <div class="pro-img">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 220px; height: 220px;">
                                                </a>
                                            </div>
                                            {{-- <div class="actions-btn">
                                                <ul class="clearfix">
                                                    <li>
                                                        <a onclick="agregarAlCarrito({ id: {{ $product->id }}, nombre:{{ '"'.$product->name.'"' }}, color: {{ json_encode($product) }}, precio: {{ $product->price }} })"><i class="fa fa-shopping-cart"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="fa fa-heart"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#" data-toggle="modal" data-target="#quick-view"><i class="fa fa-eye"></i></a>
                                                    </li>
                                                </ul>
                                            </div> --}}
                                            <div class="">
                                                <div class="product-title">
                                                    <a href="{{ route('web_producto_descripcion', $product->id) }}"><h6>{{ $product->name }}</h6></a>
                                                    {{-- <p>Precio: <span>S/ {{ number_format($product->price, 2)  }} </span>
                                                        @if ($product->discount > 0)
                                                            <del>S/ {{ number_format($product->price - ($product->discount ?? 0),2)}}</del>
                                                        @endif
                                                    </p> --}}
                                                </div>
                                            </div>
                                            <div class="info" style="margin-top: 10px;">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}" class="btn btn-celmovil">
                                                    Obtén un <b>Desc. 4%</b>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- quick view start -->
    <div class="product-details quick-view modal animated zoomIn" id="quick-view">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="d-table">
                        <div class="d-tablecell">
                            <div class="modal-dialog">
                                <div class="main-view modal-content">
                                    <div class="modal-footer" data-dismiss="modal">
                                        <span>x</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="left">
                                                <!-- Single-pro-slider Big-photo start -->
                                                <div class="quick-img">
                                                    <img src="img/products/l1.jpg" alt="" />
                                                </div>
                                                <!-- Single-pro-slider Big-photo end -->
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="right">
                                                <div class="singl-pro-title">
                                                    <h3>GT Sensor Carbon Jenson </h3>
                                                    <h1>$1700.00</h1>
                                                    <hr />
                                                    <p>doming id quod mazim placerat facer possim assum. Typi non habent
                                                        claritatem insitam; est usus legentis in iis qui facit eorum
                                                        claritatem. Investigationes demonstraverunt lectores legere me lius
                                                        quod ii legunt saepius.</p>
                                                    <hr />
                                                    <div class="color-brand clearfix">
                                                        <div class="s-select">
                                                            <div class="custom-select">
                                                                <select class="form-control">
                                                                    <option>Color</option>
                                                                    <option>Red </option>
                                                                    <option>Green </option>
                                                                    <option>Blue</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="s-select">
                                                            <div class="custom-select">
                                                                <select class="form-control">
                                                                    <option>Brend</option>
                                                                    <option>Men </option>
                                                                    <option>Fashion </option>
                                                                    <option>Shirt</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="s-select s-plus-minus">
                                                            <form action="#" method="POST">
                                                                <div class="plus-minus">
                                                                    <a class="dec qtybutton">-</a>
                                                                    <input type="text" value="02" name="qtybutton"
                                                                        class="plus-minus-box">
                                                                    <a class="inc qtybutton">+</a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="actions-btn">
                                                        <ul class="clearfix text-center">
                                                            <li>
                                                                <a href="cart.html"><i class="fa fa-shopping-cart"></i> add
                                                                    to cart</a>
                                                            </li>
                                                            <li>
                                                                <a href="cart.html"><i class="fa fa-heart-o"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-compress"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-share-alt"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <hr />
                                                    <div class="categ-tag">
                                                        <ul class="clearfix">
                                                            <li>
                                                                CATEGORIES:
                                                                <a href="#">Bike,</a> <a href="#">Cycle,</a>
                                                                <a href="#">Ride,</a> <a href="#">Mountain</a>
                                                            </li>
                                                            <li>
                                                                TAG:
                                                                <a href="#">Ride,</a> <a href="#">Helmet,</a>
                                                                <a href="#">cycle,</a> <a href="#">bike</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
    <div class="product-details quick-view modal animated zoomIn" id="quick-view-product">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="d-table">
                        <div class="d-tablecell">
                            <div class="modal-dialog">
                                <div class="main-view modal-content">
                                    <div class="modal-footer" data-dismiss="modal">
                                        <span>x</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="left">
                                                <div class="quick-img">
                                                    <img id="modal-image-product-view" alt="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="right">
                                                <div class="singl-pro-title">
                                                    <h3 id="modal-name-product-view"></h3>
                                                    <h1 id="modal-price-product-view">$1700.00</h1>
                                                    <hr />
                                                    <p id="modal-description-product-view"></p>
                                                    <hr />
                                                    <div class="color-brand clearfix">
                                                        <div class="s-select">
                                                            <div class="custom-select">
                                                                <select id="modal-color-product-view"
                                                                    class="form-control">
                                                                    <option value="">Color</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="s-select">
                                                            <div class="custom-select">
                                                                <select class="form-control">
                                                                    <option>Brend</option>
                                                                    <option>Men </option>
                                                                    <option>Fashion </option>
                                                                    <option>Shirt</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="s-select s-plus-minus">
                                                            <form action="#" method="POST">
                                                                <div class="plus-minus">
                                                                    <a class="dec qtybutton">-</a>
                                                                    <input type="text" value="02"
                                                                        name="qtybutton" class="plus-minus-box">
                                                                    <a class="inc qtybutton">+</a>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="actions-btn">
                                                        <ul class="clearfix text-center">
                                                            <li>
                                                                <a href="cart.html"><i class="fa fa-shopping-cart"></i>
                                                                    add to cart</a>
                                                            </li>
                                                            <li>
                                                                <a href="cart.html"><i class="fa fa-heart-o"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-compress"></i></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="fa fa-share-alt"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <hr />
                                                    <div class="categ-tag">
                                                        <ul class="clearfix">
                                                            <li>
                                                                CATEGORIES:
                                                                <a href="#">Bike,</a> <a href="#">Cycle,</a>
                                                                <a href="#">Ride,</a> <a
                                                                    href="#">Mountain</a>
                                                            </li>
                                                            <li>
                                                                TAG:
                                                                <a href="#">Ride,</a> <a
                                                                    href="#">Helmet,</a>
                                                                <a href="#">cycle,</a> <a href="#">bike</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <!-- quick view end -->
    <script>
        function openModalProductDetails(event, productObject) {
            // Evitar que el enlace abra el modal directamente
            event.preventDefault();

            let colores = JSON.parse(productObject.product.sizes);

            const selectElement = document.getElementById('modal-color-product-view');

            // Llenar el select con opciones
            colores.forEach(color => {
                const option = document.createElement('option');
                option.value = color.size;
                option.text = color.size;
                selectElement.appendChild(option);
            });
            // Cambiar el atributo src de la imagen en el modal
            document.getElementById('modal-image-product-view').src = productObject.image;
            document.getElementById('modal-name-product-view').innerHTML = productObject.name;
            document.getElementById('modal-price-product-view').innerHTML = 'S/.' + productObject.price;
            document.getElementById('modal-description-product-view').innerHTML = productObject.description;
            // document.getElementById('modal-centros-dir').innerHTML = centerObject.address;
            // document.getElementById('modal-centros-ifr').innerHTML = centerObject.map;
            // Abre el modal después de procesar la lógica
            // ...

            // Ejemplo: abrir modal usando Bootstrap
            $('#quick-view-product').modal('show');
        }
    </script>


    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
