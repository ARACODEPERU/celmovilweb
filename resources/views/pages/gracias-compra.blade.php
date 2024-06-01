@extends('layouts.celmovil')
@section('content')
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    <!-- page banner area start -->
    <div class="page-banner">
        <img width="800px" src="https://www.pinfuvote.net/wp-content/uploads/2020/04/gracias-por-tu-compra.jpg"
            alt="Page Banner" />
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
                                    <th>Productos Adquiridos</th>
                                    <th>Cantidad</th>
                                    <th>QTY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->details as $detail)
                                    <tr>
                                        <td class="td-img text-left">
                                            <a href="#">
                                                <img style="width: 100px;" src="{{ $detail->item->image }}"
                                                    alt="Add Product" />
                                            </a>
                                            <div class="">
                                                <p>
                                                    {{ $detail->item->name }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <p>{{ $detail->quantity }}</p>
                                        </td>
                                        <td>S/ {{ $detail->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div id="statusScreenBrick_container"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart page content section end -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        const mp = new MercadoPago("{{ env('MERCADOPAGO_KEY') }}", {
            locale: 'es-PE'
        });
        const bricksBuilder = mp.bricks();
        const renderStatusScreenBrick = async (bricksBuilder) => {
            const settings = {
                initialization: {
                    paymentId: "{{ $sale->mercado_payment_id }}", // Payment identifier, from which the status will be checked
                },
                customization: {
                    visual: {
                        hideStatusDetails: true,
                        hideTransactionDate: true,
                        style: {
                            theme: 'bootstrap', // 'default' | 'dark' | 'bootstrap' | 'flat'
                        }
                    },
                    backUrls: {
                        'error': "{{ route('web_error_al_comprar', $sale->id) }}",
                        'return': "{{ route('cms_principal') }}"
                    }
                },
                callbacks: {
                    onReady: () => {
                        // Callback called when Brick is ready
                    },
                    onError: (error) => {
                        // Callback called for all Brick error cases
                    },
                },
            };
            window.statusScreenBrickController = await bricksBuilder.create('statusScreen',
                'statusScreenBrick_container', settings);
        };
        renderStatusScreenBrick(bricksBuilder);
    </script>
    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
