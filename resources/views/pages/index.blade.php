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

    <!-- Slider Section Start -->
    <div class="slider-container">
        <div class="slider">
            @foreach ($sliders as $key => $slide)
                <div class="slide">
                    <img src="{{ $slide->content }}" alt="Promoción Celmovil {{ $key + 1 }}">
                </div>
            @endforeach
        </div>
        <button class="slider-button prev" aria-label="Anterior">&#10094;</button>
        <button class="slider-button next" aria-label="Siguiente">&#10095;</button>
        <div class="slider-pagination"></div>
    </div>

    <style>
        .slider-container {
            position: relative;
            width: 100%;
            margin-top: 75px; /* Espacio para el header fijo (35px top-bar + 80px main-header) */
            overflow: hidden; 
            background-color: #e0e0e0; /* Color de fondo mientras carga la imagen */
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.3); /* Efecto de sombreado inferior */
            z-index: 1;
        }

        @media (max-width: 768px) {
            .slider-container {
                margin-top: 80px; /* En móvil, solo el header principal es visible */
            }
        }

        .slider {
            display: flex;
            /* La altura se adaptará al contenido */
            transition: transform 0.7s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .slide {
            min-width: 100%;
            position: relative;
        }

        .slide img {
            width: 100%;
            height: auto;
            /* La altura se ajusta automáticamente para mantener la proporción */
            display: block;
        }

        .slider-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 20px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s, transform 0.3s;
        }

        .slider-button:hover {
            background-color: var(--primary-color, #ff6600);
            transform: translateY(-50%) scale(1.1);
        }

        .slider-button.prev { left: 15px; }
        .slider-button.next { right: 15px; }

        .slider-pagination {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .pagination-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .pagination-dot.active {
            background-color: white;
            transform: scale(1.2);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.querySelector('.slider');
            if (!slider) return;

            const slides = document.querySelectorAll('.slide');
            const prevButton = document.querySelector('.slider-button.prev');
            const nextButton = document.querySelector('.slider-button.next');
            const paginationContainer = document.querySelector('.slider-pagination');
            
            if (slides.length === 0) return;

            const totalSlides = slides.length;
            let currentIndex = 0;
            let autoSlideInterval;

            // Crear puntos de paginación
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('div');
                dot.classList.add('pagination-dot');
                dot.addEventListener('click', () => {
                    goToSlide(i);
                });
                paginationContainer.appendChild(dot);
            }
            const dots = document.querySelectorAll('.pagination-dot');

            function goToSlide(slideIndex) {
                currentIndex = slideIndex;
                slider.style.transform = `translateX(-${currentIndex * 100}%)`;
                updatePagination();
                resetAutoSlide();
            }

            function updatePagination() {
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentIndex);
                });
            }

            function moveSlide(direction) {
                currentIndex = (currentIndex + direction + totalSlides) % totalSlides;
                goToSlide(currentIndex);
            }

            function startAutoSlide() {
                autoSlideInterval = setInterval(() => moveSlide(1), 4000);
            }

            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            function resetAutoSlide() {
                stopAutoSlide();
                startAutoSlide();
            }

            nextButton.addEventListener('click', () => moveSlide(1));
            prevButton.addEventListener('click', () => moveSlide(-1));

            // Iniciar
            goToSlide(0);
        });
    </script>
    <!-- Slider Section End -->

    <!-- Tarjetas Catalogo - Responsive Grid - section start -->
    <section class="promotional-banners section-padding">
        <div class="container">
            <div class="categories-grid">
                <a href="https://celmovil.pe/productos/1/list" class="category-card hover-effect">
                    <img src="{{ $portadas[0]->content }}" alt="Scooters">
                    <div class="category-overlay">
                        <h3>Scooters</h3>
                        <span>Ver Modelos <i class="fa fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://celmovil.pe/productos/2/list" class="category-card hover-effect">
                    <img src="{{ $portadas[1]->content }}" alt="Bicimotos">
                    <div class="category-overlay">
                        <h3>Bicimotos</h3>
                        <span>Ver Modelos <i class="fa fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://celmovil.pe/productos/6/list" class="category-card hover-effect">
                    <img src="{{ $portadas[2]->content }}" alt="Motos Eléctricas">
                    <div class="category-overlay">
                        <h3>Motos Eléctricas</h3>
                        <span>Ver Modelos <i class="fa fa-arrow-right"></i></span>
                    </div>
                </a>
                <a href="https://celmovil.pe/productos/3/list" class="category-card hover-effect">
                    <img src="{{ $portadas[3]->content }}" alt="Accesorios">
                    <div class="category-overlay">
                        <h3>Accesorios</h3>
                        <span>Ver Catálogo <i class="fa fa-arrow-right"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <style>
        
        body.dark .section-padding {
            background-color: #111827;
        }
        .section-padding {
            padding: 60px 0;
        }
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .category-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            display: block;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .category-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .category-card:hover img {
            transform: scale(1.1);
        }
        .category-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            padding: 20px;
            color: white;
        }
        .category-overlay h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .category-overlay span {
            font-size: 0.9rem;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px;
        }
    </style>
    <!-- Tarjetas Catalogo - section end -->


    <!-- feature products - section start -->
    <x-feature-products-area />
    <!-- feature products - section end -->

    <!-- popular-product section start -->
    <x-popular-product-area />
    <!-- popular-product section end -->

    <x-promotional-area />
    

    <!-- Algunos productos - section start -->
    <section class="featured-models-modern section-padding">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h1 class="modern-title">MODELOS <span>DESTACADOS</span></h1>
                <div class="title-line"></div>
            </div>
            
            <div class="models-grid">
                @foreach ($algunos_modelos as $key => $am)
                    <div class="model-card">
                        <a href="{{ $am->item->items[2]->content }}" class="model-link">
                            <div class="model-image-box">
                                <img src="{{ $am->item->items[0]->content }}" alt="{{ $am->item->items[1]->content }}" loading="lazy">
                                <div class="model-overlay">
                                    <span class="btn-view-model">Ver Detalles</span>
                                </div>
                            </div>
                            <div class="model-info">
                                <span class="model-badge">Modelo Destacado</span>
                                <h3 class="model-name">{{ $am->item->items[1]->content }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <style>
            /* Title Styles */
            .modern-title {
                font-size: 2.5rem;
                font-weight: 800;
                margin-bottom: 10px;
                color: #1f2937;
            }
            .modern-title span {
                color: var(--primary-color, #ff6600);
            }
            body.dark .modern-title {
                color: #ffffff;
            }
            .title-line {
                width: 80px;
                height: 4px;
                background: var(--primary-color, #ff6600);
                margin: 0 auto 40px;
                border-radius: 2px;
            }

            /* Section Styles */
            .featured-models-modern {
                position: relative;
                background-color: #ffffff;
            }
            body.dark .featured-models-modern {
                background-color: #111827;
            }

            .models-grid {
                display: grid;
                grid-template-columns: repeat(1, 1fr);
                gap: 30px;
            }

            @media (min-width: 768px) {
                .models-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            @media (min-width: 1024px) {
                .models-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }

            .model-card {
                background: #ffffff;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 10px 25px rgba(0,0,0,0.05);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border: 1px solid #f3f4f6;
                position: relative;
            }
            body.dark .model-card {
                background: #1f2937;
                border-color: #374151;
            }

            .model-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
                border-color: var(--primary-color, #ff6600);
            }

            .model-link {
                text-decoration: none;
                color: inherit;
                display: block;
                height: 100%;
            }

            .model-image-box {
                position: relative;
                height: 400px;
                background: #f9fafb;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                padding: 20px;
            }
            body.dark .model-image-box {
                background: #1f2937;
            }

            .model-image-box img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                transition: transform 0.5s ease;
                z-index: 1;
            }
            body.dark .model-image-box img {
                filter: brightness(0.9);
            }

            .model-card:hover .model-image-box img {
                transform: scale(1.1);
            }

            .model-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.4);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
                z-index: 2;
            }

            .model-card:hover .model-overlay {
                opacity: 1;
            }

            .btn-view-model {
                background: white;
                color: var(--primary-color, #ff6600);
                padding: 10px 25px;
                border-radius: 30px;
                font-weight: 700;
                transform: translateY(20px);
                transition: transform 0.3s ease;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            }

            .model-card:hover .btn-view-model {
                transform: translateY(0);
            }

            .model-info {
                padding: 25px;
                text-align: center;
            }

            .model-badge {
                display: inline-block;
                font-size: 1.2rem;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #9ca3af;
                margin-bottom: 8px;
                font-weight: 600;
            }
            body.dark .model-badge {
                color: #6b7280;
            }

            .model-name {
                font-size: 2.25rem;
                font-weight: 700;
                color: #1f2937;
                margin: 0;
                line-height: 1.4;
            }
            body.dark .model-name {
                color: #f3f4f6;
            }

            .model-card:hover .model-name {
                color: var(--primary-color, #ff6600);
            }
        </style>
    </section>
    <!-- Algunos productos - section end -->

    <section class="section-testimonio">
        <div class="testimonial-slider-container">
            <button class="testi-nav prev-btn">&#10094;</button>
            <div class="testimonial-viewport">
                <div class="testimonios-track" id="dynamic-testimonials">
                    <!-- Se cargará dinámicamente -->
                </div>
            </div>
            <button class="testi-nav next-btn">&#10095;</button>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const testimonialsData = [
                { author: "Bryan Riveros Gamboa", content: "Un servicio de calidad, compré mi moto aquí y siempre han estado predispuestos a brindarme un buen servicio técnico.", img: "{{ asset('themes/celmovil/img/bryan.png') }}" },
                { author: "Edith Genoveva Reyna", content: "Tengo una bicimoto eléctrica que siempre llevo a cel movil para mantenimiento y recibo una excelente atención.", img: "https://lh3.googleusercontent.com/a-/ALV-UjWrP8kPYd6GPZZ4nsM-tPcfo2Yk3BV1YtWKoaIb8SusYvym9gk=w45-h45-p-rp-mo-br100" },
                { author: "Miguel Arce Falla", content: "Brindan un buen servicio, y a tiempo, 100% recomendando!", img: "https://lh3.googleusercontent.com/a-/ALV-UjUKozGV7NjT6onElaBNoR4_uo-3ygyADfK1d5RCcB0o3LJ55ua5=w75-h75-p-rp-mo-br100" },
                { author: "Lenin Garcia", content: "Excelente atención y Servicio, Cumplen con la garantía y los mantenimientos. Todo marcha bien.", img: "https://lh3.googleusercontent.com/a-/ALV-UjUdhAitM-fTfiD9__kkZ-zlT7jO6PMROzM-o2nljSgGctdwc5vw=w75-h75-p-rp-mo-br100" },
                { author: "Diego Ruiz", content: "El mejor en motos eléctricas! Además que brindan servicio especializado para el mantenimiento.", img: "https://lh3.googleusercontent.com/a-/ALV-UjVrRiF_x6AA9yUKz2mwA1W8twCXc5xSAB7KQ0rWtvvkbZj9xPVEPw=w75-h75-p-rp-mo-br100" },
                { author: "Carlos Mendoza", content: "Muy buena experiencia de compra, el personal muy atento y conocedor del tema.", img: "https://randomuser.me/api/portraits/men/32.jpg" },
                { author: "Ana María López", content: "Me encantó mi nueva scooter, llegó a tiempo y en perfectas condiciones.", img: "https://randomuser.me/api/portraits/women/44.jpg" },
                { author: "Jorge Luis Torres", content: "Servicio técnico rápido y eficiente. Solucionaron mi problema en el día.", img: "https://randomuser.me/api/portraits/men/45.jpg" },
                { author: "Sofía Castro", content: "Gran variedad de modelos y precios accesibles. Recomendado.", img: "https://randomuser.me/api/portraits/women/65.jpg" },
                { author: "Pedro Castillo", content: "La atención post-venta es lo mejor, siempre atentos a cualquier consulta.", img: "https://randomuser.me/api/portraits/men/22.jpg" },
                { author: "Lucía Fernández", content: "Compré repuestos para mi moto y son de muy buena calidad.", img: "https://randomuser.me/api/portraits/women/33.jpg" },
                { author: "Ricardo Morales", content: "Profesionales en movilidad eléctrica, me asesoraron muy bien.", img: "https://randomuser.me/api/portraits/men/11.jpg" },
                { author: "Valeria Guzman", content: "Estoy feliz con mi compra, la moto eléctrica es súper económica.", img: "https://randomuser.me/api/portraits/women/22.jpg" },
                { author: "Fernando Rios", content: "Trato amable y cordial. Definitivamente volveré.", img: "https://randomuser.me/api/portraits/men/67.jpg" },
                { author: "Gabriela Silva", content: "El mantenimiento preventivo dejó mi bicimoto como nueva.", img: "https://randomuser.me/api/portraits/women/11.jpg" },
                { author: "Andrés Vargas", content: "Buenos precios y facilidades de pago. Muy satisfecho.", img: "https://randomuser.me/api/portraits/men/54.jpg" },
                { author: "Patricia Rojas", content: "Me explicaron todo el funcionamiento con paciencia. Gracias!", img: "https://randomuser.me/api/portraits/women/55.jpg" },
                { author: "Manuel Chavez", content: "Rapidez en la entrega y producto tal cual la descripción.", img: "https://randomuser.me/api/portraits/men/33.jpg" },
                { author: "Rosa Martinez", content: "Excelente servicio, muy confiables.", img: "https://randomuser.me/api/portraits/women/66.jpg" },
                { author: "Javier Espinoza", content: "La mejor tienda de motos eléctricas de la zona.", img: "https://randomuser.me/api/portraits/men/12.jpg" },
                { author: "Carmen Vega", content: "Atención A1, resolvieron todas mis dudas antes de comprar.", img: "https://randomuser.me/api/portraits/women/77.jpg" },
                { author: "Roberto Nuñez", content: "Calidad garantizada, mi moto tiene un año y va perfecto.", img: "https://randomuser.me/api/portraits/men/76.jpg" },
                { author: "Elena Cruz", content: "Muy contenta con el servicio, son muy profesionales.", img: "https://randomuser.me/api/portraits/women/88.jpg" },
                { author: "Daniel Flores", content: "Recomiendo Celmovil por su seriedad y compromiso.", img: "https://randomuser.me/api/portraits/men/88.jpg" },
                { author: "Isabel Pardo", content: "Gran stock de accesorios, encontré justo lo que buscaba.", img: "https://randomuser.me/api/portraits/women/99.jpg" },
                { author: "Hector Salinas", content: "Eficiencia y buen trato, sigan así.", img: "https://randomuser.me/api/portraits/men/90.jpg" },
                { author: "Natalia Cabrera", content: "Me encanta mi moto, gracias por la recomendación.", img: "https://randomuser.me/api/portraits/women/12.jpg" },
                { author: "Oscar Paredes", content: "Servicio técnico especializado de verdad.", img: "https://randomuser.me/api/portraits/men/29.jpg" },
                { author: "Silvia Navarro", content: "Todo el proceso de compra fue muy sencillo y rápido.", img: "https://randomuser.me/api/portraits/women/23.jpg" },
                { author: "Raul Jimenez", content: "Excelente atención, muy recomendados.", img: "https://randomuser.me/api/portraits/men/15.jpg" }
            ];

            // Mezclar aleatoriamente al inicio
            testimonialsData.sort(() => 0.5 - Math.random());

            function getAvatar(name, img) {
                if (img && img.trim() !== "") return img;
                return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random&color=fff&size=100`;
            }

            const track = document.getElementById('dynamic-testimonials');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            let currentIndex = 0;
            let autoSlideInterval;

            function initCarousel() {
                let html = '';
                testimonialsData.forEach(t => {
                    const avatar = getAvatar(t.author, t.img);
                    html += `
                        <div class="card-wrapper">
                            <div class="card">
                                <img src="${avatar}" alt="${t.author}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin: 20px auto 0 auto; display: block;">
                                <div class="contenido">
                                    <p>"${t.content}"</p>
                                    <div class="autor">- ${t.author}</div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                track.innerHTML = html;
                updateCarousel();
                startAutoSlide();
            }

            function getVisibleCards() {
                if (window.innerWidth < 768) return 1;
                if (window.innerWidth < 1024) return 2;
                return 3;
            }

            function updateCarousel() {
                const visibleCards = getVisibleCards();
                const percentage = 100 / visibleCards;
                track.style.transform = `translateX(-${currentIndex * percentage}%)`;
            }

            function moveSlide(direction) {
                const visibleCards = getVisibleCards();
                const maxIndex = testimonialsData.length - visibleCards;
                
                currentIndex += direction;
                
                if (currentIndex < 0) {
                    currentIndex = maxIndex;
                } else if (currentIndex > maxIndex) {
                    currentIndex = 0;
                }
                
                updateCarousel();
            }

            function startAutoSlide() {
                stopAutoSlide();
                autoSlideInterval = setInterval(() => moveSlide(1), 4000);
            }

            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            prevBtn.addEventListener('click', () => {
                moveSlide(-1);
                startAutoSlide();
            });

            nextBtn.addEventListener('click', () => {
                moveSlide(1);
                startAutoSlide();
            });

            // Pausar al pasar el mouse
            track.addEventListener('mouseenter', stopAutoSlide);
            track.addEventListener('mouseleave', startAutoSlide);

            // Ajustar al redimensionar
            window.addEventListener('resize', () => {
                // Asegurar que el índice no exceda el máximo permitido al cambiar tamaño
                const visibleCards = getVisibleCards();
                const maxIndex = testimonialsData.length - visibleCards;
                if (currentIndex > maxIndex) currentIndex = maxIndex;
                updateCarousel();
            });

            initCarousel();
        });
    </script>

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

        .testimonial-slider-container {
            width: 90%;
            max-width: 1200px;
            position: relative;
            display: flex;
            align-items: center;
        }

        .testimonial-viewport {
            overflow: hidden;
            width: 100%;
            padding: 20px 0; /* Espacio para la sombra de las tarjetas */
        }

        .testimonios-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
        }

        .card-wrapper {
            flex: 0 0 33.333%;
            padding: 0 15px;
            box-sizing: border-box;
        }

        @media (max-width: 1024px) {
            .card-wrapper {
                flex: 0 0 50%;
            }
        }

        @media (max-width: 768px) {
            .card-wrapper {
                flex: 0 0 100%;
            }
        }

        .testi-nav {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            z-index: 10;
            transition: background 0.3s;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .testi-nav:hover {
            background: rgba(255, 255, 255, 0.6);
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%; /* Para que todas tengan la misma altura */
            display: flex;
            flex-direction: column;
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
            flex-grow: 1; /* Para empujar el autor hacia abajo si el texto es corto */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
    <div class="contact-section section-padding">
        <div class="container">
            <div class="contact-wrapper">
                <div class="contact-info-card">
                    <div class="section-header mb-4">
                        <h2 class="modern-title">{{ $ofprincipal[0]->content }} <span>{{ $ofprincipal[1]->content }}</span></h2>
                        <div class="title-line" style="margin: 0 0 20px 0;"></div>
                    </div>
                    
                    <p class="contact-desc mb-4">{{ $ofprincipal[2]->content }}</p>
                    
                    <div class="contact-details-list">
                        <div class="contact-item">
                            <div class="icon-box"><i class="fa fa-phone"></i></div>
                            <div class="text-box">
                                <h4>Teléfono</h4>
                                <p>{{ $ofprincipal[3]->content }}</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="icon-box"><i class="fa fa-map-marker"></i></div>
                            <div class="text-box">
                                <h4>Ubicación</h4>
                                <p>{{ $ofprincipal[5]->content }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="store-image mt-4">
                        <img src="{{ $ofprincipal[4]->content }}" alt="Nuestra Tienda" class="rounded-lg shadow-md">
                    </div>
                </div>
                
                <div class="contact-map-wrapper">
                    {!! $ofprincipal[6]->content !!}
                </div>
            </div>
        </div>
    </div>
    <style>
        .contact-wrapper {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 40px;
            align-items: start;
        }
        @media (max-width: 991px) {
            .contact-wrapper {
                grid-template-columns: 1fr;
            }
        }
        .contact-info-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        body.dark .contact-info-card {
            background: #1f2937;
            border: 1px solid #374151;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .icon-box {
            width: 50px;
            height: 50px;
            background: #fff0e6;
            color: #ff6600;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        body.dark .icon-box {
            background: rgba(255, 102, 0, 0.15);
        }
        .text-box h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
        }
        body.dark .text-box h4 {
            color: #f3f4f6;
        }
        .text-box p {
            margin: 0;
            color: #666;
        }
        body.dark .text-box p, 
        body.dark .contact-desc {
            color: #9ca3af;
        }
        .contact-map-wrapper {
            height: 100%;
            min-height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        body.dark .contact-map-wrapper {
            border: 1px solid #374151;
        }
        .contact-map-wrapper iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
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

        /* Ajustes Responsivos Generales */
        @media (max-width: 768px) {
            section[style*="padding: 120px 0px;"],
            section[style*="padding: 90px 0px;"] {
                padding-top: 50px !important;
                padding-bottom: 50px !important;
            }

            /* Ajuste específico para la sección de testimonios */
            .section-testimonio {
                padding: 50px 10px !important;
            }

            /* Ajuste para la sección de mapa y contacto */
            .map-contact {
                padding: 50px 15px !important;
            }

            .googleMap-info iframe {
                height: 300px; /* Altura más adecuada para móviles */
            }
        }

        .hover-effect {
            transition: transform 0.3s ease;
        }
        .hover-effect:hover {
            transform: translateY(-5px);
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
