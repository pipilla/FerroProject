<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1f2937;
            font-size: 14px;
            margin: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .header h1 {
            display: flex;
            align-items: center;
        }

        .header p {
            font-size: 18px;
            font-weight: bold;
            margin-left: 8px;
        }

        .section {
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            text-align: left;
            margin-bottom: 24px;
        }

        thead {
            background-color: #f3f4f6;
            text-transform: uppercase;
            font-size: 12px;
            color: #374151;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 12px 16px;
        }

        tbody tr {
            background-color: #ffffff;
        }

        tfoot {
            background-color: #f9fafb;
        }

        tfoot th {
            text-align: right;
            font-weight: 600;
        }

        tfoot td {
            font-weight: 600;
        }

        .total-row th, .total-row td {
            font-size: 18px;
            font-weight: bold;
        }

        .details-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
        }
    </style>
</head>
<body>

    <div class="section header">
        <h3>De: {{ $invoice->from }}</h3>
        <h3>Fecha: {{ $invoice->date }}</h3>
    </div>

    <div class="section">
        <h3>Para: {{ $invoice->to }}</h3>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Impuesto %</th>
                <th>Precio unidad</th>
                <th>Precio</th>
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
                    {{ number_format($concept->price * $concept->quantity + $concept->price * $concept->quantity * ($concept->tax->value / 100), 2) }} €
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Subtotal</th>
                <td>{{ number_format($subtotal, 2) }} €</td>
            </tr>
            @foreach ($taxes as $tax)
            <tr>
                <th colspan="4">{{ $tax['name'] }}</th>
                <td>+ {{ number_format($tax['price'], 2) }} €</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <th colspan="4">Total</th>
                <td>{{ number_format($total, 2) }} €</td>
            </tr>
        </tfoot>
    </table>

    @if ($invoice->details != '')
    <div class="section">
        <p class="details-title">Detalles:</p>
        <p>{{ $invoice->details }}</p>
    </div>
    @endif

</body>
</html>
