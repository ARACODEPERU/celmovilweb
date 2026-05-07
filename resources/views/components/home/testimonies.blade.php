<section class="section-testimonio">
    <div class="testimonial-slider-container">
        <button class="testi-nav prev-btn">&#10094;</button>
        <div class="testimonial-viewport">
            <div class="testimonios-track" id="dynamic-testimonials">
                <!-- Se cargará dinámicamente -->
            </div>
        </div>
        <button class="testi-nav next-btn">&#10095;</button>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const testimonialsData = [{
                author: "Bryan Riveros Gamboa",
                content: "Un servicio de calidad, compré mi moto aquí y siempre han estado predispuestos a brindarme un buen servicio técnico.",
                img: "{{ asset('themes/celmovil/img/bryan.png') }}"
            },
            {
                author: "Edith Genoveva Reyna",
                content: "Tengo una bicimoto eléctrica que siempre llevo a cel movil para mantenimiento y recibo una excelente atención.",
                img: "https://lh3.googleusercontent.com/a-/ALV-UjWrP8kPYd6GPZZ4nsM-tPcfo2Yk3BV1YtWKoaIb8SusYvym9gk=w45-h45-p-rp-mo-br100"
            },
            {
                author: "Miguel Arce Falla",
                content: "Brindan un buen servicio, y a tiempo, 100% recomendando!",
                img: "https://lh3.googleusercontent.com/a-/ALV-UjUKozGV7NjT6onElaBNoR4_uo-3ygyADfK1d5RCcB0o3LJ55ua5=w75-h75-p-rp-mo-br100"
            },
            {
                author: "Lenin Garcia",
                content: "Excelente atención y Servicio, Cumplen con la garantía y los mantenimientos. Todo marcha bien.",
                img: "https://lh3.googleusercontent.com/a-/ALV-UjUdhAitM-fTfiD9__kkZ-zlT7jO6PMROzM-o2nljSgGctdwc5vw=w75-h75-p-rp-mo-br100"
            },
            {
                author: "Diego Ruiz",
                content: "El mejor en motos eléctricas! Además que brindan servicio especializado para el mantenimiento.",
                img: "https://lh3.googleusercontent.com/a-/ALV-UjVrRiF_x6AA9yUKz2mwA1W8twCXc5xSAB7KQ0rWtvvkbZj9xPVEPw=w75-h75-p-rp-mo-br100"
            },
            {
                author: "Carlos Mendoza",
                content: "Muy buena experiencia de compra, el personal muy atento y conocedor del tema.",
                img: "https://randomuser.me/api/portraits/men/32.jpg"
            },
            {
                author: "Ana María López",
                content: "Me encantó mi nueva scooter, llegó a tiempo y en perfectas condiciones.",
                img: "https://randomuser.me/api/portraits/women/44.jpg"
            },
            {
                author: "Jorge Luis Torres",
                content: "Servicio técnico rápido y eficiente. Solucionaron mi problema en el día.",
                img: "https://randomuser.me/api/portraits/men/45.jpg"
            },
            {
                author: "Sofía Castro",
                content: "Gran variedad de modelos y precios accesibles. Recomendado.",
                img: "https://randomuser.me/api/portraits/women/65.jpg"
            },
            {
                author: "Pedro Castillo",
                content: "La atención post-venta es lo mejor, siempre atentos a cualquier consulta.",
                img: "https://randomuser.me/api/portraits/men/22.jpg"
            },
            {
                author: "Lucía Fernández",
                content: "Compré repuestos para mi moto y son de muy buena calidad.",
                img: "https://randomuser.me/api/portraits/women/33.jpg"
            },
            {
                author: "Ricardo Morales",
                content: "Profesionales en movilidad eléctrica, me asesoraron muy bien.",
                img: "https://randomuser.me/api/portraits/men/11.jpg"
            },
            {
                author: "Valeria Guzman",
                content: "Estoy feliz con mi compra, la moto eléctrica es súper económica.",
                img: "https://randomuser.me/api/portraits/women/22.jpg"
            },
            {
                author: "Fernando Rios",
                content: "Trato amable y cordial. Definitivamente volveré.",
                img: "https://randomuser.me/api/portraits/men/67.jpg"
            },
            {
                author: "Gabriela Silva",
                content: "El mantenimiento preventivo dejó mi bicimoto como nueva.",
                img: "https://randomuser.me/api/portraits/women/11.jpg"
            },
            {
                author: "Andrés Vargas",
                content: "Buenos precios y facilidades de pago. Muy satisfecho.",
                img: "https://randomuser.me/api/portraits/men/54.jpg"
            },
            {
                author: "Patricia Rojas",
                content: "Me explicaron todo el funcionamiento con paciencia. Gracias!",
                img: "https://randomuser.me/api/portraits/women/55.jpg"
            },
            {
                author: "Manuel Chavez",
                content: "Rapidez en la entrega y producto tal cual la descripción.",
                img: "https://randomuser.me/api/portraits/men/33.jpg"
            },
            {
                author: "Rosa Martinez",
                content: "Excelente servicio, muy confiables.",
                img: "https://randomuser.me/api/portraits/women/66.jpg"
            },
            {
                author: "Javier Espinoza",
                content: "La mejor tienda de motos eléctricas de la zona.",
                img: "https://randomuser.me/api/portraits/men/12.jpg"
            },
            {
                author: "Carmen Vega",
                content: "Atención A1, resolvieron todas mis dudas antes de comprar.",
                img: "https://randomuser.me/api/portraits/women/77.jpg"
            },
            {
                author: "Roberto Nuñez",
                content: "Calidad garantizada, mi moto tiene un año y va perfecto.",
                img: "https://randomuser.me/api/portraits/men/76.jpg"
            },
            {
                author: "Elena Cruz",
                content: "Muy contenta con el servicio, son muy profesionales.",
                img: "https://randomuser.me/api/portraits/women/88.jpg"
            },
            {
                author: "Daniel Flores",
                content: "Recomiendo Celmovil por su seriedad y compromiso.",
                img: "https://randomuser.me/api/portraits/men/88.jpg"
            },
            {
                author: "Isabel Pardo",
                content: "Gran stock de accesorios, encontré justo lo que buscaba.",
                img: "https://randomuser.me/api/portraits/women/99.jpg"
            },
            {
                author: "Hector Salinas",
                content: "Eficiencia y buen trato, sigan así.",
                img: "https://randomuser.me/api/portraits/men/90.jpg"
            },
            {
                author: "Natalia Cabrera",
                content: "Me encanta mi moto, gracias por la recomendación.",
                img: "https://randomuser.me/api/portraits/women/12.jpg"
            },
            {
                author: "Oscar Paredes",
                content: "Servicio técnico especializado de verdad.",
                img: "https://randomuser.me/api/portraits/men/29.jpg"
            },
            {
                author: "Silvia Navarro",
                content: "Todo el proceso de compra fue muy sencillo y rápido.",
                img: "https://randomuser.me/api/portraits/women/23.jpg"
            },
            {
                author: "Raul Jimenez",
                content: "Excelente atención, muy recomendados.",
                img: "https://randomuser.me/api/portraits/men/15.jpg"
            }
        ];

        // Mezclar aleatoriamente al inicio
        testimonialsData.sort(() => 0.5 - Math.random());

        function getAvatar(name, img) {
            if (img && img.trim() !== "") return img;
            return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random&color=fff&size=100`;
        }

        const track = document.getElementById('dynamic-testimonials');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        let currentIndex = 0;
        let autoSlideInterval;

        function initCarousel() {
            let html = '';
            testimonialsData.forEach(t => {
                const avatar = getAvatar(t.author, t.img);
                html += `
                    <div class="card-wrapper">
                        <div class="card">
                            <img src="${avatar}" alt="${t.author}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin: 20px auto 0 auto; display: block;">
                            <div class="contenido">
                                <p>"${t.content}"</p>
                                <div class="autor">- ${t.author}</div>
                            </div>
                        </div>
                    </div>
                `;
            });
            track.innerHTML = html;
            updateCarousel();
            startAutoSlide();
        }

        function getVisibleCards() {
            if (window.innerWidth < 768) return 1;
            if (window.innerWidth < 1024) return 2;
            return 3;
        }

        function updateCarousel() {
            const visibleCards = getVisibleCards();
            const percentage = 100 / visibleCards;
            track.style.transform = `translateX(-${currentIndex * percentage}%)`;
        }

        function moveSlide(direction) {
            const visibleCards = getVisibleCards();
            const maxIndex = testimonialsData.length - visibleCards;

            currentIndex += direction;

            if (currentIndex < 0) {
                currentIndex = maxIndex;
            } else if (currentIndex > maxIndex) {
                currentIndex = 0;
            }

            updateCarousel();
        }

        function startAutoSlide() {
            stopAutoSlide();
            autoSlideInterval = setInterval(() => moveSlide(1), 4000);
        }

        function stopAutoSlide() {
            clearInterval(autoSlideInterval);
        }

        prevBtn.addEventListener('click', () => {
            moveSlide(-1);
            startAutoSlide();
        });

        nextBtn.addEventListener('click', () => {
            moveSlide(1);
            startAutoSlide();
        });

        // Pausar al pasar el mouse
        track.addEventListener('mouseenter', stopAutoSlide);
        track.addEventListener('mouseleave', startAutoSlide);

        // Ajustar al redimensionar
        window.addEventListener('resize', () => {
            // Asegurar que el índice no exceda el máximo permitido al cambiar tamaño
            const visibleCards = getVisibleCards();
            const maxIndex = testimonialsData.length - visibleCards;
            if (currentIndex > maxIndex) currentIndex = maxIndex;
            updateCarousel();
        });

        initCarousel();
    });
</script>

<style>
    .section-testimonio {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 90px 0px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: auto;
        background: linear-gradient(150deg, #c91003, #ff6600);
    }

    .testimonial-slider-container {
        width: 90%;
        max-width: 1200px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .testimonial-viewport {
        overflow: hidden;
        width: 100%;
        padding: 20px 0;
        /* Espacio para la sombra de las tarjetas */
    }

    .testimonios-track {
        display: flex;
        transition: transform 0.5s ease-in-out;
        width: 100%;
    }

    .card-wrapper {
        flex: 0 0 33.333%;
        padding: 0 15px;
        box-sizing: border-box;
    }

    @media (max-width: 1024px) {
        .card-wrapper {
            flex: 0 0 50%;
        }
    }

    @media (max-width: 768px) {
        .card-wrapper {
            flex: 0 0 100%;
        }
    }

    .testi-nav {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 10px;
        border-radius: 50%;
        z-index: 10;
        transition: background 0.3s;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .testi-nav:hover {
        background: rgba(255, 255, 255, 0.6);
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        /* Para que todas tengan la misma altura */
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }

    .imagen {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 4px solid #ff6600;
    }

    .contenido {
        padding: 20px;
        flex-grow: 1;
        /* Para empujar el autor hacia abajo si el texto es corto */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .contenido p {
        margin: 0;
        /* font-size: 1rem; */
        color: #555;
        line-height: 1.5;
    }

    .autor {
        margin-top: 10px;
        font-weight: bold;
        text-align: right;
        color: #ff6600;
    }

    @media (max-width: 600px) {
        .contenido {
            padding: 15px;
        }

        .imagen {
            height: 150px;
            /* Ajuste de altura para pantallas pequeñas */
        }
    }
</style>