@props(['accessories'])

<div id="accessories-carousel-wrapper">
    <section class="featured-products-modern section-padding">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h1 class="modern-title">NUESTROS <span>ACCESORIOS</span></h1>
                <div class="title-line"></div>
            </div>

            <div class="product-carousel-container">
                <button class="carousel-nav prev" aria-label="Anterior">&#10094;</button>

                <div class="carousel-viewport">
                    <div class="carousel-track">
                        @if (isset($accessories) && count($accessories) > 0)
                            @foreach ($accessories as $product)
                                <div class="carousel-slide">
                                    <div class="product-card">
                                        <!-- Image -->
                                        <div class="product-image">
                                            <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                                    loading="lazy" />
                                            </a>
                                            @if ($product->discount > 0)
                                                <span
                                                    class="discount-badge">-{{ round(($product->discount / $product->price) * 100) }}%</span>
                                            @endif
                                        </div>

                                        <!-- Content -->
                                        <div class="product-info">
                                            <h3 class="product-title">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>

                                            <div class="product-price">
                                                @if ($product->discount > 0)
                                                    @php $new_price = $product->price - $product->discount; @endphp
                                                    <span class="old-price">S/
                                                        {{ number_format($product->price, 2) }}</span>
                                                    <span class="new-price">S/ {{ number_format($new_price, 2) }}</span>
                                                @else
                                                    <span class="regular-price">S/
                                                        {{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>

                                            <a href="{{ route('web_producto_descripcion', $product->id) }}"
                                                class="btn-view-product">
                                                Ver Detalles <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <button class="carousel-nav next" aria-label="Siguiente">&#10095;</button>
            </div>
            <div class="carousel-pagination"></div>
        </div>
    </section>

    <style>
        #accessories-carousel-wrapper .modern-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: #1f2937;
        }
        #accessories-carousel-wrapper .modern-title span { color: var(--primary-color, #ff6600); }
        #accessories-carousel-wrapper .title-line {
            width: 80px;
            height: 4px;
            background: var(--primary-color, #ff6600);
            margin: 0 auto 40px;
            border-radius: 2px;
        }
        #accessories-carousel-wrapper .featured-products-modern {
            /* background: linear-gradient(to bottom, #ffffff, #f3f4f6); */
            background: linear-gradient(to bottom, #ffffff, #f6f6f6);
        }
        body.dark #accessories-carousel-wrapper .modern-title { color: #ffffff; }
        body.dark #accessories-carousel-wrapper .featured-products-modern { background: #111827; }

        #accessories-carousel-wrapper .product-carousel-container {
            position: relative;
            display: flex;
            align-items: center;
            margin: 0 -10px;
        }
        #accessories-carousel-wrapper .carousel-viewport { overflow: hidden; width: 100%; }
        #accessories-carousel-wrapper .carousel-track { display: flex; transition: transform 0.5s ease-in-out; }
        #accessories-carousel-wrapper .carousel-slide {
            flex: 0 0 50%;
            padding: 0 10px;
            box-sizing: border-box;
        }
        @media (min-width: 768px) { #accessories-carousel-wrapper .carousel-slide { flex: 0 0 33.333%; } }
        @media (min-width: 1024px) { #accessories-carousel-wrapper .carousel-slide { flex: 0 0 25%; } }
        @media (min-width: 1280px) { #accessories-carousel-wrapper .carousel-slide { flex: 0 0 20%; } }

        #accessories-carousel-wrapper .carousel-nav {
            background: rgba(0, 0, 0, 0.3);
            color: white;
            border: none;
            font-size: 24px;
            cursor: pointer;
            border-radius: 50%;
            z-index: 10;
            transition: background 0.3s;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }
        #accessories-carousel-wrapper .carousel-nav.prev { left: -20px; }
        #accessories-carousel-wrapper .carousel-nav.next { right: -20px; }
        #accessories-carousel-wrapper .carousel-nav:hover { background: var(--primary-color, #ff6600); }
        @media (max-width: 767px) { #accessories-carousel-wrapper .carousel-nav { display: none; } }

        #accessories-carousel-wrapper .carousel-pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 8px;
            flex-wrap: wrap;
        }
        #accessories-carousel-wrapper .dot {
            width: 10px;
            height: 10px;
            background: #ccc;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s;
        }
        #accessories-carousel-wrapper .dot.active {
            background: var(--primary-color, #ff6600);
            transform: scale(1.2);
        }

        #accessories-carousel-wrapper .product-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #f3f4f6;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        #accessories-carousel-wrapper .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color, #ff6600);
        }
        body.dark #accessories-carousel-wrapper .product-card { background: #1f2937; border-color: #374151; }
        #accessories-carousel-wrapper .product-image {
            position: relative;
            height: 200px;
            padding: 20px;
            background: #ffffff;
            display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        body.dark #accessories-carousel-wrapper .product-image { background: #1f2937; }
        #accessories-carousel-wrapper .product-image img {
            max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.5s ease;
        }
        body.dark #accessories-carousel-wrapper .product-image img { filter: brightness(0.9); }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById('accessories-carousel-wrapper');
            const track = wrapper.querySelector('.carousel-track');
            const slides = wrapper.querySelectorAll('.carousel-slide');
            const prevBtn = wrapper.querySelector('.carousel-nav.prev');
            const nextBtn = wrapper.querySelector('.carousel-nav.next');
            const pagination = wrapper.querySelector('.carousel-pagination');

            if (!track || slides.length === 0) return;

            let currentIndex = 0;

            function getVisibleSlides() {
                if (window.innerWidth < 768) return 2;
                if (window.innerWidth < 1024) return 3;
                if (window.innerWidth < 1280) return 4;
                return 5;
            }

            function updateCarousel() {
                const visibleSlides = getVisibleSlides();
                const slideWidth = 100 / visibleSlides;
                track.style.transform = `translateX(-${currentIndex * slideWidth}%)`;
                updateDots();
            }

            function moveSlide(direction) {
                const maxIndex = slides.length - getVisibleSlides();
                currentIndex = (currentIndex + direction + (maxIndex + 1)) % (maxIndex + 1);
                updateCarousel();
            }

            function createDots() {
                pagination.innerHTML = '';
                const maxIndex = slides.length - getVisibleSlides();
                for (let i = 0; i <= maxIndex; i++) {
                    const dot = document.createElement('div');
                    dot.classList.add('dot');
                    if (i === currentIndex) dot.classList.add('active');
                    dot.addEventListener('click', () => { currentIndex = i; updateCarousel(); });
                    pagination.appendChild(dot);
                }
            }

            function updateDots() {
                const dots = pagination.querySelectorAll('.dot');
                dots.forEach((dot, index) => dot.classList.toggle('active', index === currentIndex));
            }

            prevBtn.addEventListener('click', () => moveSlide(-1));
            nextBtn.addEventListener('click', () => moveSlide(1));
            window.addEventListener('resize', () => { createDots(); updateCarousel(); });

            createDots();
            setInterval(() => moveSlide(1), 5000);
        });
    </script>
</div>