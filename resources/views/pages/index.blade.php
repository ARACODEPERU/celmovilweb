@extends('layouts.celmovil')

@section('content')
    <!-- Preloader Start -->
    <x-home.preloader :logo="asset('themes/celmovil/img/logoCM.png')" />
    <!-- Preloader End -->

    <!-- header -->
    <x-header-area />

    <!-- slider -->
    <x-home.slider :sliders="$sliders" />

    <!-- Tarjetas Catalogo -->
    <x-home.cards-catalog :portadas="$portadas" />

    <!-- feature products - section start -->
    <x-feature-products-area />

    <!-- accessories random area -->
    <x-accessories-random-area :accessories="$accessories" />

    <!-- popular-product section start -->
    <x-popular-product-area />

    <!-- promotional -->
    <x-promotional-area />

    <!-- featured models -->
    <x-home.featured-models :algunos_modelos="$algunos_modelos" />

    <!-- testimonies -->
    <x-home.testimonies />

    <!-- contact -->
    <x-home.contact :ofprincipal="$ofprincipal" />

    <!-- footer -->
    <x-footer-area />

    <style>
        .scroll-reveal {
            /* opacity: 0; */
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
                height: 300px;
                /* Altura más adecuada para móviles */
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

            const elementsToAnimate = document.querySelectorAll(
                "section, .slider-container, .grid-item, .card, .map-contact");
            elementsToAnimate.forEach((el) => {
                el.classList.add("scroll-reveal");
                observer.observe(el);
            });

        });
    </script>
@endsection
