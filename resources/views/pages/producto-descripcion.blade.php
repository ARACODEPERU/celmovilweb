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
        <img src="{{ asset('themes/celmovil/img/slider/bg1.jpg') }}" alt="Page Banner" />
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
                            <h1>S/ {{ $product->price }}</h1>
                            <hr />
                            {!! $product->description !!}
                            <hr />
                            <div class="color-brand clearfix">
                                <div class="s-select">
                                    <div class="custom-select">
                                        <select class="form-control">
                                            @foreach (json_decode($product->product->sizes) as $color)
                                                <option value="{{ $color->size }}">{{ $color->size }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
                                            <input type="text" value="1" name="qtybutton" class="plus-minus-box">
                                            <a class="inc qtybutton">+</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="actions-btn">
                                <ul class="clearfix text-center">
                                    <li>
                                        <a href="{{ route('web_carrito') }}"><i class="fa fa-shopping-cart"></i> add to
                                            cart</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('web_carrito') }}"><i class="fa fa-heart-o"></i></a>
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
                                        <a href="#">{{ $product->category_description }}</a>
                                    </li>
                                </ul>
                            </div>
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
                            <div class="row" style="padding: 15px 0px;">
                                <div class="col-md-12" style="padding: 5px 0px;">
                                    <a href="" class="btn btn-primary">Más información</a>
                                </div>
                                <div class="col-md-12" style="padding: 5px 0px;">
                                    <a href="" class="btn btn-success"> Whatsapp</a>
                                </div>
                            </div>
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
                            <div class="tab-pane fade in single-blog-page" id="ficha">
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
                                            <img style="width: 100%;" src="{{ asset('storage/' . $product->additional2) }}"
                                                alt="" />
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade in" id="manual">
                                <a href="{{ $product->additional3 }}" class="btn btn-primary"
                                    style="padding: 20px; font-size: 16px;" target="_blank">
                                    Descargar Manual</a>
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
    <section class="related-area riding-one">
        <div class="container">
            <div class="related-title">
                <h5>Related Products s</h5>
            </div>
            <div class="row text-center margin50">
                <div class="related-slider single-products">
                    <div class="related-item col-xs-12">
                        <div class="product-item">
                            <div class="pro-img">
                                <a href="product-details.html"><img
                                        src="{{ asset('themes/celmovil/img/products/r1.jpg') }}" alt="Product" /></a>
                                <div class="tag-n-s">
                                    <span>New</span>
                                </div>
                            </div>
                            <div class="riding-title clearfix">
                                <div class="product-title text-left floatleft">
                                    <a href="#">
                                        <h5>Copenhagen Spitfire Chair</h5>
                                    </a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star gray-star"></i>
                                    </div>
                                    <p><span>$170</span> <del>$175</del></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="related-item col-xs-12">
                        <div class="product-item">
                            <div class="pro-img">
                                <a href="product-details.html"><img
                                        src="{{ asset('themes/celmovil/img/products/r2.jpg') }}" alt="Product" /></a>
                            </div>
                            <div class="riding-title clearfix">
                                <div class="product-title text-left floatleft">
                                    <a href="#">
                                        <h5>Copenhagen Spitfire Chair</h5>
                                    </a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star gray-star"></i>
                                        <i class="fa fa-star gray-star"></i>
                                    </div>
                                    <p><span>$170</span> <del>$175</del></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="related-item col-xs-12">
                        <div class="product-item">
                            <div class="pro-img">
                                <a href="product-details.html"><img
                                        src="{{ asset('themes/celmovil/img/products/r3.jpg') }}" alt="Product" /></a>
                                <div class="tag-n-s">
                                    <span>Sell</span>
                                </div>
                            </div>
                            <div class="riding-title clearfix">
                                <div class="product-title text-left floatleft">
                                    <a href="#">
                                        <h5>Copenhagen Spitfire Chair</h5>
                                    </a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star gray-star"></i>
                                    </div>
                                    <p><span>$170</span> <del>$175</del></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="related-item col-xs-12">
                        <div class="product-item">
                            <div class="pro-img">
                                <a href="product-details.html"><img
                                        src="{{ asset('themes/celmovil/img/products/r4.jpg') }}" alt="Product" /></a>
                            </div>
                            <div class="riding-title clearfix">
                                <div class="product-title text-left floatleft">
                                    <a href="#">
                                        <h5>Copenhagen Spitfire Chair</h5>
                                    </a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star gray-star"></i>
                                        <i class="fa fa-star gray-star"></i>
                                        <i class="fa fa-star gray-star"></i>
                                    </div>
                                    <p><span>$170</span> <del>$175</del></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="related-item col-xs-12">
                        <div class="product-item">
                            <div class="pro-img">
                                <a href="product-details.html"><img
                                        src="{{ asset('themes/celmovil/img/products/r3.jpg') }}" alt="Product" /></a>
                                <div class="tag-n-s">
                                    <span>Sell</span>
                                </div>
                            </div>
                            <div class="riding-title clearfix">
                                <div class="product-title text-left floatleft">
                                    <a href="#">
                                        <h5>Copenhagen Spitfire Chair</h5>
                                    </a>
                                    <div class="ratting">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star gray-star"></i>
                                    </div>
                                    <p><span>$170</span> <del>$175</del></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- related product section end -->

    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
