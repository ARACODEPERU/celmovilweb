@extends('layouts.celmovil')
@section('content')


    <!-- Preloader Start -->
    <div class="preloader">
        <div class="loading-center">
            <div class="loading-center-absolute">
                <div class="object object_one"></div>
                <div class="object object_two"></div>
                <div class="object object_three"></div>
            </div>
        </div>
    </div>
    <!-- Preloader End -->

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <div class="slider-container">
        <div class="slider">
            @foreach ($sliders as $slide)
                <img src="{{ $slide->content }}" alt="Imagen">
            @endforeach
        </div>
        <button class="prev-button">&#10094;</button>
        <button class="next-button">&#10095;</button>
    </div>

    <style>
        .slider-container {
            position: relative;
            max-width: 100%;
            margin-top: 70px;
            overflow: hidden;
            /* Oculta las imágenes fuera del contenedor */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
            /* Transición suave del deslizamiento */
        }

        .slider img {
            width: 100%;
            height: auto;
            flex-shrink: 0;
            /* Impide que las imágenes se encojan */
            display: block;
        }

        .prev-button,
        .next-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 12px;
            cursor: pointer;
            font-size: 24px;
            z-index: 10;
            /* Asegura que los botones estén por encima del slider */
        }

        .prev-button {
            left: 10px;
            border-radius: 50%;
        }

        .next-button {
            right: 10px;
            border-radius: 50%;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.querySelector('.slider');
            const prevButton = document.querySelector('.prev-button');
            const nextButton = document.querySelector('.next-button');
            const images = document.querySelectorAll('.slider img');

            let currentIndex = 0;
            const totalImages = images.length;
            let autoSlideInterval;

            // Función para actualizar la posición del slider
            function updateSlider() {
                const imageWidth = images[0].clientWidth; // Obtener el ancho de la primera imagen
                slider.style.transform = `translateX(${-currentIndex * imageWidth}px)`;
            }

            // Función para avanzar al siguiente slide
            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalImages;
                updateSlider();
            }

            // Función para iniciar el deslizamiento automático
            function startAutoSlide() {
                // Cambiar de imagen cada 3 segundos (3000 milisegundos)
                autoSlideInterval = setInterval(nextSlide, 3000);
            }

            // Función para detener el deslizamiento automático
            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            // Manejador del botón "Siguiente"
            nextButton.addEventListener('click', () => {
                stopAutoSlide(); // Detener el auto-deslizamiento al interactuar
                nextSlide();
                startAutoSlide(); // Reiniciar el auto-deslizamiento después de un clic
            });

            // Manejador del botón "Anterior"
            prevButton.addEventListener('click', () => {
                stopAutoSlide(); // Detener el auto-deslizamiento al interactuar
                currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                updateSlider();
                startAutoSlide(); // Reiniciar el auto-deslizamiento después de un clic
            });

            // Añade soporte para deslizamiento táctil (opcional)
            let startX = 0;
            let endX = 0;

            slider.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                stopAutoSlide(); // Detener al empezar a tocar
            });

            slider.addEventListener('touchend', (e) => {
                endX = e.changedTouches[0].clientX;
                if (startX > endX + 50) {
                    nextSlide();
                } else if (startX < endX - 50) {
                    currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                    updateSlider();
                }
                startAutoSlide(); // Reiniciar al soltar
            });

            // Detener el auto-deslizamiento cuando el cursor está sobre el slider
            slider.addEventListener('mouseenter', stopAutoSlide);
            // Reiniciar el auto-deslizamiento cuando el cursor sale del slider
            slider.addEventListener('mouseleave', startAutoSlide);

            // Se asegura de que el slider se adapte al cambiar el tamaño de la ventana
            window.addEventListener('resize', updateSlider);

            // Iniciar el deslizamiento automático al cargar la página
            startAutoSlide();
        });
    </script>


    <!-- slider - pc - section start -->
    {{-- <div class="slider-area slider-one clearfix view-pc" style="margin-top: 60px;">
        <div class="slider" id="mainslider">
            @foreach ($sliders as $slide)
                <div data-src="{{ $slide->content }}"></div>
            @endforeach
        </div>
    </div> --}}
    <!-- slider - pc - section end -->


    <!-- Tarjetas Catalogo - movil - section end -->
    <section class="view-movil" style="margin-top: 10px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12" style="padding: 15px;">
                    <div class="box-shadow">
                        <a href="https://celmovil.pe/productos/1/list">
                            <img style="width: 100%;" src="{{ $portadas[0]->content }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding: 15px;">
                    <div class="box-shadow">
                        <a href="https://celmovil.pe/productos/2/list">
                            <img style="width: 100%;" src="{{ $portadas[1]->content }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding: 15px;">
                    <div class="box-shadow">
                        <a href="https://celmovil.pe/productos/6/list">
                            <img style="width: 100%;" src="{{ $portadas[2]->content }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding: 15px;">
                    <div class="box-shadow">
                        <a href="https://celmovil.pe/productos/25/list">
                            <img style="width: 100%;" src="{{ $portadas[3]->content }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Tarjetas Catalogo - movil - section end -->


    <!-- feature products - section start -->
    <x-feature-products-area />
    <!-- feature products - section end -->

    <!-- popular-product section start -->
    <x-popular-product-area />
    <!-- popular-product section end -->

    <!-- blog section start
                                        <section class="blog-area blog-two section-padding">
                                                                                    <div class="container">
                                                                                        <div class="row">
                                                                                            <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                                                                                                <div class="section-title text-center">
                                                                                                    <h3><span>FROM</span> BLOG</h3>
                                                                                                    <div class="shape">
                                                                                                        <img src="{{ asset('themes/celmovil/img/icon/t-shape.png') }}" alt="Title Shape" />
                                                                                                    </div>
                                                                                                    <p>It is a long established fact that a reader will be distracted by the readable content of a page
                                                                                                        when looking at its layout.</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <div class="blog-item">
                                                                                                    <div class="blog-img">
                                                                                                        <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/blog/1.jpg') }}" alt="Blog" /></a>
                                                                                                    </div>
                                                                                                    <div class="blog-text clearfix">
                                                                                                        <a href="single-blog.html">
                                                                                                            <h4>Claritas est etiam processus</h4>
                                                                                                        </a>
                                                                                                        <p class="date-com"><span>Rakib Hossain</span> | jan 17 - 2016 | 12 comments</p>
                                                                                                        <hr class="line" />
                                                                                                        <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim
                                                                                                            placerat facer possim assum. </p>
                                                                                                        <div class="view-more">
                                                                                                            <a class="shop-btn" href="single-blog.html">Read More</a>
                                                                                                            <a class="shop-btn" href="#"><i class="fa fa-share-alt"></i></a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <div class="blog-item">
                                                                                                    <div class="blog-img">
                                                                                                        <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/blog/2.jpg') }}" alt="Blog" /></a>
                                                                                                    </div>
                                                                                                    <div class="blog-text clearfix">
                                                                                                        <a href="single-blog.html">
                                                                                                            <h4>Claritas est etiam processus</h4>
                                                                                                        </a>
                                                                                                        <p class="date-com"><span>Rakib Hossain</span> | jan 17 - 2016 | 12 comments</p>
                                                                                                        <hr class="line" />
                                                                                                        <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim
                                                                                                            placerat facer possim assum. </p>
                                                                                                        <div class="view-more">
                                                                                                            <a class="shop-btn" href="single-blog.html">Read More</a>
                                                                                                            <a class="shop-btn" href="#"><i class="fa fa-share-alt"></i></a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-4">
                                                                                                <div class="blog-item">
                                                                                                    <div class="blog-img">
                                                                                                        <a href="product-details.html"><img src="{{ asset('themes/celmovil/img/blog/3.jpg') }}" alt="Blog" /></a>
                                                                                                    </div>
                                                                                                    <div class="blog-text clearfix">
                                                                                                        <a href="single-blog.html">
                                                                                                            <h4>Claritas est etiam processus</h4>
                                                                                                        </a>
                                                                                                        <p class="date-com"><span>Rakib Hossain</span> | jan 17 - 2016 | 12 comments</p>
                                                                                                        <hr class="line" />
                                                                                                        <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim
                                                                                                            placerat facer possim assum. </p>
                                                                                                        <div class="view-more">
                                                                                                            <a class="shop-btn" href="single-blog.html">Read More</a>
                                                                                                            <a class="shop-btn" href="#"><i class="fa fa-share-alt"></i></a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                        </section>-->
    <!-- blog section end -->

    <x-promotional-area />
    

    <!-- Algunos productos - section start -->
    <section style="padding: 120px 0px;">
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-text-center">
                    <div class="section-title text-center">
                        <h1>
                            <span>NUESTROS</span> CLIENTES
                        </h1>
                        <div class="shape">
                        </div>
                        {{-- <p>
                            Hola
                        </p> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-container-3col">
            @foreach ($algunos_modelos as $key => $am)
                <div class="grid-item">
                    <a href="{{ $am->item->items[2]->content }}" style="padding: 15px;">
                        <div class="box-up">
                            <img style="width: 100%;" src="{{ $am->item->items[0]->content }}" alt="">
                            <div style="margin-top: -80px;">
                                <span style="background: #fff; padding: 10px 20px;">
                                    <b style="color: #ff6600;">Módelo:</b> <b>{{ $am->item->items[1]->content }}</b>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            {{-- <div class="grid-item">
                <a href="">
                    <div class="box-up">
                        <img style="width: 100%;" src="{{ asset('themes/celmovil/img/some/Moto.jpg') }}" alt="">
                        <div style="margin-top: -80px;">
                            <span style="background: #fff; padding: 10px 20px;">
                                <b style="color: #ff6600;">Módelo:</b> <b>SUPER HERO</b>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="grid-item">
                <a href="">
                    <div class="box-up">
                        <img style="width: 100%;" src="{{ asset('themes/celmovil/img/some/Moto.jpg') }}" alt="">
                        <div style="margin-top: -80px;">
                            <span style="background: #fff; padding: 10px 20px;">
                                <b style="color: #ff6600;">Módelo:</b> <b>SUPER HERO</b>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="grid-item">
                <a href="">
                    <div class="box-up">
                        <img style="width: 100%;" src="{{ asset('themes/celmovil/img/some/Moto.jpg') }}" alt="">
                        <div style="margin-top: -80px;">
                            <span style="background: #fff; padding: 10px 20px;">
                                <b style="color: #ff6600;">Módelo:</b> <b>SUPER HERO</b>
                            </span>
                        </div>
                    </div>
                </a>
            </div> --}}
        </div>

        <style>
            .grid-container-3col {
                display: grid;
                gap: 10px;
                grid-template-columns: repeat(3, 1fr);
                grid-template-rows: repeat(3, auto);
                width: 100%;
                padding: 20px 40px;
                /* max-width: 600px; */
            }

            .grid-item {
                /* background-color: #007bff; */
                color: black;
                text-align: center;
                padding: 20px;
                border-radius: 5px;
            }

            /* Responsive Design for Mobile */
            @media (max-width: 768px) {
                .grid-container-3col {
                    grid-template-columns: repeat(1, 1fr);
                    grid-template-rows: repeat(1, auto);
                    width: 98%;
                    padding: 5px;
                }

                .grid-item {
                    padding: 40px 10px;
                }
            }
        </style>
    </section>
    <!-- Algunos productos - section end -->

    <section class="section-testimonio">
        <div class="testimonios">
            <div class="card">
                <img src="{{ asset('themes/celmovil/img/bryan.png') }}" alt=""
                    style="padding: 20px 20px 0px 20px; width: 100px;">
                <div class="contenido">
                    <p>"Un servicio de calidad , compré mi moto aquí y siempre han estado predispuestos a brindarme un buen
                        servicio técnico."</p>
                    <div class="autor">- Bryan Riveros Gamboa</div>
                </div>
            </div>
            <div class="card">
                <img src="https://lh3.googleusercontent.com/a-/ALV-UjWrP8kPYd6GPZZ4nsM-tPcfo2Yk3BV1YtWKoaIb8SusYvym9gk=w45-h45-p-rp-mo-br100"
                    alt="" style="padding: 20px 20px 0px 20px; width: 100px;">
                <div class="contenido">
                    <p>"Tengo una bicimoto eléctrica que siempre llevo a cel movil para mantenimiento y recibo una excelente
                        atención. Estoy muy contenta y satisfecha con la atención brindada"</p>
                    <div class="autor">- Edith Genoveva Reyna Dominguez</div>
                </div>
            </div>
            <div class="card">
                <img src="https://lh3.googleusercontent.com/a-/ALV-UjUKozGV7NjT6onElaBNoR4_uo-3ygyADfK1d5RCcB0o3LJ55ua5=w75-h75-p-rp-mo-br100"
                    alt="" style="padding: 20px 20px 0px 20px; width: 100px;">
                <div class="contenido">
                    <p>"Brindan un buen servicio, y a tiempo, 100% recomendando!"</p>
                    <div class="autor">- Miguel Arce Falla</div>
                </div>
            </div>
            <div class="card">
                <img src="https://lh3.googleusercontent.com/a-/ALV-UjUdhAitM-fTfiD9__kkZ-zlT7jO6PMROzM-o2nljSgGctdwc5vw=w75-h75-p-rp-mo-br100"
                    alt="" style="padding: 20px 20px 0px 20px; width: 100px;">
                <div class="contenido">
                    <p>"Excelente atención y Servicio, Cumplen con la garantía y los Cuatro mantenimientos en el 1 año. Ya
                        llevo un ño con la moto y todo marcha bien y espero que siga asi"</p>
                    <div class="autor">- Lenin Garcia</div>
                </div>
            </div>
            <div class="card">
                <img src="https://lh3.googleusercontent.com/a-/ALV-UjVrRiF_x6AA9yUKz2mwA1W8twCXc5xSAB7KQ0rWtvvkbZj9xPVEPw=w75-h75-p-rp-mo-br100"
                    alt="" style="padding: 20px 20px 0px 20px; width: 100px;">
                <div class="contenido">
                    <p>"El mejor en motos eléctricas! Además que brindan servicio especializado para el mantenimiento de
                        estas. Saludos!"</p>
                    <div class="autor">- Diego Ruiz</div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .section-testimonio {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 90px 0px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            background: linear-gradient(150deg, #c91003, #ff6600);
        }

        .testimonios {
            max-width: 90%;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            /* background: white; */
            /* border-radius: 12px;
                                            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); */
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .imagen {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 4px solid #ff6600;
        }

        .contenido {
            padding: 20px;
        }

        .contenido p {
            margin: 0;
            /* font-size: 1rem; */
            color: #555;
            line-height: 1.5;
        }

        .autor {
            margin-top: 10px;
            font-weight: bold;
            text-align: right;
            color: #ff6600;
        }

        @media (max-width: 600px) {
            .testimonios {
                padding: 10px;
            }

            .contenido {
                padding: 15px;
            }

            .imagen {
                height: 150px;
                /* Ajuste de altura para pantallas pequeñas */
            }
        }
    </style>

    <!-- contact area start -->
    <div class="map-contact clearfix" style="padding: 120px 80px;">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                <div class="section-title text-center">
                    <h1><span>{{ $ofprincipal[0]->content }}</span> {{ $ofprincipal[1]->content }}</h1>
                    <div class="shape">
                    </div>
                    <p>
                        {{ $ofprincipal[2]->content }}<br>
                        <b>{{ $ofprincipal[3]->content }}</b>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 half-width">
                <img style="width: 100%;" src="{{ $ofprincipal[4]->content }}" alt="">
                <div class="ubicacion" style="padding: 14px 15px; background: #ff6600; color: #fff; text-align:center; ">
                    <b style="font-size: 16px;">{{ $ofprincipal[5]->content }} </b>
                </div>
            </div>
            <div class="col-md-6 googleMap-info half-width">
                {!! $ofprincipal[6]->content !!}
            </div>
        </div>
    </div>
    <!-- contact area end -->
    <x-footer-area />
    <!-- footer - section end -->

    <style>
        .scroll-reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease-out;
        }
        .scroll-reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                    } else {
                        entry.target.classList.remove("visible");
                    }
                });
            }, {
                threshold: 0.1
            });

            const elementsToAnimate = document.querySelectorAll("section, .slider-container, .grid-item, .card, .map-contact");
            elementsToAnimate.forEach((el) => {
                el.classList.add("scroll-reveal");
                observer.observe(el);
            });
        });
    </script>
@stop
