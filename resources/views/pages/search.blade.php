@extends('layouts.celmovil')

@section('content')
    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <section class="search-results-section section-padding" style="margin-top: 100px; min-height: 60vh;">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h1 class="modern-title">Resultados para: <span>"{{ $search }}"</span></h1>
                <div class="title-line"></div>
            </div>

            @if(isset($products) && $products->count() > 0)
                <div class="models-grid">
                    @foreach ($products as $product)
                        <div class="model-card">
                            <a href="{{ route('web_producto_descripcion', $product->id) }}" class="model-link">
                                <div class="model-image-box" style="height: 300px; display: flex; align-items: center; justify-content: center; background: #f9fafb; padding: 20px; overflow: hidden; position: relative;">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.3s ease;">
                                    <div class="model-overlay">
                                        <span class="btn-view-model">Ver Detalles</span>
                                    </div>
                                </div>
                                <div class="model-info" style="padding: 20px; text-align: center;">
                                    <h3 class="model-name" style="font-size: 1.4rem; font-weight: 700; color: #1f2937; margin: 0;">{{ $product->name }}</h3>
                                    <div class="product-price" style="color: var(--primary-color, #ff6600); font-weight: 700; font-size: 1.2rem; margin-top: 10px;">
                                        S/ {{ number_format($product->price - $product->discount, 2) }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="pagination-wrapper" style="display: flex; justify-content: center; margin-top: 40px;">
                    {{ $products->appends(['search' => $search])->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class='bx bx-search-alt' style="font-size: 5rem; color: #ccc;"></i>
                    <h3 class="mt-4" style="color: #6b7280;">No se encontraron productos que coincidan con tu búsqueda.</h3>
                    <p style="color: #9ca3af;">Intenta con otros términos o explora nuestras categorías.</p>
                    <a href="{{ route('web_inicio') }}" class="btn-view-model" style="display: inline-block; margin-top: 20px; text-decoration: none; background: var(--primary-color, #ff6600); color: white; padding: 12px 30px; border-radius: 30px; font-weight: 700;">Volver al Inicio</a>
                </div>
            @endif
        </div>
    </section>

    <x-footer-area />

    <style>
        /* Reutilización de estilos de index para mantener coherencia */
        .modern-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: #1f2937;
        }
        .modern-title span { color: var(--primary-color, #ff6600); }
        body.dark .modern-title { color: #ffffff; }
        
        .title-line {
            width: 80px;
            height: 4px;
            background: var(--primary-color, #ff6600);
            margin: 0 auto 40px;
            border-radius: 2px;
        }

        .models-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .model-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #f3f4f6;
        }
        body.dark .model-card { background: #1f2937; border-color: #374151; }

        .model-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: var(--primary-color, #ff6600);
        }

        .model-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4);
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity 0.3s ease;
        }
        .model-card:hover .model-overlay { opacity: 1; }
        .model-card:hover img { transform: scale(1.1); }

        .btn-view-model {
            background: white;
            color: var(--primary-color, #ff6600);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
    </style>
@endsection