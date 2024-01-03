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
    <section class="banner-area style-3" style="padding: 40px; background-image: url({{ asset('themes/capperu/assets/img/banner/bg-2.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 align-self-center">
                    <div class="banner-inner text-center">
                        <h1>Categorias</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->


    
    <!-- trending courses Area Start-->
    <section class="trending-courses-area pd-top-135 pd-bottom-130">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="dmne-sidebar">
                        <div class="widget widget-select-inner">
                            <h4 class="widget-title">Programas Especializados</h4>
                            <ul>
                                <li>
                                    <div class="single-form-check form-check">
                                        <input checked class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                        <label class="form-check-label" for="flexCheckDefault1">
                                          Todos
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-form-check form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                        <label class="form-check-label" for="flexCheckDefault2">
                                            Sector Empresarial
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-form-check form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                        <label class="form-check-label" for="flexCheckDefault3">
                                            Sector Derecho
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-form-check form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                        <label class="form-check-label" for="flexCheckDefault4">
                                            Sector Público
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget-select-inner">
                            <h4 class="widget-title">Modalidad de Estudios</h4>
                            <ul>
                                <li>
                                    <div class="single-form-check form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault14">
                                        <label class="form-check-label" for="flexCheckDefault14">
                                            En Vivo
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-form-check form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault15">
                                        <label class="form-check-label" for="flexCheckDefault15">
                                            E-Learning 
                                            <br>(auto-administrado)
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="widget widget-select-inner">
                            <h4 class="widget-title">Programa</h4>
                            <ul>
                                <li>
                                    <div class="single-form-check form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault17">
                                        <label class="form-check-label" for="flexCheckDefault17">
                                            Curso
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-form-check form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault18">
                                        <label class="form-check-label" for="flexCheckDefault18">
                                            Diplomado
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="#" class="cat cat-blue">Curso</a>
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
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="#" class="cat cat-red">Diplomado</a>
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
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="#" class="cat cat-red">Diplomado</a>
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
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="#" class="cat cat-blue">Curso</a>
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
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="#" class="cat cat-red">Diplomado</a>
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
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="#" class="cat cat-blue">Curso</a>
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
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="#" class="cat cat-blue">Curso</a>
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
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="#" class="cat cat-red">Diplomado</a>
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
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="#" class="cat cat-blue">Curso</a>
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
                </div>
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
    </section>
    <!-- trending courses Area End -->

    
    <!-- Más Populares Area Start-->
    <x-capperu.programas-populares-area></x-capperu.programas-populares-area>
    <!-- Más Populares Area End -->



    <x-capperu.footer-area></x-capperu.footer-area>

@endsection