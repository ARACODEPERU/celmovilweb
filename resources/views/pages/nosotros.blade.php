@extends('layouts.celmovil')
@section('content')
    <!-- Preloader Start
                                                                                                                                                                                        <div class="preloader">
                                                                                                                                                                                            <div class="loading-center">
                                                                                                                                                                                                <div class="loading-center-absolute">
                                                                                                                                                                                                    <div class="object object_one"></div>
                                                                                                                                                                                                    <div class="object object_two"></div>
                                                                                                                                                                                                    <div class="object object_three"></div>
                                                                                                                                                                                                </div>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        </div> -->
    <!-- Preloader End -->

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    
		<!-- page banner area start -->
		<div class="page-banner">
			<img src="{{ asset('themes/celmovil/img/slider/bg2.jpg') }}" alt="Page Banner" />
		</div>
		<!-- page banner area end -->
		<!-- about us section start -->
		<section class="about-area section-padding">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-9 col-md-6">
						<div class="about-img">
							<img src="{{ asset('themes/celmovil/img/nosotros_2024.jpg') }}" alt="" />
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6">
						<div class="about-text" style="padding: 30px 10px 30px 10px;">
							<h3><b>¿QUIÉNES SOMOS?</b></h3>
							<p style="font-size: 16px;">
                                CelMovil vehiculos electricos es una empresa peruana fundada en el 2020, dedicada a la venta
                                de vehículos menores eléctricos a nivel nacional. Socios estratégicos de las marcas
                                mas importantes en el mercado peruano de motos electricas.
                            </p>
                            <br>
                            <p style="font-size: 16px;">
                                CelMovil ofrece una gran variedad de vehículos eléctricos como: bicicletas, VMP's 
                                (vehpiculos de movilidad personal), motos, trimotos, cuatrimotos y cargueros.
                            </p>
                            <br>
                            <p style="font-size: 16px;">
                                La avanzada tecnología de nuestros vehículos hace posible que no utilicen combustible, reduciendo
                                considerablemente los costos para los usuarios y el impacto ambiental.
                            </p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- about us section end -->
		<!-- choose section start -->
		<section class="choose-area">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-6 col-text-center">
						<div class="section-title about-title text-center">
							<h3>POR QUÉ ELEGIRNOS</h3>
							<div class="shape">
								<img src="{{ asset('themes/celmovil/img/icon/t-shape.png') }}" alt="Title Shape" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<img src="{{ asset('themes/celmovil/img/about/bg1.jpg') }}" alt="" />
			<div class="section-padding">
				<div class="container">
					<div class="row">
						<div class="col-sm-4" style="text-align: center;">
							<div class="single-choose">
								<i class="pe-7s-global"></i>
								<h3>Misión</h3>
                                <p>
                                    Promover un nuevo concepto de movilidad en el Perú, a través de la venta
                                    de vehículos menores eléctricos de alta calidad y tecnología. 
                                    Buscamos brindar garantía efectiva de la mano de un adecuado soporte técnico.
                                </p>
                            </div>
						</div>
						<div class="col-sm-4" style="text-align: center;">
							<div class="single-choose">
								<i class="pe-7s-rocket"></i>
								<h3>Visión</h3>
                                <p>
                                    Crear oportunidades a través del uso de vehículos eléctricos y convertimos en la
                                    primera alternativa de movilidad para todos los peruanos.
                                </p>
                            </div>
						</div>
						<div class="col-sm-4" style="text-align: center;">
							<div class="single-choose">
								<i class="pe-7s-like"></i>
								<h3>Valores</h3>
								<p>There are many variati passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- choose section end -->
		<!-- our team section start -->
        <!--
		<div class="our-team section-padding-bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-6 col-text-center">
						<div class="section-title about-title text-center">
							<h3>Our Team</h3>
							<div class="shape">
								<img src="{{ asset('themes/celmovil/img/icon/t-shape.png') }}" alt="Title Shape" />
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-3">
						<div class="single-member">
							<div class="member-img">
								<img src="{{ asset('themes/celmovil/img/about/2.jpg') }}" alt="Team Member" />
								<div class="social-share text-center">
									<div class="link-icon">
										<a href="#"><i class="fa fa-link"></i></a>
									</div>
									<ul class="clearfix">
										<li>
											<a href="#"><i class="fa fa-google"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-facebook"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-twitter"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-behance"></i></a>
										</li>
									</ul>
								</div>
							</div>
							<h4>Tom smith</h4>
							<p>Designer</p>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3">
						<div class="single-member">
							<div class="member-img">
								<img src="{{ asset('themes/celmovil/img/about/3.jpg') }}" alt="Team Member" />
								<div class="social-share text-center">
									<div class="link-icon">
										<a href="#"><i class="fa fa-link"></i></a>
									</div>
									<ul class="clearfix">
										<li>
											<a href="#"><i class="fa fa-google"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-facebook"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-twitter"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-behance"></i></a>
										</li>
									</ul>
								</div>
							</div>
							<h4>Lora Smiytl</h4>
							<p>Designer</p>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3">
						<div class="single-member">
							<div class="member-img">
								<img src="{{ asset('themes/celmovil/img/about/4.jpg') }}" alt="Team Member" />
								<div class="social-share text-center">
									<div class="link-icon">
										<a href="#"><i class="fa fa-link"></i></a>
									</div>
									<ul class="clearfix">
										<li>
											<a href="#"><i class="fa fa-google"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-facebook"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-twitter"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-behance"></i></a>
										</li>
									</ul>
								</div>
							</div>
							<h4>Semuael Samson</h4>
							<p>Designer</p>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3">
						<div class="single-member">
							<div class="member-img">
								<img src="{{ asset('themes/celmovil/img/about/5.jpg') }}" alt="Team Member" />
								<div class="social-share text-center">
									<div class="link-icon">
										<a href="#"><i class="fa fa-link"></i></a>
									</div>
									<ul class="clearfix">
										<li>
											<a href="#"><i class="fa fa-google"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-facebook"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-twitter"></i></a>
										</li>
										<li>
											<a href="#"><i class="fa fa-behance"></i></a>
										</li>
									</ul>
								</div>
							</div>
							<h4>Larena Maya</h4>
							<p>Designer</p>
						</div>
					</div>
				</div>
			</div>
		</div>
        -->
		<!-- our team section end -->

    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
