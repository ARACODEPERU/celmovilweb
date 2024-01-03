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
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <!-- Banner Area Start-->
    <section class="banner-area style-3"
        style="padding: 40px; background-image: url({{ asset('themes/capperu/assets/img/banner/bg-2.jpg') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 align-self-center">
                    <div class="banner-inner text-center">
                        <h1>Realizar Pago</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->
    @php
        $total = 0;
    @endphp

    <!-- zoom courses Area Start-->
    <section class="zoom-courses-area pd-top-100 pd-bottom-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <b id="total_productos">{{ count($cart_items) }} programas en el carrito</b>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        @if (count($cart_items) > 0)
                            @foreach ($cart_items as $ky => $cart_item)
                                <div class="col-md-12" style="padding: 10px;" id="1_pc">
                                    <div class="row contact-inner" style="padding: 10px; border: 1px solid #f2f2f2;">
                                        <div class="col-md-2">
                                            <div class="single-course-wrap">
                                                <div class="thumb">
                                                    <!--<a href="#" class="cat cat-blue">Curso</a>-->
                                                    <img style="height: 90px; object-fit: cover;"
                                                        src="{{ $cart_item['image'] }}" alt="img">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6>{{ $cart_item['name'] }}</h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="{{ $cart_item['avatar'] }}" alt="img">
                                                    <a href="#">{{ $cart_item['teacher'] }}</a>
                                                </div>
                                                <div class="col-md-4">

                                                </div>
                                                <div class="col-md-4">
                                                    <a href="">
                                                        <span style="color:orange;">
                                                            <b>{{ $cart_item['additional1'] }}</b>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="single-course-wrap">
                                                <div class="price-wrap">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <b>S/. {{ $cart_item['price'] }}</b>&nbsp;&nbsp;
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $total = $total + $cart_item['price'];
                                @endphp
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-uppercase">{{ $person_full_name }}</p>
                                @if ($preference_id)
                                    <p class="fst-italic">Le agradecemos por registrarse. Ahora, solo necesita hacer un clic
                                        para acceder a nuestros cursos y/o diplomados. ¡Bienvenido/a!</p>
                                @else
                                    <p class="fst-italic">El pago para la compra especificada ya fue realizado</p>
                                @endif
                            </div>
                            <div class="col-md-12" style="font-size: 20px;">
                                <i class="fa fa-heart"></i> Total:
                            </div>
                            <div class="col-md-12" style="font-size: 25px;">
                                <p><b>S/. {{ number_format($total, 2, '.', ',') }}</b></p>
                            </div>
                            <div class="col-md-12">
                                <div id="wallet_container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($preference_id)
        <script>
            const mp = new MercadoPago("{{ env('MERCADOPAGO_KEY') }}");
            mp.bricks().create("wallet", "wallet_container", {
                initialization: {
                    preferenceId: "{{ $preference_id }}",
                    redirectMode: "modal",
                },
            });
        </script>
    @endif

    <!-- zoom courses Area End -->
    <x-capperu.footer-area></x-capperu.footer-area>

    <style>
        .text-1XN644 {
            color: #f2f2f2 !important;
        }
    </style>
@endsection
