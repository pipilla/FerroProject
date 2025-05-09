<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            font-size: 14px;
            color: #333;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .logo {
            max-height: 60px;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
        }

        .info {
            margin-bottom: 30px;
        }

        .info h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .info p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        thead {
            background-color: #f5f5f5;
        }

        tfoot td {
            font-weight: bold;
        }

        .total {
            font-size: 16px;
        }

        .details {
            margin-top: 20px;
        }

        .details-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .footer {
            margin-top: 60px;
            font-size: 12px;
            text-align: center;
            color: #999;
        }
    </style>
</head>

<body>

    <header>
        {{-- Aquí se puede poner el logo de la empresa --}}
        <div class="invoice-title">Factura #{{ $invoice->id }}</div>
    </header>

    <div class="info">
        <div style="float: left; width: 45%;">
            <h2>De: {{ $invoice->from }}</h2>
        </div>
        <div style="float: right; width: 45%; text-align: right;">
            <h2>Para: {{ $invoice->to }}</h2>
            <p><strong>Fecha:</strong> {{ $invoice->date }}</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Impuesto</th>
                <th>Precio unidad</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->concepts as $concept)
                <tr>
                    <td>{{ $concept->description }}</td>
                    <td>{{ $concept->quantity }}</td>
                    <td>{{ $concept->tax->value }}%</td>
                    <td>{{ number_format($concept->price, 2) }} €</td>
                    <td>
                        {{ number_format($concept->price * $concept->quantity + $concept->price * $concept->quantity * ($concept->tax->value / 100), 2) }}
                        €
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right;">Subtotal</td>
                <td>{{ number_format($subtotal, 2) }} €</td>
            </tr>
            @foreach ($taxes as $tax)
                <tr>
                    <td colspan="4" style="text-align: right;">{{ $tax['name'] }}</td>
                    <td>+ {{ number_format($tax['price'], 2) }} €</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="4" style="text-align: right;">Total</td>
                <td>{{ number_format($total, 2) }} €</td>
            </tr>
        </tfoot>
    </table>

    @if ($invoice->details != '')
        <div class="details">
            <p class="details-title">Detalles adicionales:</p>
            <p>{{ $invoice->details }}</p>
        </div>
    @endif

    <div class="footer">
        Esta factura ha sido generada automáticamente. Para más información, contacte con nosotros.
    </div>

</body>

</html>
