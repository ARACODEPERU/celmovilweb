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

    <!-- slider - section start -->
    <x-slider-home />
    <!-- slider - section end -->

    <!-- mata section start -->
    <section class="mata-area mata-one section-padding-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="single-mata">
                        <div class="product-item">
                            <div class="pro-img">
                                <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/products/1.jpg') }}"
                                        alt="Product" /></a>
                                <div class="link-icon">
                                    <a href="product-details.html"><i class="fa fa-link"></i></a>
                                    <div class="zoom-gallery">
                                        <a href="{{ asset('themes/celmovil/img/products/1.jpg') }}"><img
                                                src="{{ asset('themes/celmovil/img/icon/plus.png') }}" alt="Product" /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mata-title clearfix">
                                <div class="product-title">
                                    <a href="product-details.html">
                                        <h5>Gear wheet meta</h5>
                                    </a>
                                    <p><span>$110.00</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="product-item margin-top">
                            <div class="pro-img">
                                <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/products/2.jpg') }}"
                                        alt="Product" /></a>
                                <div class="link-icon">
                                    <a href="product-details.html"><i class="fa fa-link"></i></a>
                                    <div class="zoom-gallery">
                                        <a href="{{ asset('themes/celmovil/img/products/2.jpg') }}"><img
                                                src="{{ asset('themes/celmovil/img/icon/plus.png') }}" alt="Product" /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mata-title clearfix">
                                <div class="product-title">
                                    <a href="product-details.html">
                                        <h5>Gear wheet meta</h5>
                                    </a>
                                    <p><span>$110.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="single-mata middel">
                        <div class="product-item">
                            <div class="pro-img">
                                <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/products/3.jpg') }}"
                                        alt="Product" /></a>
                                <div class="link-icon">
                                    <a href="product-details.html"><i class="fa fa-link"></i></a>
                                    <div class="zoom-gallery">
                                        <a href="{{ asset('themes/celmovil/img/products/3.jpg') }}"><img
                                                src="{{ asset('themes/celmovil/img/icon/plus.png') }}" alt="Product" /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mata-title clearfix">
                                <div class="product-title">
                                    <a href="product-details.html">
                                        <h5>Gear wheet meta</h5>
                                    </a>
                                    <p><span>$110.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="single-mata right">
                        <div class="product-item">
                            <div class="pro-img">
                                <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/products/4.jpg') }}"
                                        alt="Product" /></a>
                                <div class="link-icon">
                                    <a href="product-details.html"><i class="fa fa-link"></i></a>
                                    <div class="zoom-gallery">
                                        <a href="{{ asset('themes/celmovil/img/products/4.jpg') }}"><img
                                                src="{{ asset('themes/celmovil/img/icon/plus.png') }}"
                                                alt="Product" /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mata-title clearfix">
                                <div class="product-title">
                                    <a href="product-details.html">
                                        <h5>Gear wheet meta</h5>
                                    </a>
                                    <p><span>$110.00</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="product-item margin-top">
                            <div class="pro-img">
                                <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/products/5.jpg') }}"
                                        alt="Product" /></a>
                                <div class="link-icon">
                                    <a href="product-details.html"><i class="fa fa-link"></i></a>
                                    <div class="zoom-gallery">
                                        <a href="{{ asset('themes/celmovil/img/products/5.jpg') }}"><img
                                                src="{{ asset('themes/celmovil/img/icon/plus.png') }}"
                                                alt="Product" /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="mata-title clearfix">
                                <div class="product-title">
                                    <a href="product-details.html">
                                        <h5>Gear wheet meta</h5>
                                    </a>
                                    <p><span>$110.00</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- mata section end -->

    <!-- feature products - section start -->
    <x-feature-products-area />
    <!-- feature products - section end -->

    <!-- promotional - section start -->
    <x-promotional-area />
    <!-- promotional - section end -->

    <!-- promotional two - section start -->
    <x-promotional-two-area />
    <!-- promotional two - section end -->

    <!-- new arival - section start -->
    <x-new-arival-area />
    <!-- new arival - section end -->

    <!-- product desc - section start -->
    <x-product-desc-area />
    <!-- product desc - section end -->

    <!-- popular-product section start -->
    {{-- <x-popular-product-area /> --}}
    <!-- popular-product section end -->

    <!-- blog section start
                                            <section class="blog-area blog-two section-padding">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                                                            <div class="section-title text-center">
                                                                <h3><span>FROM</span> BLOG</h3>
                                                                <div class="shape">
                                                                    <img src="{{ asset('themes/celmovil/img/icon/t-shape.png') }}" alt="Title Shape" />
                                                                </div>
                                                                <p>It is a long established fact that a reader will be distracted by the readable content of a page
                                                                    when looking at its layout.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="blog-item">
                                                                <div class="blog-img">
                                                                    <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/blog/1.jpg') }}" alt="Blog" /></a>
                                                                </div>
                                                                <div class="blog-text clearfix">
                                                                    <a href="single-blog.html">
                                                                        <h4>Claritas est etiam processus</h4>
                                                                    </a>
                                                                    <p class="date-com"><span>Rakib Hossain</span> | jan 17 - 2016 | 12 comments</p>
                                                                    <hr class="line" />
                                                                    <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim
                                                                        placerat facer possim assum. </p>
                                                                    <div class="view-more">
                                                                        <a class="shop-btn" href="single-blog.html">Read More</a>
                                                                        <a class="shop-btn" href="#"><i class="fa fa-share-alt"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="blog-item">
                                                                <div class="blog-img">
                                                                    <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/blog/2.jpg') }}" alt="Blog" /></a>
                                                                </div>
                                                                <div class="blog-text clearfix">
                                                                    <a href="single-blog.html">
                                                                        <h4>Claritas est etiam processus</h4>
                                                                    </a>
                                                                    <p class="date-com"><span>Rakib Hossain</span> | jan 17 - 2016 | 12 comments</p>
                                                                    <hr class="line" />
                                                                    <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim
                                                                        placerat facer possim assum. </p>
                                                                    <div class="view-more">
                                                                        <a class="shop-btn" href="single-blog.html">Read More</a>
                                                                        <a class="shop-btn" href="#"><i class="fa fa-share-alt"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="blog-item">
                                                                <div class="blog-img">
                                                                    <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/blog/3.jpg') }}" alt="Blog" /></a>
                                                                </div>
                                                                <div class="blog-text clearfix">
                                                                    <a href="single-blog.html">
                                                                        <h4>Claritas est etiam processus</h4>
                                                                    </a>
                                                                    <p class="date-com"><span>Rakib Hossain</span> | jan 17 - 2016 | 12 comments</p>
                                                                    <hr class="line" />
                                                                    <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim
                                                                        placerat facer possim assum. </p>
                                                                    <div class="view-more">
                                                                        <a class="shop-btn" href="single-blog.html">Read More</a>
                                                                        <a class="shop-btn" href="#"><i class="fa fa-share-alt"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>-->
    <!-- blog section end -->

    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->
@stop
