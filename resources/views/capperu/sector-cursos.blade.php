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
                        <h1>Cursos Especializados en Sector Empresarial</h1>
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
                        <li class="nav-item">
                            <button class="nav-link" id="pill-3" data-bs-toggle="pill" data-bs-target="#pills-03" type="button" role="tab" aria-controls="pills-03" aria-selected="false">Presencial</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-01" role="tabpanel" aria-labelledby="pill-1">
                            <div class="row">
                                

                               
                                @foreach ($programs as $program)
                                    @if ($program->additional1 == "E-Learning")
                                        <div class="col-md-3">
                                            <div class="single-course-wrap">
                                                <div class="thumb">
                                                    <a href="#" class="cat cat-blue">{{ $program->additional }}</a>
                                                    <img style="height: 140px; object-fit: cover;" src="{{ $program->image }}" alt="img">
                                                </div>
                                                <div class="wrap-details">
                                                    <h6><a class="texto-oculto2" href="{{ route('web_descripcion_programa', $program->id) }}">{{ $program->name }}</a></h6>
                                                    <div class="user-area">
                                                        <div class="user-details">
                                                            <img style="width: 30px; height: 30px; border-radius: 50%;" src="{{ $program->avatar }}" alt="img">
                                                            <a href="{{ route('web_perfil_docente', $program->teacher_id) }}">{{ $program->teacher }}</a>
                                                        </div>
                                                        <div class="user-rating">
                                                                    @if ( $program->category_description=="Empresarial")
                                                                    <span title="Empresarial">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ff8000}</style><path d="M64 32C46.3 32 32 46.3 32 64V304v48 80c0 26.5 21.5 48 48 48H496c26.5 0 48-21.5 48-48V304 152.2c0-18.2-19.4-29.7-35.4-21.1L352 215.4V152.2c0-18.2-19.4-29.7-35.4-21.1L160 215.4V64c0-17.7-14.3-32-32-32H64z"/></svg>
                                                                    </span>
                                                                    @elseif ($program->category_description=="Derecho")
                                                                    <span title="Derecho">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ff8000}</style><path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                                                                    </span>
                                                                    @elseif ($program->category_description=="Publico")
                                                                    <span title="Público">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ff8000}</style><path d="M384 32H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H398.4c-5.2 25.8-22.9 47.1-46.4 57.3V448H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H320 128c-17.7 0-32-14.3-32-32s14.3-32 32-32H288V153.3c-23.5-10.3-41.2-31.6-46.4-57.3H128c-17.7 0-32-14.3-32-32s14.3-32 32-32H256c14.6-19.4 37.8-32 64-32s49.4 12.6 64 32zm55.6 288H584.4L512 195.8 439.6 320zM512 416c-62.9 0-115.2-34-126-78.9c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8l95.2 163.2c5.7 9.8 9.3 21.1 6.7 32.1C627.2 382 574.9 416 512 416zM126.8 195.8L54.4 320H199.3L126.8 195.8zM.9 337.1c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8l95.2 163.2c5.7 9.8 9.3 21.1 6.7 32.1C242 382 189.7 416 126.8 416S11.7 382 .9 337.1z"/></svg>
                                                                    </span>
                                                                    @else
                                                                    <span></span>
                                                                    @endif
                                                        </div>
                                                    </div>
                                                    <div class="price-wrap">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-12">
                                                                <a href="#" class="btn btn-primary" onclick="agregarAlCarrito({ id: {{ $program->id }}, nombre: '{{ $program->name }}', precio: {{ $program->price }} })">
                                                                    <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                                    Comprar Ahora
                                                                    <b style="text-end"> S/. {{ $program->price }}</b>  
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                                
                            </div>
                            {{-- <div class="row">
                                <div class="col-lg-12 text-center">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                        <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div> --}}
                        </div>

                        <div class="tab-pane fade" id="pills-02" role="tabpanel" aria-labelledby="pill-2">
                            <div class="row">
                                
                                

                                @foreach ($programs as $program)
                                    @if ($program->additional1 == "En Vivo")
                                        <div class="col-md-3">
                                            <div class="single-course-wrap">
                                                <div class="thumb">
                                                    <a href="#" class="cat cat-blue">{{ $program->additional }}</a>
                                                    <img style="height: 140px; object-fit: cover;" src="{{ $program->image }}" alt="img">
                                                </div>
                                                <div class="wrap-details">
                                                    <h6><a class="texto-oculto2" href="{{ route('web_descripcion_programa', $program->id) }}">{{ $program->name }}</a></h6>
                                                    <div class="user-area">
                                                        <div class="user-details">
                                                            <img style="width: 30px; height: 30px; border-radius: 50%;" src="{{ $program->avatar }}" alt="img">
                                                            <a href="{{ route('web_perfil_docente', $program->teacher_id) }}">{{ $program->teacher }}</a>
                                                        </div>
                                                        <div class="user-rating">
                                                                    @if ( $program->category_description=="Empresarial")
                                                                    <span title="Empresarial">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ff8000}</style><path d="M64 32C46.3 32 32 46.3 32 64V304v48 80c0 26.5 21.5 48 48 48H496c26.5 0 48-21.5 48-48V304 152.2c0-18.2-19.4-29.7-35.4-21.1L352 215.4V152.2c0-18.2-19.4-29.7-35.4-21.1L160 215.4V64c0-17.7-14.3-32-32-32H64z"/></svg>
                                                                    </span>
                                                                    @elseif ($program->category_description=="Derecho")
                                                                    <span title="Derecho">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ff8000}</style><path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                                                                    </span>
                                                                    @elseif ($program->category_description=="Publico")
                                                                    <span title="Público">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ff8000}</style><path d="M384 32H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H398.4c-5.2 25.8-22.9 47.1-46.4 57.3V448H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H320 128c-17.7 0-32-14.3-32-32s14.3-32 32-32H288V153.3c-23.5-10.3-41.2-31.6-46.4-57.3H128c-17.7 0-32-14.3-32-32s14.3-32 32-32H256c14.6-19.4 37.8-32 64-32s49.4 12.6 64 32zm55.6 288H584.4L512 195.8 439.6 320zM512 416c-62.9 0-115.2-34-126-78.9c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8l95.2 163.2c5.7 9.8 9.3 21.1 6.7 32.1C627.2 382 574.9 416 512 416zM126.8 195.8L54.4 320H199.3L126.8 195.8zM.9 337.1c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8l95.2 163.2c5.7 9.8 9.3 21.1 6.7 32.1C242 382 189.7 416 126.8 416S11.7 382 .9 337.1z"/></svg>
                                                                    </span>
                                                                    @else
                                                                    <span></span>
                                                                    @endif
                                                        </div>
                                                    </div>
                                                    <div class="price-wrap">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-12">
                                                                <a href="#" class="btn btn-primary" onclick="agregarAlCarrito({ id: {{ $program->id }}, nombre: '{{ $program->name }}', precio: {{ $program->price }} })">
                                                                    <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                                    Comprar Ahora
                                                                    <b style="text-end"> S/. {{ $program->price }}</b>  
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                            </div>
                            {{-- <div class="row">
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
                            </div> --}}
                        </div>

                        <div class="tab-pane fade" id="pills-03" role="tabpanel" aria-labelledby="pill-3">
                            <div class="row">
                                

                                @foreach ($programs as $program)
                                    @if ($program->additional1 == "Presencial")
                                        <div class="col-md-3">
                                            <div class="single-course-wrap">
                                                <div class="thumb">
                                                    <a href="#" class="cat cat-blue">{{ $program->additional }}</a>
                                                    <img style="height: 140px; object-fit: cover;" src="{{ $program->image }}" alt="img">
                                                </div>
                                                <div class="wrap-details">
                                                    <h6><a class="texto-oculto2" href="{{ route('web_descripcion_programa', $program->id) }}">{{ $program->name }}</a></h6>
                                                    <div class="user-area">
                                                        <div class="user-details">
                                                            <img style="width: 30px; height: 30px; border-radius: 50%;" src="{{ $program->avatar }}" alt="img">
                                                            <a href="{{ route('web_perfil_docente', $program->teacher_id) }}">{{ $program->teacher }}</a>
                                                        </div>
                                                        <div class="user-rating">                                                            
                                                                @if ( $program->category_description=="Empresarial")
                                                                <span title="Empresarial">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ff8000}</style><path d="M64 32C46.3 32 32 46.3 32 64V304v48 80c0 26.5 21.5 48 48 48H496c26.5 0 48-21.5 48-48V304 152.2c0-18.2-19.4-29.7-35.4-21.1L352 215.4V152.2c0-18.2-19.4-29.7-35.4-21.1L160 215.4V64c0-17.7-14.3-32-32-32H64z"/></svg>
                                                                </span>
                                                                @elseif ($program->category_description=="Derecho")
                                                                <span title="Derecho">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ff8000}</style><path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                                                                </span>
                                                                @elseif ($program->category_description=="Publico")
                                                                <span title="Público">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ff8000}</style><path d="M384 32H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H398.4c-5.2 25.8-22.9 47.1-46.4 57.3V448H512c17.7 0 32 14.3 32 32s-14.3 32-32 32H320 128c-17.7 0-32-14.3-32-32s14.3-32 32-32H288V153.3c-23.5-10.3-41.2-31.6-46.4-57.3H128c-17.7 0-32-14.3-32-32s14.3-32 32-32H256c14.6-19.4 37.8-32 64-32s49.4 12.6 64 32zm55.6 288H584.4L512 195.8 439.6 320zM512 416c-62.9 0-115.2-34-126-78.9c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8l95.2 163.2c5.7 9.8 9.3 21.1 6.7 32.1C627.2 382 574.9 416 512 416zM126.8 195.8L54.4 320H199.3L126.8 195.8zM.9 337.1c-2.6-11 1-22.3 6.7-32.1l95.2-163.2c5-8.6 14.2-13.8 24.1-13.8s19.1 5.3 24.1 13.8l95.2 163.2c5.7 9.8 9.3 21.1 6.7 32.1C242 382 189.7 416 126.8 416S11.7 382 .9 337.1z"/></svg>
                                                                </span>
                                                                @else
                                                                <span></span>
                                                                @endif
                                                        </div>
                                                    </div>
                                                    <div class="price-wrap">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-12">
                                                                <a href="#" class="btn btn-primary" onclick="agregarAlCarrito({ id: {{ $program->id }}, nombre: '{{ $program->name }}', precio: {{ $program->price }} })">
                                                                    <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                                                    Comprar Ahora
                                                                    <b style="text-end"> S/. {{ $program->price }}</b>  
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                
                                
                            </div>
                            {{-- PAGINACION  NO HABILITADA POR AHORA     <div class="row">
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
                            </div> --}}
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