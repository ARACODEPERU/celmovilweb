
<div>
    <section class="promotional-modern section-padding">
        <div class="container">
            <div class="promo-card">
                <div class="promo-grid">
                    <!-- Text Content -->
                    <div class="promo-content">
                        <span class="promo-tag">{{ $promotional[0]->content }}</span>
                        <h2 class="promo-title">
                            {!! nl2br(e($promotional[1]->content)) !!}
                        </h2>
                        <div class="promo-line"></div>
                        <p class="promo-desc">
                            {{ $promotional[2]->content }}
                        </p>
                        <a href="{{ $promotional[3]->content }}" class="btn-promo-modern">
                            Acceder Ahora <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Image Content -->
                    <div class="promo-image-wrapper">
                        <a href="{{ $promotional[3]->content }}">
                            <img src="{{ $promotional[4]->content }}" alt="Promoción" loading="lazy">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .promotional-modern {
            position: relative;
        }

        .promo-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #f3f4f6;
        }
        body.dark .promo-card {
            background: #1f2937;
            border-color: #374151;
        }

        .promo-grid {
            display: grid;
            grid-template-columns: 1fr;
            align-items: center;
        }

        @media (min-width: 992px) {
            .promo-grid {
                grid-template-columns: 0.8fr 1.2fr; /* Text narrower than image */
            }
        }

        .promo-content {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start; /* Left align */
        }

        @media (max-width: 991px) {
            .promo-content {
                padding: 30px;
                align-items: center;
                text-align: center;
            }
        }

        .promo-tag {
            display: inline-block;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color, #ff6600);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            background: rgba(255, 102, 0, 0.1);
            padding: 5px 12px;
            border-radius: 50px;
        }

        .promo-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            color: #1f2937;
        }
        body.dark .promo-title { color: #ffffff; }

        @media (max-width: 768px) {
            .promo-title { font-size: 2rem; }
        }

        .promo-line {
            width: 60px;
            height: 4px;
            background: var(--primary-color, #ff6600);
            margin-bottom: 20px;
            border-radius: 2px;
        }

        .promo-desc {
            font-size: 1.6rem;
            color: #6b7280;
            margin-bottom: 30px;
            line-height: 1.6;
            max-width: 90%;
        }
        body.dark .promo-desc { color: #d1d5db; }

        .btn-promo-modern {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--primary-color, #ff6600);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 102, 0, 0.3);
        }

        .btn-promo-modern:hover {
            background: #e65c00;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.4);
            color: white;
        }

        .promo-image-wrapper {
            position: relative;
            height: 100%;
            min-height: 300px;
            overflow: hidden;
        }

        .promo-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .promo-card:hover .promo-image-wrapper img {
            transform: scale(1.03);
        }
    </style>
</div>
