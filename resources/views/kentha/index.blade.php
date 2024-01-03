@extends('layouts.kentha')

@section('content')
    <div id="page" class="page_wapper hfeed site">
        <!----header----->
        <x-header-area />
        <!----header end----->
        <!----preloader----->
        <div class="preloader-wrap">
            <div class="preloader"
                style="
                    background-image: url({{ asset('themes/kentha/assets/images/preloader.gif') }});
                ">
            </div>
            <div class="overlay"></div>
        </div>
        <!----preloader end----->
        <!--===============PAGE CONTENT==============-->
        <!--===============PAGE CONTENT==============-->
        <div id="content" class="site-content ">

            <!--- slider-->
            <x-slider-area />
            <!---slider-end--->

            <!--about-->
            <x-about />
            <!---about end-->

            <!--client-->
            <x-clientes-area />
            <!---client end-->

            <!--servicios-->
            <x-servicios />
            <!--servicios end-->

            <!--Ventajas-->
            <x-ventajas-area />
            <!--Ventajas end-->

            <!--projectos-->
            <x-proyectos-area />
            <!---projectos end-->

            <!---testimonial-->
            <x-testimonios-area />
            <!--testimonial end-->

            <!---contact-->
            <x-contacto-area />
            <!--contact end-->

            <!---Puntos Claves-->
            <x-puntos-claves-area />
            <!--Puntos Claves end-->

            <!---blog--->
            <x-news-blog-area />
            <!---blog-end--->

        </div>
        <!--===============PAGE CONTENT==============-->
        <!--===============PAGE CONTENT==============-->
    </div>
    <!---==============footer start =================-->
    <x-footer-area />
    <!---==============mobile menu =================-->

    <x-modal-area />
@endsection
