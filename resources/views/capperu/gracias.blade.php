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
    <section class="banner-area style-3"
        style="padding: 40px; background-image: url({{ asset('themes/capperu/assets/img/banner/bg-2.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 align-self-center">
                    <div class="banner-inner text-center">
                        <h1> Bienvenido</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->


    <!-- zoom courses Area Start-->
    <section class="potential-area-2" style="padding: 100px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="thumb mb-lg-0 mb-4 me-xl-5 me-lg-3 me-0">
                        <img src="{{ asset('themes/capperu/assets/img/about/2.jpg') }}" alt="img">
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="section-title mb-0">
                        <h2>Hola!</h2>
                        <p>
                            <b>{{ $person->full_name }}</b>
                            <br>A nombre de toda la familia de CAP PERU te damos la bienvenida a nuestra plataformas de
                            estudio,
                            al mismo tiempo te hacemos recordar que cualquier duda puedes comunicarte con nuestro equipo de
                            asesores.
                        </p>
                        <p>Los accesos al campus virtual han sido enviados a tu correo: <b>{{ $person->email }}</b></p>
                        <br>
                        <h5><i class="fa fa-heart"></i> Gracias por tu compra</h5>
                        <a class="btn btn-base me-4" href="{{ env('URL_CAMPUS') }}"><i class="fa fa-university"
                                aria-hidden="true"></i>&nbsp;&nbsp; Ir al Campus Virtual</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- zoom courses Area End -->



    <x-capperu.footer-area></x-capperu.footer-area>

    <script>
        eliminarCarrito();
    </script>

    <style>
        .text-1XN644 {
            color: #f2f2f2 !important;
        }
    </style>
@endsection
