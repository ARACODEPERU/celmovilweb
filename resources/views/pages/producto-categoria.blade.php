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
        <img width="100%;" src="{{ asset('themes/celmovil/img/banner_producto.jpeg') }}" alt="Page Banner" />
    </div>
    <!-- page banner area end -->

hola
    <!-- product content section start -->
    <section class="product-content section-padding">
        <div class="container">
            <div class="row">
                <div class="tab-content">
                    <div class="tab-pane fade in active text-center" id="grid">
                        <div class="single-products">
                            @if (count($products) > 0)
                                @foreach ($products as $product)
                                    <div class="col-md-3">
                                        <div class="product-item margin40">
                                            <div class="pro-img">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                    <img src="{{ asset('storage/' . $product->image) }}"
                                                        alt="{{ $product->name }}" />
                                                </a>
                                                <div class="actions-btn">
                                                    <ul class="clearfix">
                                                        <li>
                                                            <a href="cart.html"><i class="fa fa-shopping-cart"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#"><i class="fa fa-heart"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#quick-view"><i class="fa fa-eye"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-title">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                    <h5>{{ $product->name }}</h5>
                                                </a>
                                                <p>
                                                    <span>S/. {{ $product->price }}</span>
                                                    @if ($product->discount > 0)
                                                        <del>S/ {{ $product->price - ($product->discount ?? 0) }}</del>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    {{ $products->links('vendor.pagination.bootstrap-4') }}
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </section>
    <!-- product content section end -->

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



    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
