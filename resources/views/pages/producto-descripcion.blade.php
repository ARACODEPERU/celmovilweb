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
    <section class="page-header-modern">
        <div class="container">
            <div class="header-content text-center">
                <h1 class="modern-title-large">
                    DETALLES DEL <span>PRODUCTO</span>
                </h1>
                <div class="title-line-large"></div>
                <p class="header-description">
                    Descubre todas las características, especificaciones y ventajas de este increíble modelo.
                    <br>¡Calidad, tecnología y garantía asegurada para ti!
                </p>
            </div>
        </div>
        <div class="shape circle-1"></div>
        <div class="shape circle-2"></div>
    </section>

    <style>
        /* Title Styles */
        .page-header-modern {
            position: relative;
            padding: 160px 0 80px; /* Espacio superior para compensar el header fijo */
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            overflow: hidden;
            color: white;
            margin-top: 0;
        }

        .page-header-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 80% 20%, rgba(255, 102, 0, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 20% 80%, rgba(37, 211, 102, 0.1) 0%, transparent 50%);
            z-index: 1;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .modern-title-large {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 15px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .modern-title-large span {
            background: linear-gradient(to right, #ff6600, #ff9933);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .title-line-large {
            width: 100px;
            height: 6px;
            background: #ff6600;
            margin: 0 auto 25px;
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.5);
        }

        .header-description {
            font-size: 1.2rem;
            color: #e5e7eb;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
        }
        .circle-1 {
            width: 300px;
            height: 300px;
            background: rgba(255, 102, 0, 0.1);
            top: -50px;
            left: -50px;
        }
        .circle-2 {
            width: 400px;
            height: 400px;
            background: rgba(59, 130, 246, 0.05);
            bottom: -100px;
            right: -100px;
        }

        @media (max-width: 768px) {
            .page-header-modern {
                padding: 140px 0 60px;
            }
            .modern-title-large {
                font-size: 2.5rem;
            }
        }
    </style>

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
                                <a href="{{ asset($product->image) }}" title="{{ $product->name }}">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
                                </a>
                                @if ($product->existence == 0)
                                    <span
                                        style="background: red; padding: 15px 25px; color: #fff; position: relative; z-index: 999; display: block; margin-top: -50px;">AGOTADO</span>
                                @endif
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
                            <h3><b>{{ $product->name }}</b></h3>
                            <div class="categ-tag">
                                <ul class="clearfix">
                                    <li>
                                        CATEGORIA:
                                        <a href="#">{{ $product->category_description }}</a>
                                    </li>
                                </ul>
                            </div>

                            @if ($product->discount > 0)
                                @php
                                    $new_price = $product->price - $product->discount;
                                @endphp
                                <p>
                                    Antes: <del> S/ {{ number_format($product->price, 2) }}</del> <br>
                                </p>
                                <b>Promoción a:</b>
                                <h1><b style="color: #ff6600;">S/ {{ number_format($new_price, 2) }}</b></h1>
                            @else
                                Precio:
                                <h1><b>S/ {{ number_format($product->price, 2) }}</b></h1>
                            @endif


                            @if (
                                $product->category_description == 'Vmps, Bicimotos, Bios' ||
                                    $product->category_description == 'Trimoto' ||
                                    $product->category_description == 'Cuatrimotos' ||
                                    $product->category_description == 'Moto' ||
                                    $product->category_description == 'Scooter Moped' ||
                                    $product->category_description == 'Deportivos' ||
                                    $product->category_description == 'Chooper' ||
                                    $product->category_description == 'Baterias Litio' ||
                                    $product->category_description == 'Baterias Plomo Acido' ||
                                    $product->category_description == 'Scooter Vintage' ||
                                    $product->category_description == 'Vmps, Bicimotos, Bicis')
                                {{-- <span style="color: #ff6600;">* Obtén un descuento del 4% por tus compras físicas en tienda. </span> --}}
                            @endif
                            <hr />
                            {!! $product->description !!}
                            <br>
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
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                    <button
                                        onclick="agregarAlCarrito_w_color({ id: {{ $product->id }}, nombre:{{ '"' . $product->name . '"' }}, color: {{ json_encode($product) }}, precio: {{ $product->price }} })"
                                        class="btn btn-celmovil btn-lg btn-block" style="padding: 15px 35px; cursor: pointer; font-size: 18px; text-transform: uppercase;"
                                        {{ $product->existence == 0 ? 'disabled' : '' }}>
                                        <i class="fa fa-shopping-cart" style="font-size: 20px;"></i> &nbsp;
                                        <b>AGREGAR AL CARRITO</b>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p style="margin-bottom: 5px; font-size: 12px; color: #666;">¿Tienes dudas? Contáctanos directamente:</p>
                                    <a href="https://api.whatsapp.com/send?phone=51921197459&text=Hola&nbsp;CelMovil!&nbsp;me&nbsp;pueden&nbsp;ayudar?"
                                        target="_blank" class="btn btn-default btn-block" style="border: 1px solid #25D366; color: #25D366; background: transparent;">
                                        <i class="fa fa-whatsapp" aria-hidden="true"></i> Consultar por WhatsApp
                                    </a>
                                </div>
                            </div>
                            
                            <hr style="margin-top: 20px; margin-bottom: 20px;" />
                            
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
                <div class="col-md-12">
                    <div class="pro-des-tab clearfix">
                        <div class="tab-menu hidden-xs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active" role="presentation">
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
                            <div class="tab-pane fade in active" id="des" role="tabpanel">
                                <h4 class="visible-xs mobile-tab-title">DESCRIPCIÓN</h4>
                                {!! $product->additional !!}
                            </div>
                            <div class="tab-pane fade in" id="ficha">
                                <h4 class="visible-xs mobile-tab-title">FICHA TÉCNICA</h4>
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
                                <h4 class="visible-xs mobile-tab-title">INFORMACIÓN ADICIONAL</h4>
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
                                <h4 class="visible-xs mobile-tab-title">MANUAL</h4>
                                <a href="{{ $product->additional3 }}" class="btn btn-celmovil"
                                    style="padding: 20px; font-size: 16px;" target="_blank">
                                    <i class="fa fa-download" aria-hidden="true"></i> &nbsp;
                                    Descargar Manual de Uso
                                </a>
                            </div>
                            <div class="tab-pane fade in" id="legal">
                                <h4 class="visible-xs mobile-tab-title">LEGAL</h4>
                                {!! $product->additional4 !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            
        body.dark .product-details{
            background-color: #111827;
        }
        </style>
    </section>
    <!-- product details area end -->
    <br>
    <!-- related product section start -->
    <x-products-recommended />
    <!-- related product section end -->

    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

    <style>
        /* Estilos para transformar Tabs en Lista Vertical en Móvil */
        @media (max-width: 768px) {
            .tab-content .tab-pane {
                display: block !important; /* Forzar mostrar todos los paneles */
                opacity: 1 !important;
                visibility: visible !important;
                margin-bottom: 30px;
            }
            .mobile-tab-title {
                font-weight: bold;
                border-bottom: 2px solid #ff6600;
                padding-bottom: 10px;
                margin-bottom: 15px;
                color: #333;
            }
        }
    </style>
@stop
