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
    {{-- <section class="best-sell-area popular-product section-padding-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                    <div class="section-title text-center">
                        <h3><span>
                        @if ($category_id == 1)
                            MOTOS
                            @elseif($category_id == 2)
                            TRIMOTOS
                            @elseif($category_id == 6)
                            BATERIAS
                            @elseif($category_id == 25)
                            CUATRIMOTOS
                            @elseif($category_id == 26)
                            REPUESTOS
                            @elseif($category_id == 27)
                            ACCESORIOS
                        @endif  
                        </span></h3>
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
                                        <div class="product-item" style="padding: 15px;  height: 380px;">
                                            <div class="pro-img">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 220px; height: 220px;">
                                                </a>
                                            </div>
                                            <div class="">
                                                <div class="product-title">
                                                    <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                        <h6><b>{{ $product->name }}</b></h6>
                                                    </a>
                                                    @if ($product->discount > 0)
                                                        @php
                                                            $new_price = $product->price - $product->discount;
                                                        @endphp
                                                        <p>
                                                            Antes: <del> S/ {{ number_format($product->price, 2) }}</del> <br>
                                                            Promoción: <span><b>S/ {{ number_format($new_price, 2) }}</b>
                                                            </span>
                                                        </p>
                                                    @else
                                                        <p>
                                                            Precio: <b>S/ {{ number_format($product->price, 2) }}</b>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div style="margin-top: 10px;">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}" class="btn btn-celmovil">
                                                    <b>Más Información </b>
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
    </section> --}}

    <section style="padding: 40px 0px;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                    <div class="section-title text-center">
                        <h3>
                            <span>
                            @if ($category_id == 1)
                                MOTOS
                                @elseif($category_id == 2)
                                TRIMOTOS
                                @elseif($category_id == 6)
                                VMPS, BICIMOTOS y BICIS
                                @elseif($category_id == 25)
                                CUATRIMOTOS
                                @elseif($category_id == 26)
                                REPUESTOS
                                @elseif($category_id == 27)
                                ACCESORIOS
                            @endif  
                            </span>
                        </h3>
                        <div class="shape">
                        </div>
                        <p>
                            ¿Listo para experimentar lo último en estilo, tecnología y comodidad?
                            <br>¡Visítanos hoy mismo y déjate sorprender por nuestros productos más populares!
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-container">
            @if (count($products) > 0)
                @foreach ($products as $product)
                <div class="grid-item">
                    <div class="product-item" style="padding: 15px;  height: 400px;">
                        <div class="pro-img">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                    style="width: 220px; height: 220px;" />
                            </a>
                        </div>
                        <div class="">
                            <div class="product-title">
                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                    <h5><b>{{ $product->name }}</b></h5>
                                </a>
                                @if ($product->discount > 0)
                                    @php
                                        $new_price = $product->price - $product->discount;
                                    @endphp
                                    <p>
                                        Antes: <del> S/ {{ number_format($product->price, 2) }}</del> <br>
                                        Promoción: <span><b>S/ {{ number_format($new_price, 2) }}</b>
                                        </span>
                                    </p>
                                @else
                                    <p>
                                        Precio: <b>S/ {{ number_format($product->price, 2) }}</b>
                                    </p>
                                @endif
                                {{-- <p>Precio: <span>S/ {{ number_format($product->price - ($product->discount ?? 0),2) }}</span></p> --}}
                            </div>
                        </div>
                        {{-- <div class="info" style="margin-top: -10px;">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}" class="btn btn-celmovil">
                                Obtén un <b>Desc. 4%</b>
                            </a>
                        </div> --}}
                        <div style="margin-top: 10px;">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}"
                                class="btn btn-celmovil">
                                <b>Más Información </b>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
            {{-- <div class="grid-item">1</div>
            <div class="grid-item">2</div>
            <div class="grid-item">3</div>
            <div class="grid-item">4</div>
            <div class="grid-item">5</div>
            <div class="grid-item">6</div>
            <div class="grid-item">7</div>
            <div class="grid-item">8</div>
            <div class="grid-item">9</div> --}}
        </div>
    </section>

    
    <style>
        .grid-container {
        display: grid;
        gap: 10px;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(3, auto);
        width: 100%;
        padding: 20px 40px;
        /* max-width: 600px; */
        }

        .grid-item {
        /* background-color: #007bff; */
        color: white;
        text-align: center;
        padding: 20px;
        border-radius: 5px;
        }

        /* Responsive Design for Mobile */
        @media (max-width: 768px) {
        .grid-container {
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, auto);
            width: 98%;
            padding: 5px;
        }

        .grid-item {
            padding: 10px;
        }
        }
    </style>


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
