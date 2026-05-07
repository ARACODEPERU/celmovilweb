@props(['algunos_modelos'])

<section class="featured-models-modern section-padding">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h1 class="modern-title">MODELOS <span>DESTACADOS</span></h1>
            <div class="title-line"></div>
        </div>

        <div class="models-grid">
            @foreach ($algunos_modelos as $key => $am)
                <div class="model-card">
                    <a href="{{ $am->item->items[2]->content ?? '#' }}" class="model-link">
                        <div class="model-image-box" style="height: 400px;"> {{-- Altura fija para consistencia --}}
                            <img src="{{ $am->item->items[0]->content }}" alt="{{ $am->item->items[1]->content }}"
                                loading="lazy">
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
        /* Estilos de Título */
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

        /* Estilos de Sección */
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
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
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
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
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
            background: rgba(0, 0, 0, 0.4);
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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