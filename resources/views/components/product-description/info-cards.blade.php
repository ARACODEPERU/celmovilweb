@props(['product'])

{{-- <section class="info-cards-section section-padding-top">
    <div class="container">
        <div class="section-header-proposal mb-5">
            <h2 class="proposal-title">INFORMACIÓN <span>COMPLETA</span></h2>
            <div class="proposal-line"></div>
        </div>

        <div class="info-cards-grid">
            <!-- Card 1: Descripción Detallada -->
            <div class="info-card description-card">
                <div class="card-header">
                    <i class="fa fa-info-circle"></i>
                    <h3>Descripción Detallada</h3>
                </div>
                <div class="card-body">
                    <div class="rich-text-content">
                        {!! $product->additional !!}
                    </div>
                </div>
            </div>

            <div class="secondary-info-stack">
                <!-- Card: Vista Previa Ficha Técnica -->
                @if ($product->additional2)
                    <div class="info-card technical-preview-card">
                        <div class="card-header">
                            <i class="fa fa-file-image-o"></i>
                            <h3>Vista Ficha Técnica</h3>
                        </div>
                        <div class="card-body">
                            <div class="technical-image-wrapper">
                                <img src="{{ asset('storage/' . $product->additional2) }}" alt="Ficha Técnica" class="preview-img">
                                <a href="{{ asset('storage/' . $product->additional2) }}" target="_blank" class="expand-btn">
                                    <i class="fa fa-search-plus"></i> Ver documento original
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 2: Especificaciones Técnicas -->
                @if (count($product->specifications) > 0)
                    <div class="info-card specs-card">
                        <div class="card-header">
                            <i class="fa fa-list-ul"></i>
                            <h3>Ficha Técnica</h3>
                        </div>
                        <div class="card-body">
                            <div class="specs-mini-grid">
                                @foreach ($product->specifications as $spec)
                                    <div class="spec-item">
                                        <span class="spec-label">{{ $spec->title }}</span>
                                        <span class="spec-value">{{ $spec->description }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Card 3: Documentos y Descargas -->
                <div class="info-card resources-card">
                    <div class="card-header">
                        <i class="fa fa-download"></i>
                        <h3>Documentación</h3>
                    </div>
                    <div class="card-body">
                        <div class="resource-links">
                            @if ($product->additional3)
                                <a href="{{ $product->additional3 }}" target="_blank" class="resource-btn manual">
                                    <div class="res-icon"><i class="fa fa-book"></i></div>
                                    <div class="res-text">
                                        <span class="res-title">Manual de Usuario</span>
                                        <span class="res-action">Descargar PDF</span>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .section-header-proposal { text-align: center; }
        .proposal-title { font-size: 2rem; font-weight: 800; color: #1f2937; margin-bottom: 10px; }
        .proposal-title span { color: var(--primary-color-v2, #ff6600); }
        body.dark .proposal-title { color: #fff; }
        .proposal-line { width: 60px; height: 4px; background: #ff6600; margin: 0 auto 30px; border-radius: 2px; }

        .info-cards-grid { display: grid; grid-template-columns: 1fr; gap: 30px; }
        @media (min-width: 1024px) { .info-cards-grid { grid-template-columns: 1.5fr 1fr; } }

        .info-card { background: #fff; border-radius: 16px; border: 1px solid #e5e7eb; overflow: hidden; height: fit-content; }
        body.dark .info-card { background: #1f2937; border-color: #374151; }

        .card-header { background: #f9fafb; padding: 20px 25px; display: flex; align-items: center; gap: 15px; border-bottom: 1px solid #e5e7eb; }
        body.dark .card-header { background: rgba(255,255,255,0.02); border-color: #374151; }
        .card-header i { font-size: 1.5rem; color: #ff6600; }
        .card-header h3 { font-size: 1.25rem; font-weight: 700; margin: 0; color: #1f2937; }
        body.dark .card-header h3 { color: #fff; }

        .card-body { padding: 25px; }

        /* Specs Mini Grid */
        .specs-mini-grid { display: grid; grid-template-columns: 1fr; gap: 12px; }
        .spec-item { display: flex; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px dashed #e5e7eb; }
        body.dark .spec-item { border-color: #374151; }
        .spec-label { font-weight: 600; color: #6b7280; font-size: 0.95rem; }
        .spec-value { color: #1f2937; font-weight: 500; text-align: right; }
        body.dark .spec-value { color: #d1d5db; }

        /* Resources */
        .resource-links { display: flex; flex-direction: column; gap: 15px; }
        .resource-btn { 
            display: flex; align-items: center; gap: 15px; padding: 15px; background: #f3f4f6; 
            border-radius: 12px; text-decoration: none !important; transition: all 0.3s;
        }
        body.dark .resource-btn { background: #374151; }
        .resource-btn:hover { background: #ff6600; transform: translateX(5px); }
        .resource-btn:hover .res-title, .resource-btn:hover .res-action, .resource-btn:hover i { color: #fff; }

        .res-icon { width: 45px; height: 45px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: #ff6600; }
        body.dark .res-icon { background: #1f2937; }
        .res-text { display: flex; flex-direction: column; }
        .res-title { font-weight: 700; color: #1f2937; font-size: 1rem; }
        body.dark .res-title { color: #fff; }
        .res-action { font-size: 0.85rem; color: #6b7280; }

        .secondary-info-stack { display: flex; flex-direction: column; gap: 30px; }

        .rich-text-content { font-size: 1.05rem; line-height: 1.8; color: #4b5563; }
        body.dark .rich-text-content { color: #d1d5db; }
        .rich-text-content img { border-radius: 10px; margin: 15px 0; max-width: 100%; height: auto; }

        /* Ficha Técnica Card Styles */
        .technical-image-wrapper { text-align: center; }
        .preview-img { width: 100%; height: auto; border-radius: 8px; border: 1px solid #e5e7eb; transition: transform 0.3s; }
        body.dark .preview-img { border-color: #374151; }
        .expand-btn { 
            display: inline-block; margin-top: 15px; color: #ff6600; font-weight: 700; 
            text-decoration: none !important; font-size: 0.9rem; 
        }
        .expand-btn:hover { color: #e65c00; }
        .technical-preview-card .card-body { padding: 15px; }
    </style>
</section> --}}

{{-- ========================================================================================= --}}
{{-- NUEVA PROPUESTA: BENTO MODULAR (TODO AL ALCANCE)                                           --}}
{{-- ========================================================================================= --}}

<section id="info-mosaic-proposal" class="section-padding-top pb-2">
    <div class="container">
        <div class="bento-grid">
            <!-- Bloque Principal: Descripción (Ocupa 2 columnas y 2 filas en Desktop) -->
            <div class="bento-item bento-main">
                <div class="bento-inner">
                    <div class="bento-header">
                        <span class="bento-icon"><i class="fa fa-align-left"></i></span>
                        <h3>Historia y Detalles</h3>
                    </div>
                    <div class="rich-text-content">
                        {!! $product->additional !!}
                    </div>
                </div>
            </div>

            <!-- Bloque Secundario: Ficha Técnica Rápida -->
            @if (count($product->specifications) > 0)
            <div class="bento-item bento-specs">
                <div class="bento-inner">
                    <div class="bento-header">
                        <span class="bento-icon"><i class="fa fa-bolt"></i></span>
                        <h3>Especificaciones</h3>
                    </div>
                    <div class="specs-mini-list">
                        @foreach ($product->specifications->take(6) as $spec)
                            <div class="spec-row">
                                <div class="spec-label-group">
                                    <i class="fa fa-caret-right"></i>
                                    <span class="label">{{ $spec->title }}</span>
                                </div>
                                <span>{{ $spec->description }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Bloque de Descargas: Acción Inmediata -->
            <div class="bento-item bento-downloads">
                <div class="bento-inner">
                    <div class="bento-header">
                        <span class="bento-icon"><i class="fa fa-cloud-download"></i></span>
                        <h3>Recursos</h3>
                    </div>
                    <div class="download-chips">
                        @if ($product->additional3)
                            <a href="{{ $product->additional3 }}" target="_blank" class="chip" style="font-size: 1.4rem;">
                                <i class="fa fa-file-pdf-o" style="font-size: 1.8rem;"></i> Manual de Usuario
                            </a>
                        @endif
                        <a href="https://api.whatsapp.com/send?phone=51921197459" class="chip whatsapp" style="font-size: 1.4rem;">
                            <i class="fa fa-whatsapp" style="font-size: 1.8rem;"></i> Soporte Técnico
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bloque Visual: Preview de Ficha -->
            @if ($product->additional2)
            <div class="bento-item bento-preview">
                <div class="bento-inner">
                    <div class="preview-overlay">
                        <i class="fa fa-eye"></i>
                        <span>Expandir Ficha</span>
                    </div>
                    <img src="{{ asset('storage/' . $product->additional2) }}" alt="Ficha">
                    <a href="{{ asset('storage/' . $product->additional2) }}" target="_blank" class="stretched-link"></a>
                </div>
            </div>
            @endif
        </div>
    </div>

    <style>
        #info-mosaic-proposal .bento-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        @media (min-width: 992px) {
            #info-mosaic-proposal .bento-grid {
                grid-template-columns: repeat(3, 1fr);
                grid-template-rows: auto auto;
                grid-template-areas: 
                    "main main specs"
                    "main main preview"
                    "downloads downloads preview";
            }
            .bento-main { grid-area: main; }
            .bento-specs { grid-area: specs; }
            .bento-preview { grid-area: preview; }
            .bento-downloads { grid-area: downloads; }
        }

        .bento-item { background: #fff; border-radius: 24px; overflow: hidden; border: 1px solid #edf2f7; transition: 0.3s; }
        body.dark .bento-item { background: #1a202c; border-color: #2d3748; }
        .bento-item:hover { transform: translateY(-4px); box-shadow: 0 12px 20px rgba(0,0,0,0.05); }

        .bento-inner { padding: 30px; height: 100%; display: flex; flex-direction: column; }
        .bento-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .bento-icon { width: 40px; height: 40px; background: #fff5f0; color: #ff6600; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
        body.dark .bento-icon { background: rgba(255, 102, 0, 0.1); }
        .bento-header h3 { font-size: 1.3rem; font-weight: 800; margin: 0; }
        body.dark .bento-header h3 { color: #ffffff; }

        /* Specs Style */
        .spec-row { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 10px 12px; 
            margin-bottom: 4px;
            transition: all 0.3s ease;
            border-radius: 8px;
        }
        /* Zebra striping para orden visual */
        .spec-row:nth-child(even) { background-color: #f8fafc; }
        body.dark .spec-row:nth-child(even) { background-color: rgba(255,255,255,0.02); }

        /* Micro-interacción al pasar el mouse */
        .spec-row:hover { background-color: #fff5f0; transform: translateX(5px); }
        body.dark .spec-row:hover { background-color: rgba(255,102,0,0.1); }

        body.dark .spec-row { border-color: #2d3748; }
        .spec-label-group { display: flex; align-items: center; gap: 8px; }
        .spec-label-group i { color: #ff6600; font-size: 0.8rem; opacity: 0.8; }
        .spec-row .label { color: #64748b; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; }
        body.dark .spec-row .label { color: #94a3b8; }
        .spec-row .value { font-weight: 700; color: #2d3748; font-size: 0.95rem; text-align: right; }
        body.dark .spec-row .value { color: #e2e8f0; }

        /* Chips */
        .download-chips { display: flex; gap: 12px; flex-wrap: wrap; }
        .chip { padding: 10px 20px; background: #f7fafc; border-radius: 100px; text-decoration: none !important; color: #2d3748; font-weight: 700; font-size: 0.9rem; transition: 0.2s; border: 1px solid #edf2f7; }
        body.dark .chip { background: #2d3748; color: #fff; border-color: #4a5568; }
        .chip:hover { background: #ff6600; color: #fff; border-color: #ff6600; }
        .chip.whatsapp { color: #25d366; }
        .chip.whatsapp:hover { color: #fff; background: #25d366; }

        /* Preview Card */
        .bento-preview { position: relative; min-height: 250px; }
        .bento-preview .bento-inner { padding: 0; }
        .bento-preview img { width: 100%; height: 100%; object-fit: cover; }
        .preview-overlay { 
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.5); display: flex; flex-direction: column; 
            align-items: center; justify-content: center; color: #fff; 
            opacity: 0; transition: 0.3s; z-index: 1;
        }
        .bento-preview:hover .preview-overlay { opacity: 1; }
        .preview-overlay i { font-size: 2rem; margin-bottom: 8px; }

        /* Typography Description */
        .bento-main .rich-text-content { 
            column-count: 1; gap: 30px; color: #4b5563; line-height: 1.8; 
        }
        @media (min-width: 1200px) { .bento-main .rich-text-content { column-count: 2; } }

        /* Forzar que el contenido de TinyMCE ignore sus estilos en línea en modo oscuro */
        body.dark .rich-text-content,
        body.dark .rich-text-content * { 
            color: #d1d5db !important;
            background-color: transparent !important;
        }

        .stretched-link::after { position: absolute; top: 0; right: 0; bottom: 0; left: 0; z-index: 2; content: ""; }
    </style>
</section>