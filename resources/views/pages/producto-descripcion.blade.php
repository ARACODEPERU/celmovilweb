@extends('layouts.celmovil')

@section('content')

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <x-product-description.page-header-modern />


    <section class="product-details section-padding-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="left">
                        <div class="large-slider zoom-gallery">
                            <div>
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
                                <a href="{{ asset($product->image) }}" title="{{ $product->name }}">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
                                </a>
                            </div>
                            @foreach ($product->images as $image)
                                <div>
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" />
                                    <a href="{{ asset('storage/' . $image->image_path) }}" title="{{ $product->name }}">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                            alt="{{ $product->name }}" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="thumb-slider slider-nav">
                            <div>
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" />
                            </div>
                            @foreach ($product->images as $image)
                                <div>
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="product-info-v2">
                        <!-- Encabezado -->
                        <div class="product-header-v2">
                            <span class="product-category-v2">{{ $product->category_description }}</span>
                            <h1 class="product-title-v2">{{ $product->name }}</h1>
                            <span class="product-sku-v2">SKU: {{ $product->interne ?? 'N/A' }}</span>
                        </div>

                        <!-- Precio -->
                        <div class="product-price-box-v2">
                            @if ($product->discount > 0)
                                <span class="old-price">S/ {{ number_format($product->price, 2) }}</span>
                                <span class="current-price">S/
                                    {{ number_format($product->price - $product->discount, 2) }}</span>
                                <span class="discount-badge">{{ round(($product->discount / $product->price) * 100) }}%
                                    OFF</span>
                            @else
                                <span class="current-price">S/ {{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>

                        <!-- Descripción corta -->
                        <div class="product-highlights-v2 rich-text-content">
                            {!! $product->description !!}
                        </div>

                        <!-- Opciones -->
                        <div class="product-options-v2">
                            <!-- Selector de Color -->
                            @if ($product->product && $product->product->sizes)
                                <div class="option-group">
                                    <label class="option-label">Color:</label>
                                    <div class="color-swatches">
                                        <!-- Este select oculto es para compatibilidad con el JS existente -->
                                        <select id="color_selected_v2" style="display:none;">
                                            @foreach (json_decode($product->product->sizes) as $color)
                                                <option value="{{ $color->size }}">{{ $color->size }}</option>
                                            @endforeach
                                        </select>
                                        @foreach (json_decode($product->product->sizes) as $index => $color)
                                            <div class="swatch">
                                                <input type="radio" name="color_option" id="color_v2_{{ $index }}"
                                                    value="{{ $color->size }}" {{ $loop->first ? 'checked' : '' }}
                                                    onchange="document.getElementById('color_selected_v2').value = this.value;">
                                                <label for="color_v2_{{ $index }}">{{ $color->size }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <!-- Selector de Cantidad -->
                            <div class="option-group">
                                <label class="option-label">Cantidad:</label>
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn minus"
                                        onclick="this.nextElementSibling.stepDown()">-</button>
                                    <input type="number" value="1" min="1" class="qty-input" id="quantity_v2">
                                    <button type="button" class="qty-btn plus"
                                        onclick="this.previousElementSibling.stepUp()">+</button>
                                </div>
                            </div>
                        </div>

                        <!-- Bloque de Acción (CTA) -->
                        <div class="cta-block-v2">
                            @if ($product->existence > 0)
                                <button class="btn-add-to-cart-v2"
                                    onclick="agregarAlCarrito_w_color_v2({ id: {{ $product->id }}, nombre: '{{ addslashes($product->name) }}', color: {!! htmlspecialchars(json_encode($product), ENT_QUOTES, 'UTF-8') !!}, precio: {{ $product->price }} })">
                                    <i class="fa fa-shopping-cart"></i> Agregar al Carrito
                                </button>
                                <a href="https://api.whatsapp.com/send?phone=51921197459&text=Hola%20CelMovil!%20Me%20interesa%20el%20producto%20{{ urlencode($product->name) }}"
                                    target="_blank" class="btn-whatsapp-v2">
                                    <i class="fa fa-whatsapp"></i> Consultar
                                </a>
                            @else
                                <button class="btn-out-of-stock-v2" disabled>
                                    <i class="fa fa-ban"></i> Producto Agotado
                                </button>
                            @endif
                        </div>

                        <!-- Iconos de Confianza -->
                        <div class="trust-badges-v2">
                            <div class="badge-item"><i class="fa fa-shield"></i> <span>Garantía de 1 Año</span></div>
                            <div class="badge-item"><i class="fa fa-truck"></i> <span>Envío a todo el Perú</span></div>
                            <div class="badge-item"><i class="fa fa-credit-card"></i> <span>Pago Seguro</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="product-details-v2 section-padding-top"> 
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-accordion-v2">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-toggle="collapse"
                                    data-target="#collapseOneV2">
                                    Descripción Detallada
                                </button>
                            </h2>
                            <div id="collapseOneV2" class="collapse in">
                                <div class="accordion-body">
                                    {!! $product->additional !!}
                                </div>
                            </div>
                        </div>
                        @if (count($product->specifications) > 0)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseTwoV2">
                                        Especificaciones Técnicas
                                    </button>
                                </h2>
                                <div id="collapseTwoV2" class="collapse">
                                    <div class="accordion-body">
                                        <dl class="spec-list-v2">
                                            @foreach ($product->specifications as $spec)
                                                <dt>{{ $spec->title }}</dt>
                                                <dd>{{ $spec->description }}</dd>
                                            @endforeach
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseThreeV2">
                                    Documentos y Descargas
                                </button>
                            </h2>
                            <div id="collapseThreeV2" class="collapse">
                                <div class="accordion-body">
                                    @if ($product->additional2)
                                        <h4>Ficha Técnica</h4>
                                        @php $ext = pathinfo($product->additional2, PATHINFO_EXTENSION); @endphp
                                        @if (strtolower($ext) == 'pdf')
                                            <iframe src="{{ asset('storage/' . $product->additional2) }}"
                                                class="pdf-iframe"></iframe>
                                        @else
                                            <img class="img-responsive"
                                                src="{{ asset('storage/' . $product->additional2) }}"
                                                alt="Ficha Técnica" />
                                        @endif
                                    @endif
                                    @if ($product->additional3)
                                        <h4 style="margin-top: 20px;">Manual de Usuario</h4>
                                        <a href="{{ $product->additional3 }}" class="btn-download-v2" target="_blank">
                                            <i class="fa fa-file-pdf-o"></i> Descargar Manual
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    
    <x-product-description.info-cards :product="$product" />


    <!-- product details area end -->
    <br>
    <!-- related product section start -->
    <x-products-recommended />
    <!-- related product section end -->

    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

    <style>
        /* Estilos para transformar Tabs en Lista Vertical en Móvil */
        @media (max-width: 768px) {
            .tab-content .tab-pane {
                display: block !important;
                /* Forzar mostrar todos los paneles */
                opacity: 1 !important;
                visibility: visible !important;
                margin-bottom: 30px;
            }

            .mobile-tab-title {
                font-weight: bold;
                border-bottom: 2px solid #ff6600;
                padding-bottom: 10px;
                margin-bottom: 15px;
                color: #333;
            }
        }
    </style>

    <style>
        :root {
            --primary-color-v2: #ff6600;
            --secondary-color-v2: #1f2937;
            --text-color-v2: #4b5563;
            --light-gray-v2: #f3f4f6;
            --border-color-v2: #e5e7eb;
        }

        .product-details-v2 {
            padding: 60px 0;
            background-color: #fff;
        }

        body.dark .product-details-v2 {
            background-color: #111827;
            color: #e5e7eb;
        }

        .product-info-v2 {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .product-header-v2 .product-category-v2 {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary-color-v2);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-header-v2 .product-title-v2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 5px 0;
            line-height: 1.2;
            color: var(--secondary-color-v2);
        }

        body.dark .product-header-v2 .product-title-v2 {
            color: #fff;
        }

        .product-header-v2 .product-sku-v2 {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .product-price-box-v2 {
            display: flex;
            align-items: center;
            gap: 15px;
            background-color: var(--light-gray-v2);
            padding: 15px 20px;
            border-radius: 12px;
        }

        body.dark .product-price-box-v2 {
            background-color: #374151;
        }

        .product-price-box-v2 .old-price {
            font-size: 1.2rem;
            text-decoration: line-through;
            color: #9ca3af;
        }

        .product-price-box-v2 .current-price {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary-color-v2);
        }

        .product-price-box-v2 .discount-badge {
            background-color: #10b981;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .product-highlights-v2 {
            color: var(--text-color-v2);
            line-height: 1.7;
        }

        body.dark .product-highlights-v2 {
            color: #d1d5db;
        }

        .product-options-v2 {
            display: flex;
            flex-direction: column;
            gap: 20px;
            border-top: 1px solid var(--border-color-v2);
            border-bottom: 1px solid var(--border-color-v2);
            padding: 25px 0;
        }

        body.dark .product-options-v2 {
            border-color: #374151;
        }

        .option-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .option-label {
            font-weight: 600;
            width: 80px;
            color: var(--secondary-color-v2);
        }

        body.dark .option-label {
            color: #e5e7eb;
        }

        .color-swatches {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .color-swatches .swatch {
            position: relative;
        }

        .color-swatches input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .color-swatches label {
            display: block;
            padding: 8px 16px;
            border: 2px solid var(--border-color-v2);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        body.dark .color-swatches label {
            border-color: #4b5563;
        }

        .color-swatches input[type="radio"]:checked+label {
            border-color: var(--primary-color-v2);
            background-color: var(--primary-color-v2);
            color: white;
            font-weight: 700;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            border: 1px solid var(--border-color-v2);
            border-radius: 8px;
        }

        body.dark .quantity-selector {
            border-color: #4b5563;
        }

        .qty-btn {
            background: transparent;
            border: none;
            font-size: 1.2rem;
            padding: 0 15px;
            cursor: pointer;
            color: var(--text-color-v2);
            height: 42px;
            line-height: 42px;
        }

        body.dark .qty-btn {
            color: #d1d5db;
        }

        .qty-input {
            width: 50px;
            text-align: center;
            border: none;
            border-left: 1px solid var(--border-color-v2);
            border-right: 1px solid var(--border-color-v2);
            padding: 10px 0;
            font-weight: 700;
            background: transparent;
            color: var(--secondary-color-v2);
        }

        body.dark .qty-input {
            border-color: #4b5563;
            color: #fff;
        }

        .qty-input:focus {
            outline: none;
        }

        .cta-block-v2 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        @media (min-width: 576px) {
            .cta-block-v2 {
                grid-template-columns: 2fr 1fr;
            }
        }

        .btn-add-to-cart-v2,
        .btn-whatsapp-v2,
        .btn-out-of-stock-v2 {
            width: 100%;
            padding: 18px;
            font-size: 1.5rem;
            font-weight: 700;
            border-radius: 8px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-add-to-cart-v2 {
            background-color: var(--primary-color-v2);
            color: white;
        }

        .btn-add-to-cart-v2:hover {
            background-color: #e65c00;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 102, 0, 0.3);
        }

        .btn-whatsapp-v2 {
            background-color: #25d366;
            color: white;
            text-decoration: none;
        }

        .btn-whatsapp-v2:hover {
            background-color: #1da851;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .btn-out-of-stock-v2 {
            background-color: #d1d5db;
            color: #6b7280;
            cursor: not-allowed;
        }

        .trust-badges-v2 {
            display: flex;
            justify-content: space-around;
            gap: 15px;
            padding: 20px 0;
            border-top: 1px solid var(--border-color-v2);
        }

        body.dark .trust-badges-v2 {
            border-color: #374151;
        }

        .badge-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-align: center;
            color: var(--text-color-v2);
        }

        body.dark .badge-item {
            color: #9ca3af;
        }

        .badge-item i {
            font-size: 2.8rem;
            color: var(--primary-color-v2);
        }

        .badge-item span {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .product-accordion-v2 {
            margin-top: 60px;
            border-top: 1px solid var(--border-color-v2);
        }

        body.dark .product-accordion-v2 {
            border-color: #374151;
        }

        .product-accordion-v2 .accordion-item {
            border-bottom: 1px solid var(--border-color-v2);
        }

        body.dark .product-accordion-v2 .accordion-item {
            border-color: #374151;
        }

        .product-accordion-v2 .accordion-header .accordion-button {
            background: transparent;
            border: none;
            box-shadow: none;
            width: 100%;
            text-align: left;
            padding: 25px 10px;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--secondary-color-v2);
            position: relative;
            text-decoration: none;
        }

        body.dark .product-accordion-v2 .accordion-header .accordion-button {
            color: #fff;
        }

        .product-accordion-v2 .accordion-header .accordion-button:after {
            content: '\f078';
            font-family: FontAwesome;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s ease;
        }

        .product-accordion-v2 .accordion-header .accordion-button.collapsed:after {
            transform: translateY(-50%) rotate(-90deg);
        }

        .product-accordion-v2 .accordion-body {
            padding: 0 15px 30px 15px;
            line-height: 1.8;
            color: var(--text-color-v2);
        }

        body.dark .product-accordion-v2 .accordion-body {
            color: #d1d5db;
        }

        .spec-list-v2 {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        @media (min-width: 768px) {
            .spec-list-v2 {
                grid-template-columns: 1fr 2fr;
            }
        }

        .spec-list-v2 dt {
            font-weight: 600;
            color: var(--secondary-color-v2);
            background-color: var(--light-gray-v2);
            padding: 10px 15px;
            border-radius: 6px;
        }

        body.dark .spec-list-v2 dt {
            background-color: #374151;
            color: #fff;
        }

        .spec-list-v2 dd {
            margin: 0;
            padding: 10px 15px;
            align-self: center;
        }

        .btn-download-v2 {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background-color: var(--secondary-color-v2);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-download-v2:hover {
            background-color: #000;
            color: white;
        }

        .pdf-iframe {
            border: none;
            width: 100%;
            height: 1325px;
        }
    </style>
    
    <script>
        // Pequeño script para que el nuevo diseño sea compatible con la función de carrito existente.
        function agregarAlCarrito_w_color_v2(producto) {
            // Obtener valores de los nuevos inputs
            const color = document.getElementById('color_selected_v2').value;
            const quantity = document.getElementById('quantity_v2').value;

            // Crear elementos temporales con los IDs que espera la función original
            const tempColorSelect = document.createElement('select');
            tempColorSelect.id = 'color_selected';
            tempColorSelect.innerHTML = `<option value="${color}" selected>${color}</option>`;

            const tempQtyInput = document.createElement('input');
            tempQtyInput.id = 'quantity';
            tempQtyInput.value = quantity;

            // Ocultarlos y añadirlos al body
            tempColorSelect.style.display = 'none';
            tempQtyInput.style.display = 'none';
            document.body.appendChild(tempColorSelect);
            document.body.appendChild(tempQtyInput);

            // Llamar a la función original del carrito
            agregarAlCarrito_w_color(producto);

            // Limpiar los elementos temporales
            document.body.removeChild(tempColorSelect);
            document.body.removeChild(tempQtyInput);
        }
    </script>
@stop
