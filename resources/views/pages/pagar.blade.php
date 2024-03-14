@extends('layouts.celmovil')
@section('content')
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <!-- page banner area start -->
    <div class="page-banner">
        <img src="{{ asset('themes/celmovil/img/slider/bg3.jpg') }}" alt="Page Banner" />
    </div>
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
                        <p style="color: orange; font-size: 16px;"><b>S/. {{ $total }}</b></p>
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
