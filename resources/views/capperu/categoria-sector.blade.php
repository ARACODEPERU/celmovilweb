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
                        <h1>Sector  {{ ucfirst($sector) }}</h1>
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
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="{{ route ('web_sectors', [$sector, 'Curso']) }}">
                                        <img src="{{ asset('themes/capperu/assets/img/course/7.png') }}" alt="img">
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route ('web_sectors', [$sector, 'Curso']) }}" class="btn btn-base" style="width: 100%; text-align:center; border-radius: 0px;">
                                        CURSOS DEL SECTOR {{ strtoupper($sector) }}    
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="single-course-wrap">
                                <div class="thumb">
                                    <a href="{{ route ('web_sectors', [$sector, 'Diplomado']) }}">
                                        <img src="{{ asset('themes/capperu/assets/img/course/5.png') }}" alt="img">
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route ('web_sectors', [$sector, 'Diplomado']) }}" class="btn btn-base2" style="width: 100%; text-align:center; border-radius: 0px;">
                                        DIPLOMADOS DEL SECTOR {{ strtoupper($sector) }}      
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </section>
    <!-- trending courses Area End -->

    
    <!-- Más Populares Area Start-->
    <x-capperu.programas-populares-area></x-capperu.programas-populares-area>
    <!-- Más Populares Area End -->



    <x-capperu.footer-area></x-capperu.footer-area>

@endsection