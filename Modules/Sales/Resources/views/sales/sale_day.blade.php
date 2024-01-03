<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <div>
            <div style="text-align: center">
                <h1>Reporte ventas del Día</h1>
            </div>
            <p><strong>Fecha:</strong> {{ $header['date'] }} </p>
            <p><strong>Usuario:</strong> {{ $header['user_name'] }} </p>
            <p><strong>Tienda:</strong> {{ $header['local_name'] }} </p>
        </div>
        <br>
        <div style="text-align: center">
            <h1>Productos Vendidos</h1>
        </div>
        <table style="width: 100%;border: 1px solid #000;border-collapse: collapse;">
            <tr>
                <td
                    style="text-align: center;
                vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    Imagen</td>
                <td
                    style="text-align: left;
                vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    Producto</td>
                <td
                    style="text-align: center;
                vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    Cantidad</td>
                <td
                    style="text-align: center;
                vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    Precio</td>
                <td
                    style="text-align: center;
                vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    Descuento</td>
                <td
                    style="text-align: center;
                vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    Importe</td>
            </tr>
            @php
                $total_p = 0;
            @endphp
            @foreach ($products as $product)
                <tr>
                    <td
                        style="text-align: center;vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                        <img src="{{ asset('storage/' . $product->image) }}" width="80px" />
                    </td>
                    <td
                        style="vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                        @if ($product->presentations)
                            {{ $product->interne . ' - ' . $product->description . ' / ' . json_decode($product->product, true)['size'] }}
                        @else
                            {{ $product->interne . ' - ' . $product->description }}
                        @endif
                    </td>
                    <td
                        style="text-align: right;vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                        {{ $product->quantity }}</td>
                    <td
                        style="text-align: right;vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                        {{ $product->price }}</td>
                    <td
                        style="text-align: right;vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                        {{ $product->discount }}</td>
                    <td
                        style="text-align: right;vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                        {{ $product->total }}</td>
                </tr>
                @php
                    $total_p = $total_p + $product->total;
                @endphp
            @endforeach
            <tr>
                <td colspan="5"
                    style="text-align: right;vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    Total Vendido</td>
                <td
                    style="text-align: right;vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    {{ number_format($total_p, 2, '.', ',') }}</td>

            </tr>
        </table>
        <br>
        <div style="text-align: center">
            <h1>Documentos Emitidos</h1>
        </div>

        @php
            $total = 0;
            $ssale = '';
        @endphp
        @foreach ($sales as $k => $sale)
            @if ($ssale != $sale->id)
                <table style="width: 100%;border: 1px solid #000;border-collapse: collapse;background:#D5D6D1">
                    <tr>
                        <td
                            style="text-align: left;
                    vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                            Documento</td>
                        <td
                            style="text-align: left;
                    vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                            Cliente</td>
                        <td
                            style="text-align: left;
                    vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                            Vendedor</td>
                        <td
                            style="text-align: left;
                    vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                            Total</td>
                    </tr>
                    <tr>
                        <td
                            style="vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                            {{ $sale->description }} - {{ $sale->number }}</td>
                        <td
                            style="vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                            {{ $sale->full_name }}</td>
                        <td
                            style="vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                            @if ($sale->seller_name)
                                {{ $sale->seller_name }}
                            @else
                                {{ $sale->user_name }}
                            @endif
                        </td>
                        <td
                            style="text-align: right;vertical-align: top;
                    border: 1px solid #000;
                    border-collapse: collapse;
                    padding: 0.3em;
                    caption-side: bottom;">
                            {{ $sale->total }}</td>
                    </tr>
                    <tr>
                        <th colspan="4" style="padding: 0.3em;text-align: center">Detalles De Venta</th>
                    </tr>
                    @foreach ($sales as $products)
                        @if ($sale->id == $products->id)
                            <tr>
                                <td colspan="2" style="padding: 0.3em;text-align: left">Producto: </td>
                                <td style="padding: 0.3em;text-align: center">{{ $products->interne }}
                                    <p> {{ $products->product_description }}
                                        @if ($product->presentations)
                                            / {{ json_decode($products->product, true)['size'] }}
                                        @endif
                                    </p>
                                </td>
                                <td style="padding: 0.3em;text-align: right">{{ $products->product_total }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <th colspan="4" style="padding: 0.3em;text-align: center">Pagos</th>
                    </tr>
                    @foreach (json_decode($sale->payments) as $payment)
                        <tr>
                            <td colspan="2" style="padding: 0.3em;text-align: left">
                                @foreach ($payments as $rr)
                                    @if ($payment->type == $rr->id)
                                        <b>{{ $rr->description }}</b>
                                    @endif
                                @endforeach
                            </td>
                            <td style="padding: 0.3em;text-align: left">{{ $payment->reference }}</td>
                            <td style="padding: 0.3em;text-align: right">
                                {{ number_format($payment->amount, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                    @php
                        $total = $total + $sale->total;
                    @endphp
            @endif
            @php
                $ssale = $sale->id;

            @endphp
            </table>
            <br>
        @endforeach
        <table style="width: 100%;border: 1px solid #000;border-collapse: collapse;">
            <tr>
                <td
                    style="text-align: right;vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    Total venta del dia</td>
                <td
                    style="text-align: right;vertical-align: top;
                border: 1px solid #000;
                border-collapse: collapse;
                padding: 0.3em;
                caption-side: bottom;">
                    {{ number_format($total, 2, '.', ',') }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
