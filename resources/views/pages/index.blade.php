@extends('layouts.celmovil')
@section('content')


    <!-- Preloader Start -->
    <div class="preloader">
        <div class="loading-center">
            <div class="loading-center-absolute">
                <div class="object object_one"></div>
                <div class="object object_two"></div>
                <div class="object object_three"></div>
            </div>
        </div>
    </div> 
    <!-- Preloader End -->

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <!-- slider - pc - section start -->
    <div class="slider-area slider-one clearfix view-pc">
        <div class="slider" id="mainslider">
            @foreach ($sliders as $slide)
                <div data-src="{{ $slide->content }}">
                </div>
            @endforeach
        </div>
    </div>
    <!-- slider - pc - section end -->

    <!-- Tarjetas Catalogo - movil - section end -->
    <section class="view-movil" style="padding: 15px 0px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="padding: 15px;">
                    <div class="box-shadow">
                        <a href="https://celmovil.pe/productos/1/list">
                            <img style="width: 100%;" src="{{ asset('themes/celmovil/img/MotosWeb.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding: 15px;">
                    <div class="box-shadow">
                        <a href="https://celmovil.pe/productos/2/list">
                            <img style="width: 100%;" src="{{ asset('themes/celmovil/img/TrimotosWeb.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding: 15px;">
                    <div class="box-shadow">
                        <a href="https://celmovil.pe/productos/6/list">
                            <img style="width: 100%;" src="{{ asset('themes/celmovil/img/BiciWeb.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding: 15px;">
                    <div class="box-shadow">
                        <a href="https://celmovil.pe/productos/25/list">
                            <img style="width: 100%;" src="{{ asset('themes/celmovil/img/CuatrimotosWeb.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Tarjetas Catalogo - movil - section end -->


    <!-- feature products - section start -->
    <x-feature-products-area />
    <!-- feature products - section end -->

    <!-- popular-product section start -->
    <x-popular-product-area /> 
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

    
    <!-- popular-product section start -->
    <x-some-models-area /> 
    <!-- popular-product section end -->

    <br><br>
    <!-- footer - section start -->

    <!-- contact area start -->
    <div class="map-contact clearfix" style="padding: 120px 80px; background: #f8f8f8;">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                <div class="section-title text-center">
                    <h1><span>{{ $ofprincipal[0]->content }}</span> {{ $ofprincipal[1]->content }}</h1>
                    <div class="shape">
                    </div>
                    <p>
                        {{ $ofprincipal[2]->content }}<br>
                        <b>{{ $ofprincipal[3]->content }}</b>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 half-width">
                <img style="width: 100%;" src="{{ $ofprincipal[4]->content }}" alt="">
                <div class="ubicacion" style="padding: 14px 15px; background: #ff6600; color: #fff; text-align:center; ">
                    <b style="font-size: 16px;">{{ $ofprincipal[5]->content }} </b>
                </div>
            </div>
            <div class="col-md-6 googleMap-info half-width">
                {!! $ofprincipal[6]->content !!}
            </div>
        </div>
    </div>
    <!-- contact area end -->
    <x-footer-area />
    <!-- footer - section end -->
@stop
