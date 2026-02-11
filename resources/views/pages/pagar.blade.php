@extends('layouts.celmovil')
@section('content')
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <!-- page banner area start -->
    <section class="page-header-modern">
        <div class="container">
            <div class="header-content text-center">
                <h1 class="modern-title-large">
                    REALIZAR <span>PAGO ONLINE</span>
                </h1>
                <div class="title-line-large"></div>
                <p class="header-description">
                    Revisa los productos que has seleccionado antes de finalizar tu compra.
                    <br>¡Estás a un paso de tener lo mejor en tecnología!
                </p>
            </div>
        </div>
        <div class="shape circle-1"></div>
        <div class="shape circle-2"></div>
    </section>

    <style>
        /* Title Styles */
        .page-header-modern {
            position: relative;
            padding: 160px 0 80px;
            /* Espacio superior para compensar el header fijo */
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            overflow: hidden;
            color: white;
            margin-top: 0;
        }

        .page-header-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 80% 20%, rgba(255, 102, 0, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(37, 211, 102, 0.1) 0%, transparent 50%);
            z-index: 1;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .modern-title-large {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 15px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .modern-title-large span {
            background: linear-gradient(to right, #ff6600, #ff9933);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .title-line-large {
            width: 100px;
            height: 6px;
            background: #ff6600;
            margin: 0 auto 25px;
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(255, 102, 0, 0.5);
        }

        .header-description {
            font-size: 1.2rem;
            color: #e5e7eb;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            background: rgba(255, 102, 0, 0.1);
            top: -50px;
            left: -50px;
        }

        .circle-2 {
            width: 400px;
            height: 400px;
            background: rgba(59, 130, 246, 0.05);
            bottom: -100px;
            right: -100px;
        }

        @media (max-width: 768px) {
            .page-header-modern {
                padding: 140px 0 60px;
            }

            .modern-title-large {
                font-size: 2.5rem;
            }
        }
    </style>
    <!-- page banner area end -->

    <!-- cart page content section start -->
    <section class="cart-page section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive table-one margin-minus section-padding-bottom">
                        <table class="spacing-table text-center">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($products) > 0)
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="td-img text-left">
                                                <a href="#">
                                                    <img style="width: 100px;" src="{{ $product['image'] }}"
                                                        alt="Add Product" />
                                                </a>
                                                <div class="">
                                                    <p>
                                                        <a href="#">{{ $product['name'] }}</a><br>
                                                        <b>Color:</b> Negro
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <p>{{ $product['quantity'] }}</p>
                                            </td>
                                            <td>S/ {{ $product['total'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="padding: 20px; background: #f8f8f8;">
                        <h3>Registra tu pago</h3>
                        <p>Agradecemos su preferencia por nuestros productos. Por favor, proceda a registrar sus datos para
                            confirmar la compra.</p>
                        <br>
                        <h4>Total:</h4>
                        <p style="color: orange; font-size: 16px;"><b>S/ {{ $total }}</b></p>
                    </div>
                    <div id="cardPaymentBrick_container"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart page content section end -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @if ($preference)
        <script>
            const mp = new MercadoPago("{{ env('MERCADOPAGO_KEY') }}", {
                locale: 'es-PE'
            });
            const bricksBuilder = mp.bricks();
            const renderCardPaymentBrick = async (bricksBuilder) => {
                const settings = {
                    initialization: {
                        preferenceId: "{{ $preference }}",
                        amount: {{ $total }},
                    },
                    customization: {
                        visual: {
                            style: {
                                customVariables: {
                                    theme: 'bootstrap',
                                }
                            }
                        },
                        paymentMethods: {
                            maxInstallments: 1,
                        }
                    },
                    callbacks: {
                        onReady: () => {
                            // callback llamado cuando Brick esté listo
                        },
                        onSubmit: (cardFormData) => {
                            //  callback llamado cuando el usuario haga clic en el botón enviar los datos
                            //  ejemplo de envío de los datos recolectados por el Brick a su servidor
                            return new Promise((resolve, reject) => {
                                fetch("{{ route('web_process_payment', $sale_id) }}", {
                                        method: "PUT",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify(cardFormData)
                                    })
                                    .then((response) => {
                                        if (!response.ok) {
                                            return response.json().then(error => {
                                                throw new Error(error.error);
                                            });
                                        }
                                        return response.json();

                                    })
                                    .then((data) => {
                                        if (data.status == 'approved') {
                                            window.location.href = data.url;
                                        } else {
                                            alert('No se pudo continuar el proceso');
                                            window.location.href = data.url;
                                        }
                                    })
                                    .catch((error) => {
                                        if (error instanceof SyntaxError) {
                                            // Si hay un error de sintaxis al analizar la respuesta JSON
                                            alert('Error al procesar el pago.');
                                        } else {
                                            // Mostrar la alerta con el mensaje de error devuelto por el backend
                                            alert(error.message);
                                        }
                                    })
                            });
                        },
                        onError: (error) => {
                            console.log(error)
                        },
                    },
                };
                window.cardPaymentBrickController = await bricksBuilder.create('cardPayment',
                    'cardPaymentBrick_container', settings);
            };
            renderCardPaymentBrick(bricksBuilder);
        </script>
    @endif
    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
