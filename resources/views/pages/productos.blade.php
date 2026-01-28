@extends('layouts.celmovil')

@section('content')
    <!-- Preloader Start
                                                                                                                                                                                                                                <div class="preloader">                                                                                                                                                                              </div>
                                                                                                                                                                                                                                                            </div> -->
    <!-- Preloader End -->

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <!-- page banner area start -->
    <div class="page-banner">
        <img style="width: 100%; height: 250px;" src="{{ $banner[0]->content }}" alt="Page Banner" />
    </div>
    <!-- page banner area end -->
    {{-- <section class="best-sell-area popular-product section-padding-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                    <div class="section-title text-center">
                        <h3><span>
                        @if ($category_id == 1)
                            MOTOS
                            @elseif($category_id == 2)
                            TRIMOTOS
                            @elseif($category_id == 6)
                            BATERIAS
                            @elseif($category_id == 25)
                            CUATRIMOTOS
                            @elseif($category_id == 26)
                            REPUESTOS
                            @elseif($category_id == 27)
                            ACCESORIOS
                        @endif  
                        </span></h3>
                        <div class="shape">
                        </div>
                        <p>
                            ¿Listo para experimentar lo último en estilo, tecnología y comodidad?
                            <br>¡Visítanos hoy mismo y déjate sorprender por nuestros productos más populares!
                        </p>
                    </div>
                </div>
            </div>
            <div class="text-center tab-content">
                <div class="tab-pane fade active in">
                    <div class="single-products">
                        <div class="row">
                            @if (count($products) > 0)
                                @foreach ($products as $product)
                                    <div class="col-xs-12 col-md-3" style="padding: 15px;">
                                        <div class="product-item" style="padding: 15px;  height: 380px;">
                                            <div class="pro-img">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 220px; height: 220px;">
                                                </a>
                                            </div>
                                            <div class="">
                                                <div class="product-title">
                                                    <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                                        <h6><b>{{ $product->name }}</b></h6>
                                                    </a>
                                                    @if ($product->discount > 0)
                                                        @php
                                                            $new_price = $product->price - $product->discount;
                                                        @endphp
                                                        <p>
                                                            Antes: <del> S/ {{ number_format($product->price, 2) }}</del> <br>
                                                            Promoción: <span><b>S/ {{ number_format($new_price, 2) }}</b>
                                                            </span>
                                                        </p>
                                                    @else
                                                        <p>
                                                            Precio: <b>S/ {{ number_format($product->price, 2) }}</b>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div style="margin-top: 10px;">
                                                <a href="{{ route('web_producto_descripcion', $product->id) }}" class="btn btn-celmovil">
                                                    <b>Más Información </b>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section style="padding: 40px 0px;">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-text-center">
                    <div class="section-title text-center">
                        <h3>
                            <span>
                            @if ($category_id == 1)
                                MOTOS
                                @elseif($category_id == 2)
                                TRIMOTOS
                                @elseif($category_id == 6)
                                VMPS, BICIMOTOS y BICIS
                                @elseif($category_id == 3)
                                CUATRIMOTOS
                                @elseif($category_id == 26)
                                REPUESTOS
                                @elseif($category_id == 27)
                                ACCESORIOS
                                @elseif($category_id == 28)
                                CARGUEROS
                            @endif  
                            </span>
                        </h3>
                        <div class="shape">
                        </div>
                        <p>
                            ¿Listo para experimentar lo último en estilo, tecnología y comodidad?
                            <br>¡Visítanos hoy mismo y déjate sorprender por nuestros productos más populares!
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="popular-grid">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <div class="product-card">
                        <!-- Image -->
                        <div class="product-image">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy" />
                            </a>
                            @if ($product->discount > 0)
                                <span class="discount-badge">-{{ round(($product->discount / $product->price) * 100) }}%</span>
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
                                    <span class="old-price">S/ {{ number_format($product->price, 2) }}</span>
                                    <span class="new-price">S/ {{ number_format($new_price, 2) }}</span>
                                @else
                                    <span class="regular-price">S/ {{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>

                            <a href="{{ route('web_producto_descripcion', $product->id) }}" class="btn-view-product">
                                Ver Detalles <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
            </div>
            <div class="pagination-wrapper mt-5 text-center" style="margin-top: 30px;">
                @if(method_exists($products, 'links'))
                    {{ $products->links() }}
                @endif
            </div>
        </div>
    </section>

    
    <style>
        /* Grid Layout */
        .popular-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        }

        @media (min-width: 768px) {
            .popular-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }
        }
        @media (min-width: 1024px) {
            .popular-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        @media (min-width: 1280px) {
            .popular-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        /* Card Styles (Consistent with Feature Products) */
        .product-card {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            border: 1px solid #f3f4f6;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border-color: var(--primary-color, #ff6600);
        }

        /* Dark Mode Overrides for Cards */
        body.dark .product-card {
            background: #1f2937;
            border-color: #374151;
        }

        /* Shared Styles */
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
        body.dark .product-image { background: #1f2937; }
        
        .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
        }
        body.dark .product-image img { filter: brightness(0.9); }
        
        .product-card:hover .product-image img { transform: scale(1.1); }

        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #ef4444;
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            z-index: 2;
        }

        .product-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: #ffffff;
        }
        body.dark .product-info { background: #1f2937; }

        .product-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
            line-height: 1.4;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .product-title a { color: #1f2937; text-decoration: none; transition: color 0.2s; }
        body.dark .product-title a { color: #f3f4f6; }
        .product-card:hover .product-title a { color: var(--primary-color, #ff6600); }

        .product-price { margin-bottom: 15px; display: flex; flex-direction: column; }
        
        .old-price {
            font-size: 1.1rem;
            color: #9ca3af;
            text-decoration: line-through;
        }

        .new-price,
        .regular-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color, #ff6600);
        }

        body.dark .old-price { color: #6b7280; }

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
            font-size: 1.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-view-product:hover {
            background: var(--primary-color, #ff6600);
            color: #ffffff;
        }
    </style>

    <!-- footer - section start -->
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

            const elementsToAnimate = document.querySelectorAll("section, .grid-item, .product-item");
            elementsToAnimate.forEach((el) => {
                el.classList.add("scroll-reveal");
                observer.observe(el);
            });
        });
    </script>
@stop
