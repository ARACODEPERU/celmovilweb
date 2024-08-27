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
    <!-- product details area start -->
    <section class="product-details section-padding-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="left">
                        <!-- Single-pro-slider Big-photo start -->
                        <div class="large-slider zoom-gallery">
                            <div>
                                <img src="{{ asset($product->image) }}" alt="" />
                                @if ($product->existance)
                                    <span style="background: red; padding: 10px 20px; font-size: 22px; color: white;">AGOTADO</span>
                                @endif
                                <a href="{{ asset($product->image) }}" title="{{ $product->name }}">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
                                </a>
                            </div>
                            @foreach ($product->images as $image)
                                <div>
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" />
                                    <a href="{{ asset('storage/' . $image->image_path) }}" title="{{ $product->name }}">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            alt="{{ $product->name }}" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <!-- Single-pro-slider Big-photo end -->

                        <!-- Single-pro-slider Small-photo start -->
                        <div class="thumb-slider slider-nav">
                            <div>
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
                            </div>
                            @foreach ($product->images as $image)
                                <div>
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" />
                                </div>
                            @endforeach
                        </div>
                        <!-- Single-pro-slider Small-photo end -->
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="right">
                        <div class="singl-pro-title">
                            <h3>{{ $product->name }}</h3>
                            <h1>S/ {{ number_format($product->price, 2) }}</h1>
                            @if ($product->category_description=="Vmps, Bicimotos, Bios" || $product->category_description=="Trimoto"
                                || $product->category_description=="Cuatrimotos"  || $product->category_description=="Moto"
                                || $product->category_description=="Scooter Moped" || $product->category_description=="Deportivos"
                                || $product->category_description=="Chooper" || $product->category_description=="Baterias Litio"
                                || $product->category_description=="Baterias Plomo Acido" || $product->category_description=="Scooter Vintage"
                                || $product->category_description=="Vmps, Bicimotos, Bicis")
                                <span style="color: #ff6600;">* Obtén un descuento del 4% por tus compras físicas en tienda. </span>
                            @endif
                            <div class="categ-tag">
                                <ul class="clearfix">
                                    <li>
                                        CATEGORIA:
                                        <a href="#">{{ $product->category_description }}</a>
                                    </li>
                                </ul>
                                <!--
                                        <span style="color: orange;"><b>Agotado </b></span>
                                        -->
                            </div>
                            <hr />
                            {!! $product->description !!}
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="https://api.whatsapp.com/send?phone=51921197459&text=Hola&nbsp;CelMovil!&nbsp;me&nbsp;pueden&nbsp;ayudar?"
                                        target="_blanck" class="btn btn-success">
                                        <div style="justify-content: space-between;">
                                            <div style="float: left; padding: 5px;">
                                                <img style="width: 40px;"
                                                    src="{{ asset('themes/celmovil/img/isotipo.png') }}" alt="">
                                            </div>
                                            <div style="float: left; padding: 5px;">
                                                Para cotizar un producto <br>
                                                <b>¡Escribenos al whatsapp!</b>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px;">
                                    {!! $product->additional1 !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="padding: 10px 17px; margin-top: -10px;">
                                    <div class="color-brand clearfix">
                                        @if ($product->product->presentations)
                                            <div class="s-select">
                                                <div class="custom-select">
                                                    <select class="form-control" id="color_selected">
                                                        @foreach (json_decode($product->product->sizes) as $color)
                                                            <option value="{{ $color->size }}">{{ $color->size }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        {{-- <div class="s-select">
                                            <div class="custom-select">
                                                <select class="form-control">
                                                    <option>Brend</option>
                                                    <option>Men </option>
                                                    <option>Fashion </option>
                                                    <option>Shirt</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="s-select s-plus-minus">
                                            <form action="#" method="POST">
                                                <div class="plus-minus">
                                                    <a class="dec qtybutton">-</a>
                                                    <input type="text" value="1" name="qtybutton"
                                                        class="plus-minus-box" id="quantity">
                                                    <a class="inc qtybutton">+</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <a onclick="agregarAlCarrito_w_color({ id: {{ $product->id }}, nombre:{{ '"' . $product->name . '"' }}, color: {{ json_encode($product) }}, precio: {{ $product->price }} })"
                                        class="btn btn-celmovil" style="padding: 10px 35px;">
                                        <i class="fa fa-shopping-cart" style="font-size: 18px;"></i> &nbsp;
                                        <b>AGREGAR AL CARRITO</b>
                                    </a>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-12">
                                </div>
                            </div>

                            @if (count($product->specifications) > 0)
                                <div class="specific-pro">
                                    <ul>
                                        <li class="specific-pro-title">
                                            ESPECIFICACIONES DEL PRODUCTO
                                        </li>
                                        @if (count($product->specifications) > 0)
                                            @foreach ($product->specifications as $specification)
                                                <li>
                                                    <span>{{ $specification->title }}</span>
                                                    <p>{{ $specification->description }}</p>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="pro-des-tab">
                        <div class="tab-menu">
                            <ul>
                                <li class="active">
                                    <a data-toggle="tab" href="#des">DESCRIPCIÓN</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#ficha">FICHA TECNICA</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#info">INFORMACIÓN ADICIONAL</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#manual">MANUAL</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#legal">LEGAL</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content margin50">
                            <div class="tab-pane fade in active" id="des">
                                {!! $product->additional !!}
                            </div>
                            <div class="tab-pane fade in" id="ficha">
                                <div class="leave-comment">
                                    @php
                                        $porciones = explode('.', $product->additional2);

                                        $ext = is_array($porciones) ? $porciones[1] : null;
                                    @endphp
                                    @if ($ext)
                                        @if ($ext == 'pdf')
                                            <iframe src="{{ asset('storage/' . $product->additional2) }}"
                                                style="border: none;width: 100%;height: 1325px"></iframe>
                                        @else
                                            <img style="width: 100%;"
                                                src="{{ asset('storage/' . $product->additional2) }}" alt="" />
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="info">
                                @if ($product->additional6)
                                    @php
                                        $porciones6 = explode('.', $product->additional6);

                                        $ext6 = is_array($porciones6) ? $porciones6[1] : null;
                                    @endphp
                                    @if ($ext6)
                                        @if ($ext6 == 'pdf')
                                            <iframe src="{{ asset('storage/' . $product->additional6) }}"
                                                style="border: none;width: 100%;height: 1325px"></iframe>
                                        @else
                                            <img style="width: 100%;"
                                                src="{{ asset('storage/' . $product->additional6) }}" alt="" />
                                        @endif
                                    @endif
                                @endif
                            </div>
                            <div class="tab-pane fade in" id="manual">
                                <a href="{{ $product->additional3 }}" class="btn btn-celmovil"
                                    style="padding: 20px; font-size: 16px;" target="_blank">
                                    <i class="fa fa-download" aria-hidden="true"></i> &nbsp;
                                    Descargar Manual de Uso
                                </a>
                            </div>
                            <div class="tab-pane fade in" id="legal">
                                {!! $product->additional4 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product details area end -->
    <!-- related product section start -->
    <x-products-recommended />
    <!-- related product section end -->

    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
