@@ -0,0 +1,591 @@
@extends('layouts.capperu')

@section('content')

    <!-- preloader area start -->
    <x-capperu.preloader-area></x-capperu.preloader-area>
    <!-- preloader area end -->
    
    <x-capperu.body-overlay-area></x-capperu.body-overlay-area>

    <!-- search popup area start -->
    <x-capperu.search-popup-area></x-capperu.search-popup-area>
    <!-- //. search Popup -->
    
    <!-- Encabezado inicio -->
    <x-capperu.header-area></x-capperu.header-area>
    <!-- Encabezado fin -->

    
    <!-- Banner Area Start-->
    <section class="banner-area style-3" style="padding: 80px; background-image: url({{ asset('themes/capperu/assets/img/banner/bg-2.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 align-self-center">
                    <div class="banner-inner text-center">
                        <h1>Diplomados Especializados en Sector Empresarial</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->


    
    <!-- trending courses Area Start-->
    <section class="trending-courses-area pd-top-50 pd-bottom-50">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="course-tab nav nav-pills pd-top-100">
                        <li class="nav-item">
                            <button class="nav-link active" id="pill-1" data-bs-toggle="pill" data-bs-target="#pills-01" type="button" role="tab" aria-controls="pills-01" aria-selected="true">E-Learning</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="pill-2" data-bs-toggle="pill" data-bs-target="#pills-02" type="button" role="tab" aria-controls="pills-02" aria-selected="false">En Vivo</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-01" role="tabpanel" aria-labelledby="pill-1">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/7.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">PHP for Beginners - Become a PHP Master - CMS Project</a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/5.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">Java (Beginner) Programming Tutorials
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/4.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">About latest tips news and course for Illustration 2021
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/6.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">Email & Affiliate Marketing Mastermind
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/3.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">Time Management Mastery: Do More, Stress Less
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/1.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">Python Programming Tutorials (Computer Science)
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/2.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">Best way learn fundamentals of design.
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/5.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">Java (Beginner) Programming Tutorials
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/7.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">PHP for Beginners - Become a PHP Master - CMS Project</a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                        <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Nuevo</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-02" role="tabpanel" aria-labelledby="pill-2">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/7.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">PHP for Beginners - Become a PHP Master - CMS Project</a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/5.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">Java (Beginner) Programming Tutorials
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/4.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">About latest tips news and course for Illustration 2021
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/7.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">PHP for Beginners - Become a PHP Master - CMS Project</a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/5.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">Java (Beginner) Programming Tutorials
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="single-course-wrap">
                                        <div class="thumb">
                                            <a href="#" class="cat cat-red">Diplomados</a>
                                            <img src="{{ asset('themes/capperu/assets/img/course/4.png') }}" alt="img">
                                        </div>
                                        <div class="wrap-details">
                                            <h6><a href="#">About latest tips news and course for Illustration 2021
                                            </a></h6>
                                            <div class="user-area">
                                                <div class="user-details">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                                    <a href="#">Jessica Jessy</a>
                                                </div>
                                                <div class="user-rating">
                                                    <span><i class="fa fa-users"></i>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="price-wrap">
                                                <div class="row align-items-center">
                                                    <div class="col-md-12">
                                                        <a href="#" class="btn btn-primary">
                                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                            &nbsp;&nbsp;Comprar Ahora
                                                            <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                        <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Nuevo</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- trending courses Area End -->

    
    <!-- Más Populares Area Start-->
    <x-capperu.programas-populares-area></x-capperu.programas-populares-area>
    <!-- Más Populares Area End -->



    <x-capperu.footer-area></x-capperu.footer-area>

@endsection