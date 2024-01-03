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
                        <h3 style="color: #fff;">
                            {{ $course->description }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- courses-details Area Start-->
    <section class="courses-details-area pd-top-100 pd-bottom-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="single-course-wrap mb-0">
                                <div class="thumb">
                                    {{-- <span class="play-btn"><i class="fa fa-play"></i></span> --}}
                                    <img style="width: 100%; heigth: 210px;" src="{{ $course->image }}" alt="img">
                                </div>
                                <div class="wrap-details">
                                    <h5>{{ $course->description }}</h5>
                                    @if ($course->brochure)
                                        <p>{!! $course->brochure->resolution !!}</p>
                                    @endif
                                    <div class="user-area">
                                        <div class="user-details">
                                            <a href="">
                                                <span style="color:orange;">
                                                    Sector:
                                                </span>
                                                <b>{{ $course->sector_description }}</b>
                                            </a>
                                        </div>
                                        @if ($course->modality)
                                            <div class="user-rating">
                                                <span style="color:orange;">
                                                    <i>Modalidad:</i>
                                                </span>
                                                <b>{{ $item->additional1 }}</b>
                                            </div>
                                        @endif
                                        @if ($course->category)
                                            <div class="user-rating">
                                                <span style="color:orange;">
                                                    <i>Tipo:</i>
                                                </span>
                                                <b>{{ $course->type_description }}</b>
                                            </div> 
                                        @endif
                                        @if ( $item->additional1 != "E-Learning")
                                        <div class="user-rating">
                                            <span style="color:orange;">
                                                <i>Inicio:</i>
                                            </span>
                                            <b>{{ $course->course_day . '/' . $course->course_month . '/' . $course->course_year }}</b>
                                        </div>
                                        @endif                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            @php
                                $agreements = $course->agreements;
                            @endphp
                            @foreach ($agreements as $agreement)
                                <a href="">
                                    <img style="height: 80px;" src="{{ $agreement->institution->image }}" alt="img">
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <ul class="course-tab nav nav-pills pd-top-100">
                            <li class="nav-item">
                                <button class="nav-link active" id="pill-1" data-bs-toggle="pill"
                                    data-bs-target="#pills-01" type="button" role="tab" aria-controls="pills-01"
                                    aria-selected="true">
                                    Presentación <span style="color: orange;">></span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="pill-2" data-bs-toggle="pill" data-bs-target="#pills-02"
                                    type="button" role="tab" aria-controls="pills-02" aria-selected="false">
                                    Beneficios <span style="color: orange;">></span>
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="pill-3" data-bs-toggle="pill" data-bs-target="#pills-03"
                                    type="button" role="tab" aria-controls="pills-03" aria-selected="false">
                                    Plana Docente <span style="color: orange;">></span>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="pill-4" data-bs-toggle="pill" data-bs-target="#pills-04"
                                    type="button" role="tab" aria-controls="pills-04" aria-selected="false">
                                    Preguntas Frecuentes
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-01" role="tabpanel" aria-labelledby="pill-1">
                                @if ($course->brochure)
                                    <div class="overview-area">
                                        {!! $course->brochure->presentation !!}
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="pills-02" role="tabpanel" aria-labelledby="pill-2">
                                @if ($course->brochure)
                                    {!! $course->brochure->benefits !!}
                                @endif
                            </div>
                            <div class="tab-pane fade" id="pills-03" role="tabpanel" aria-labelledby="pill-3">
                                @if (count($course->teachers) > 0)
                                    @foreach ($course->teachers as $teach)
                                        <div class="row" style="margin-bottom: 20px;">
                                            <div class="col-md-2">
                                                <a href="{{ route('web_perfil_docente', 1) }}">
                                                    <img style="width: 90px; margin-bottom: 10px; margin-left: 10px;"
                                                        src="{{ $teach->teacher->person->image }}" alt="img">
                                                </a>
                                            </div>
                                            <div class="col-md-10">
                                                <h6>{{ $teach->teacher->person->father_lastname." ". $teach->teacher->person->mother_lastname." ". $teach->teacher->person->names }}</h6>
                                                @if (count($teach->teacher->person->resumes))
                                                    <ul>
                                                        @foreach ($teach->teacher->person->resumes as $resume)
                                                            <li>
                                                                {{ $resume->description }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="tab-pane fade" id="pills-04" role="tabpanel" aria-labelledby="pill-4">
                                @if ($course->brochure)
                                    {!! $course->brochure->frequent_questions !!}
                                @endif
                            </div>
                        </div>
                    </div>          

                   @if ($item->additional1 == "E-Learning")
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5><b>¿En qué consiste la modalidad de estudios E-Learning?</b></h5>
                                            </div>
                                            <div class="col-md-12">
                                                <h6>ESTA MODALIDAD PERMITE:</h6>
                                                <ul>
                                                    <li>
                                                        Una formación completamente a distancia, donde los alumnos acceden a
                                                        los contenidos, actividades, tareas, tutores del curso, etc.
                                                    </li>
                                                    <li>
                                                        El proceso de aprendizaje se lleve a cabo a través de cualquier dispositivo 
                                                        electrónico. (laptop, Tablet, PC o dispositivo móvil).
                                                    </li>
                                                    <li>
                                                        FLEXIBILIDAD DE ESTUDIO: permite que el estudiante pueda estudiar conforme a su disponibilidad de tiempo y desde el lugar físico que él elija. 
                                                        (las 24 horas y los 7 días de la semana).
                                                    </li>
                                                    <li>
                                                        DISPOSICIÓN DE RECURSOS ON-LINE Y MULTIMEDIA, como PPTS, PDF, formatos en Excel y Word, que forman parte de los estudios.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                   @else
                                    <div class="row">
                                        <div class="reviewers-area">
                                            <div class="meta-area d-flex">
                                                <div class="user-rating ms-0">
                                                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                                    <b>Modalidad de Estudios Mixta</b>
                                                </div>
                                                <div class="ms-auto">
                                                    <i class="fa fa-video" aria-hidden="true"></i>
                                                    Google Meet
                                                </div>
                                                <div class="ms-md-5 ms-auto mb-0">
                                                    <a href="">
                                                        <i class="fa fa-laptop" aria-hidden="true"></i>
                                                        Campus Virtual
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                   @endif


                    <br>
                    <div class="row overview-area">
                        <div class="col-md-12 bg-gray">
                            El alumno obtendrá su diplomado con la siguiente mención:
                            <h5>"{{ $course->description }}"</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 sidebar-area">
                    <div class="widget widget-accordion-inner">
                        <h5 class="widget-title border-0" style="padding: 10px; background-color: #F9FAFD;">Estructura
                            Curricular</h5>
                        <div class="accordion" id="accordionExample">
                            @php
                                $modules = $course->modules;
                                $c = 1;
                            @endphp
                            @foreach ($modules as $k => $module)
                                <div class="accordion-item">
                                    <p style="padding: 5px 15px;">{{ $c . '. ' . $module->description }}</p>
                                </div>
                                @php
                                    $c++;
                                @endphp
                            @endforeach
                        </div>
                    </div>

                    <div class="price-wrap">
                        <div class="row align-items-center" style="padding: 5px 0px;">
                            <div class="col-md-12">
                                <a class="btn btn-primary" href="#" style="width: 100%;" onclick="agregarAlCarrito({ id: {{ $item->id }}, nombre: '{{ $item->name }}', precio: {{ $item->price }} })">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                    &nbsp;&nbsp;Comprar Ahora
                                    <b style="text-end"> &nbsp;&nbsp; S/. {{ $item->price }}</b>
                                </a>
                            </div>
                        </div>
                        <div class="row align-items-center" style="padding: 5px 0px;">
                            <div class="col-md-12">
                                <a class="btn btn-light" href="#" style="width: 100%;">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    &nbsp;&nbsp;Descargar Brochure
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- courses-details Area End -->


    <!-- Más Populares Area Start-->
    <x-capperu.programas-populares-area></x-capperu.programas-populares-area>
    <!-- Más Populares Area End -->



    <x-capperu.footer-area></x-capperu.footer-area>
@endsection
