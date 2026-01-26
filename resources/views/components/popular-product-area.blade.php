
<div>
    <section class="popular-products-modern section-padding">
        <div class="container">
            @if(isset($product_popular_area) && count($product_popular_area) >= 3)
            <div class="section-header text-center mb-5">
                <h1 class="modern-title">
                    <span>{{ $product_popular_area[0]->content }}</span> {{ $product_popular_area[1]->content }}
                </h1>
                <div class="title-line"></div>
                <p class="section-description">
                    {{ $product_popular_area[2]->content }}
                </p>
            </div>
            @endif

            <div class="popular-grid">
                @foreach ($products_recommended as $product)
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
            </div>
        </div>
    </section>

    <style>
        /* Section Styles */
        .popular-products-modern {
            position: relative;
            background-color: #f9fafb;
        }

        body.dark .popular-products-modern {
            background-color: #111827;
        }

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
            margin: 0 auto 20px;
            border-radius: 2px;
        }

        .section-description {
            max-width: 700px;
            margin: 0 auto;
            color: #6b7280;
            font-size: 1rem;
            line-height: 1.6;
        }
        body.dark .section-description {
            color: #9ca3af;
        }

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
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-view-product:hover {
            background: var(--primary-color, #ff6600);
            color: #ffffff;
        }
    </style>
</div>
