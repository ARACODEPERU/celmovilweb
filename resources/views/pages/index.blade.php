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


    <!-- feature products - section start -->
    <x-feature-products-area />
    <!-- feature products - section end -->

    <!-- promotional - section start -->
    <!--
        <x-promotional-area />
        -->
    <!-- promotional - section end -->

    <!-- promotional two - section start -->
    <!--
        <x-promotional-two-area />
        -->
    <!-- promotional two - section end -->

    <!-- new arival - section start -->
    <!--
        <x-new-arival-area />
        -->
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

    <!-- contact area start -->
    <div class="map-contact clearfix">
        <div class="googleMap-info half-width">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.992244735301!2d-79.01367372520318!3d-8.102270681046402!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91ad1625ab759b6d%3A0xca47db73dbf8502a!2sAv.%20Am%C3%A9rica%20Sur%20397%2C%20Trujillo%2013006!5e0!3m2!1ses-419!2spe!4v1706164769030!5m2!1ses-419!2spe"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>

        </div>
        <div class="footer-contact half-width">
            <form id="pageContactForm">
                <div class="input-text">
                    <input type="text" name="full_name" id="full_name" placeholder="Nombres" required />
                    <input name="phone" id="phone" type="telephone" required placeholder="Teléfono" />
                    <input type="text" name="email" id="email" type="email" required
                        placeholder="Correo Electrónico" />
                    <input type="text" name="subject" placeholder="Asunto" />
                    <textarea name="message" id="message" rows="4" required placeholder="Mensaje" rows="4"></textarea>
                </div>
                <div class="submit-text">
                    <button id="submitPageContactButton">Envíar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- contact area end -->
    <x-footer-area />
    <!-- footer - section end -->
@stop
