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
                        <h1>Nombre del Programa</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- courses-details Area Start-->
    <section class="courses-details-area pd-top-135 pd-bottom-130">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-course-wrap mb-0">
                        <div class="thumb">
                            <a class="play-btn" href="#"><i class="fa fa-play"></i></a>
                            <img src="{{ asset('themes/capperu/assets/img/course/video.png') }}" alt="img">
                        </div>
                        <div class="wrap-details">
                            <h5><a href="#">Best way learn fundamentals of design thinking.</a></h5>
                            <p>Learn Python like a Professional Start from the basics and go all the way to creating your own applications and games</p>
                            <div class="user-area">
                                <div class="user-details">
                                    <img src="{{ asset('themes/capperu/assets/img/author/1.png') }}" alt="img">
                                    <a href="#">Jessica Jessy</a>
                                </div>
                                <div class="date ms-auto">
                                    <i class="fa fa-calendar-alt me-2" style="color: var(--main-color);"></i>Last updated 9/2020
                                </div>
                                <div class="ms-auto">
                                    <i class="fa fa-user me-2" style="color: var(--main-color);"></i>5k already enrolled
                                </div>
                                <div class="user-rating">
                                    <span>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-alt"></i>
                                    4.9</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="course-tab nav nav-pills pd-top-100">
                        <li class="nav-item">
                          <button class="nav-link active" id="pill-1" data-bs-toggle="pill" data-bs-target="#pills-01" type="button" role="tab" aria-controls="pills-01" aria-selected="true">Overview</button>
                        </li>
                        <li class="nav-item">
                          <button class="nav-link" id="pill-2" data-bs-toggle="pill" data-bs-target="#pills-02" type="button" role="tab" aria-controls="pills-02" aria-selected="false">Exercise Files</button>
                        </li>
                        <li class="nav-item">
                          <button class="nav-link" id="pill-3" data-bs-toggle="pill" data-bs-target="#pills-03" type="button" role="tab" aria-controls="pills-03" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-01" role="tabpanel" aria-labelledby="pill-1">
                            <div class="overview-area">
                                <h5>Course details</h5>
                                <p>New to web design? Start here first. Instructor James Williamson introduces the fundamental concepts, tools, and learning paths for web design. He explains what it means to be a web designer, the various areas of specialization, and whether web design is the right hobby or career for you. Along the way, he talks to five prominent designers and developers, who have each found success in a different corner of the web.
                                </p>
                                <div class="bg-gray">
                                    <h6>What Will I Learn?
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul>
                                                <li><i class="fa fa-check"></i>Know how to configure Wordpress for best results
                                                </li>
                                                <li><i class="fa fa-check"></i>Understand plugins & themes and how to find/install them</li>
                                                <li><i class="fa fa-check"></i>Protect their Wordpress website from hackers and spammers</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul>
                                                <li><i class="fa fa-check"></i>Create a static homepage useful for most websites, or a blog like homepage useful for bloggers.</li>
                                                <li><i class="fa fa-check"></i>Create an affiliate site for passive, recurring income
                                                </li>
                                                <li><i class="fa fa-check"></i>Create a Responsive Website that looks good on any browser.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <h6>Requirements</h6>
                                <ul>
                                    <li><i class="fa fa-check"></i>No previous experience or software needed!
                                    </li>
                                    <li><i class="fa fa-check"></i>An open mind!</li>
                                </ul>
                                <h6 class="mt-5">Skills covered in this course
                                </h6>
                                <ul>
                                    <li><i class="fa fa-check"></i>This course is great for beginners who are still learning the financial markets.
                                    </li>
                                    <li><i class="fa fa-check"></i>This course is perfect for you if you are taking over an existing Wordpress website, or want to build one from scratch, but don't know where to start.</li>
                                    <li><i class="fa fa-check"></i>If you want to learn to master Wordpress without getting bogged down with technical jargon, this course is for you.
                                    </li>
                                </ul>
                                <div class="reviewers-area">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="media d-flex align-items-center">
                                                <div class="thumb">
                                                    <img src="{{ asset('themes/capperu/assets/img/author/01.png') }}" alt="img">
                                                </div>
                                                <div class="media-body">
                                                    <h6>Jessica Jessy</h6>
                                                    <span>Product Designer</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <p class="review-content">Great for the people that are willing to improve and learn. 
                                                Please show up to the course with an open mind because the instructor got his own views and philosophy 
                                                towards design that might challenge your own. This course will teach you...</p>
                                        </div>
                                    </div>
                                    <div class="meta-area d-flex">
                                        <div class="user-rating ms-0">
                                            <span>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-half-alt"></i>
                                            4.9</span>
                                        </div>
                                        <div class="ms-auto">
                                            <i class="fa fa-user me-2" style="color: var(--main-color);"></i>6794 students
                                        </div>
                                        <div class="ms-md-5 ms-auto mb-0">
                                            <i class="far fa-user me-2" style="color: var(--main-color);"></i>6794 students
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-02" role="tabpanel" aria-labelledby="pill-2">...</div>
                        <div class="tab-pane fade" id="pills-03" role="tabpanel" aria-labelledby="pill-3">...</div>
                    </div>
                </div>
                <div class="col-lg-4 sidebar-area">
                    <div class="widget widget-accordion-inner">
                        <h5 class="widget-title border-0">Course Syllabus</h5>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Introduction
                                </button>
                              </h2>
                              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li>
                                            <a class="play-btn" href="#"><i class="fa fa-play"></i></a>
                                            <span>
                                                <p>Welcome to strategic thinking</p>
                                                <span>1m 24s</span>
                                            </span>
                                        </li>
                                    </ul>                                    
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    1. Setting the Stage for Strategic
                                    Thinking
                                </button>
                              </h2>
                              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li>
                                            <i class="fa fa-lock"></i>
                                            <span>
                                                <p>Embrace the strategic thinking mindset</p>
                                                <span>1m 24s</span>
                                            </span>
                                        </li>
                                        <li>
                                            <i class="fa fa-lock"></i>
                                            <span>
                                                <p>Strategy: Not just for corporations
                                                </p>
                                                <span>1m 24s</span>
                                            </span>
                                        </li>
                                        <li>
                                            <i class="fa fa-lock"></i>
                                            <span>
                                                <p>The sequence of strategy
                                                </p>
                                                <span>1m 24s</span>
                                            </span>
                                        </li>
                                    </ul> 
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    2. Developing Your Strategic Thinking
                                </button>
                              </h2>
                              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul>
                                        <li>
                                            <i class="fa fa-lock"></i>
                                            <span>
                                                <p>Embrace the strategic thinking mindset</p>
                                                <span>1m 24s</span>
                                            </span>
                                        </li>
                                        <li>
                                            <i class="fa fa-lock"></i>
                                            <span>
                                                <p>Strategy: Not just for corporations
                                                </p>
                                                <span>1m 24s</span>
                                            </span>
                                        </li>
                                        <li>
                                            <i class="fa fa-lock"></i>
                                            <span>
                                                <p>The sequence of strategy
                                                </p>
                                                <span>1m 24s</span>
                                            </span>
                                        </li>
                                    </ul> 
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    3. Implementing Strategic Thinking
                                  </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                  <div class="accordion-body">
                                      <ul>
                                          <li>
                                              <i class="fa fa-lock"></i>
                                              <span>
                                                  <p>Embrace the strategic thinking mindset</p>
                                                  <span>1m 24s</span>
                                              </span>
                                          </li>
                                          <li>
                                              <i class="fa fa-lock"></i>
                                              <span>
                                                  <p>Strategy: Not just for corporations
                                                  </p>
                                                  <span>1m 24s</span>
                                              </span>
                                          </li>
                                          <li>
                                              <i class="fa fa-lock"></i>
                                              <span>
                                                  <p>The sequence of strategy
                                                  </p>
                                                  <span>1m 24s</span>
                                              </span>
                                          </li>
                                      </ul> 
                                  </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    4. Collaborating, Sharing, and Exporting
                                  </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                  <div class="accordion-body">
                                      <ul>
                                          <li>
                                              <i class="fa fa-lock"></i>
                                              <span>
                                                  <p>Embrace the strategic thinking mindset</p>
                                                  <span>1m 24s</span>
                                              </span>
                                          </li>
                                          <li>
                                              <i class="fa fa-lock"></i>
                                              <span>
                                                  <p>Strategy: Not just for corporations
                                                  </p>
                                                  <span>1m 24s</span>
                                              </span>
                                          </li>
                                          <li>
                                              <i class="fa fa-lock"></i>
                                              <span>
                                                  <p>The sequence of strategy
                                                  </p>
                                                  <span>1m 24s</span>
                                              </span>
                                          </li>
                                      </ul> 
                                  </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    
                    <div class="price-wrap">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <a class="btn btn-base ms-auto" href="#" style="width: 100%;">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> &nbsp;&nbsp;Agregar al carrito
                                </a>
                            </div>
                            <br><br>
                            <div class="col-md-12">
                                <a class="btn btn-primary" href="#" style="width: 100%;">
                                    <i class="fa fa-cart-plus" aria-hidden="true"></i> 
                                    &nbsp;&nbsp;Comprar Ahora
                                    <b style="text-end"> &nbsp;&nbsp; S/. 250</b>  
                                </a>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="widget widget-course-details mb-0">
                        <h5 class="widget-title">Course Details</h5>
                        <ul>
                            <li>Level: <span>Beginner</span></li>
                            <li>Categories: <span><a href="#">Business</a><a href="#">Design</a><a href="#">Development</a><a href="#">Marketing</a><a href="#">WordPress</a></span></li>
                            <li>Total Hour: <span>07h 30m</span></li>
                            <li>Total Lessons: <span>15</span></li>
                            <li>Total Enrolled: <span>5000</span></li>
                            <li>Last Update: <span>August 23, 2021</span></li>
                        </ul> 
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