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
                        <h1>Categoria: Cursos</h1>
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
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
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
                            <h4 class="widget-title">Modalidad</h4>
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
                                        <input checked class="form-check-input" type="checkbox" value="" id="flexCheckDefault17">
                                        <label class="form-check-label" for="flexCheckDefault17">
                                            Cursos
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-form-check form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault18">
                                        <label class="form-check-label" for="flexCheckDefault18">
                                            Diplomados
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
                                    <a href="">
                                        <img src="{{ asset('themes/capperu/assets/img/course/7.png') }}" alt="img">
                                    </a>
                                </div>
                                <div>
                                    <a href="" class="btn btn-base" style="width: 100%; text-align:center; border-radius: 0px;">
                                        CURSOS ESPECIALIZADOS EN SECTOR EMPRESARIAL     
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="">
                                        <img src="{{ asset('themes/capperu/assets/img/course/5.png') }}" alt="img">
                                    </a>
                                </div>
                                <div>
                                    <a href="" class="btn btn-base" style="width: 100%; text-align:center; border-radius: 0px;">
                                        CURSOS ESPECIALIZADOS EN SECTOR EMPRESARIAL 
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="">
                                        <img src="{{ asset('themes/capperu/assets/img/course/6.png') }}" alt="img">
                                    </a>
                                </div>
                                <div>
                                    <a href="" class="btn btn-base" style="width: 100%; text-align:center; border-radius: 0px;">
                                        CURSOS ESPECIALIZADOS EN SECTOR PÚBLICO 
                                    </a>
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