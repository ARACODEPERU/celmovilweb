@extends('layouts.kentha')
@section('content')
    <div id="page" class="page_wapper hfeed site">
        <x-header-area />
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
        <div class="page_header_default style_one ">
            <div class="parallax_cover">
                <div class="simpleParallax">
                    <img src="themes/kentha/assets/images/page-header-default.jpg" alt="bg_image" class="cover-parallax">
                </div>
            </div>
            <div class="page_header_content">
                <div class="auto-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="banner_title_inner">
                                <div class="title_page">
                                    Proyectos
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="breadcrumbs creote">
                                <ul class="breadcrumb m-auto">
                                    <li><a href="">Home</a></li>
                                    <li class="active">Proyectos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--===============spacing==============-->
        <div class="pd_top_90"></div>
        <!--===============spacing==============-->

        <x-proyectos-area-pagina />

        <!--===============spacing==============-->
        <div class="pd_top_80"></div>



        <x-footer-area />


        <x-modal-area />
    </div>
@endsection
