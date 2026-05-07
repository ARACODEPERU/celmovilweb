@props(['sliders'])

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
        margin-top: 75px;
        /* Espacio para el header fijo (35px top-bar + 80px main-header) */
        overflow: hidden;
        background-color: #e0e0e0;
        /* Color de fondo mientras carga la imagen */
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.3);
        /* Efecto de sombreado inferior */
        z-index: 1;
    }

    @media (max-width: 768px) {
        .slider-container {
            margin-top: 80px;
            /* En móvil, solo el header principal es visible */
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

    .slider-button.prev {
        left: 15px;
    }

    .slider-button.next {
        right: 15px;
    }

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

        if (nextButton) nextButton.addEventListener('click', () => moveSlide(1));
        if (prevButton) prevButton.addEventListener('click', () => moveSlide(-1));

        // Iniciar
        goToSlide(0);
    });
</script>