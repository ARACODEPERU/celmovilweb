
<div>
    <section class="featured-products-modern section-padding">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h1 class="modern-title">PRODUCTOS <span>DESTACADOS</span></h1>
                <div class="title-line"></div>
            </div>

            <div class="product-carousel-container">
                <button class="carousel-nav prev" aria-label="Anterior">&#10094;</button>

                <div class="carousel-viewport">
                    <div class="carousel-track">
                        @if (isset($feature_products))
                            @foreach ($feature_products->take(10) as $product)
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
        /* Section Title */
        .modern-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: #1f2937;
        }

        .modern-title span {
            color: var(--primary-color, #ff6600);
        }

        .title-line {
            width: 80px;
            height: 4px;
            background: var(--primary-color, #ff6600);
            margin: 0 auto 40px;
            border-radius: 2px;
        }

        body.dark .modern-title {
            color: #ffffff;
        }

        body.dark .featured-products-modern {
            background-color: #111827;
        }

        /* Modern Grid Layout */
        .featured-products-modern {
            position: relative;
        }

        /* Carousel Styles */
        .product-carousel-container {
            position: relative;
            display: flex;
            align-items: center;
            margin: 0 -10px;
            /* Offset padding of slides */
        }

        .carousel-viewport {
            overflow: hidden;
            width: 100%;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-slide {
            flex: 0 0 50%;
            /* Mobile: 2 columns */
            padding: 0 10px;
            box-sizing: border-box;
        }

        @media (min-width: 768px) {
            .carousel-slide {
                flex: 0 0 33.333%;
                /* Tablet: 3 columns */
            }
        }

        @media (min-width: 1024px) {
            .carousel-slide {
                flex: 0 0 25%;
                /* Small Desktop: 4 columns */
            }
        }

        @media (min-width: 1280px) {
            .carousel-slide {
                flex: 0 0 20%;
                /* Large Desktop: 5 columns */
            }
        }

        .carousel-nav {
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
            flex-shrink: 0;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .carousel-nav.prev {
            left: -20px;
        }

        .carousel-nav.next {
            right: -20px;
        }

        .carousel-nav:hover {
            background: var(--primary-color, #ff6600);
        }

        @media (max-width: 767px) {
            .carousel-nav {
                display: none;
            }
        }

        .carousel-pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 8px;
            flex-wrap: wrap;
        }

        .dot {
            width: 10px;
            height: 10px;
            background: #ccc;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s;
        }

        .dot.active {
            background: var(--primary-color, #ff6600);
            transform: scale(1.2);
        }

        /* Card Styling */
        .product-card {
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

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--primary-color, #ff6600);
        }

        /* Image Area */
        .product-image {
            position: relative;
            height: 200px;
            padding: 20px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #ef4444;
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            z-index: 2;
        }

        /* Content Area */
        .product-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: #ffffff;
        }

        .product-title {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 10px;
            line-height: 1.4;
            height: 40px;
            /* Limit height for alignment */
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-title a {
            color: #1f2937;
            text-decoration: none;
            transition: color 0.2s;
        }

        .product-card:hover .product-title a {
            color: var(--primary-color, #ff6600);
        }

        /* Price */
        .product-price {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .old-price {
            font-size: 0.8rem;
            color: #9ca3af;
            text-decoration: line-through;
        }

        .new-price,
        .regular-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color, #ff6600);
        }

        /* Button */
        .btn-view-product {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            width: 100%;
            padding: 8px 0;
            background: transparent;
            border: 1px solid var(--primary-color, #ff6600);
            color: var(--primary-color, #ff6600);
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-view-product:hover {
            background: var(--primary-color, #ff6600);
            color: #ffffff;
        }

        /* Dark Mode Overrides */
        body.dark .product-card {
            background: #1f2937;
            border-color: #374151;
        }

        body.dark .product-image {
            background: #1f2937;
        }

        body.dark .product-info {
            background: #1f2937;
        }

        body.dark .product-title a {
            color: #f3f4f6;
        }

        body.dark .product-card:hover .product-title a {
            color: var(--primary-color, #ff6600);
        }

        body.dark .old-price {
            color: #6b7280;
        }

        /* Ensure images look okay in dark mode if they have transparent backgrounds */
        body.dark .product-image img {
            filter: brightness(0.9);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.querySelector('.carousel-track');
            const slides = document.querySelectorAll('.carousel-slide');
            const prevBtn = document.querySelector('.carousel-nav.prev');
            const nextBtn = document.querySelector('.carousel-nav.next');
            const pagination = document.querySelector('.carousel-pagination');

            if (!track || slides.length === 0) return;

            let currentIndex = 0;
            let autoSlideInterval;

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
                const visibleSlides = getVisibleSlides();
                const maxIndex = slides.length - visibleSlides;

                currentIndex += direction;

                if (currentIndex < 0) currentIndex = maxIndex;
                if (currentIndex > maxIndex) currentIndex = 0;

                updateCarousel();
            }

            function createDots() {
                pagination.innerHTML = '';
                const visibleSlides = getVisibleSlides();
                const maxIndex = slides.length - visibleSlides;

                for (let i = 0; i <= maxIndex; i++) {
                    const dot = document.createElement('div');
                    dot.classList.add('dot');
                    if (i === currentIndex) dot.classList.add('active');
                    dot.addEventListener('click', () => {
                        currentIndex = i;
                        updateCarousel();
                        stopAutoSlide();
                        startAutoSlide();
                    });
                    pagination.appendChild(dot);
                }
            }

            function updateDots() {
                const dots = pagination.querySelectorAll('.dot');
                dots.forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentIndex);
                });
            }

            function startAutoSlide() {
                autoSlideInterval = setInterval(() => moveSlide(1), 5000);
            }

            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            if (prevBtn) prevBtn.addEventListener('click', () => {
                moveSlide(-1);
                stopAutoSlide();
                startAutoSlide();
            });
            if (nextBtn) nextBtn.addEventListener('click', () => {
                moveSlide(1);
                stopAutoSlide();
                startAutoSlide();
            });

            window.addEventListener('resize', () => {
                createDots();
                updateCarousel();
            });

            createDots();
            startAutoSlide();
        });
    </script>
</div>
