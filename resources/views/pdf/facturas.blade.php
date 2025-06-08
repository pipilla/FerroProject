<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura{{ $invoice->id }}_{{ $invoice->to }}_{{ $invoice->date }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            font-size: 14px;
            color: #333;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 12px;
            color: #313131;
        }

        .logo {
            max-height: 60px;
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

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>

    <header>
        <div class="invoice-title">Factura #{{ $invoice->id }}</div>
    </header>

    <section>
        {{-- Info de empresa a la izquierda --}}
        <div style="float: left; width: 45%;">
            <h1 style="margin: 0;">FerroProject S.L.</h1>
            <p style="margin: 2px 0;">Avda América, S/N</p>
            <p style="margin: 2px 0;">Almería, España - 04005</p>
        </div>

        {{-- Logo a la derecha --}}
        <div style="float: right; width: 50%; max-height: 90px; text-align: right; margin-left: auto;">
            <img src="{{ public_path('storage/assets/logo.svg') }}" alt="Logo"
                style="height: 160px; max-width: 160px; display: block; margin-left: auto; margin-right: 0px;">
        </div>

        <div style="clear: both;"></div>

        <div style="border-bottom: 1px solid #ccc; margin-top: -200px; margin-bottom: 20px;"></div>
    </section>


    <section class="info">
        <div style="float: left; width: 45%;">
            <h2>Destinatario: {{ $invoice->to }}</h2>
        </div>
        <div style="float: right; width: 45%; text-align: right;">
            <p><strong>Fecha:</strong> {{ $invoice->date }}</p>
        </div>
        <div style="clear: both;"></div>
    </section>

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

    <footer>
        Esta factura ha sido generada automáticamente. Para más información, contacte con nosotros.
    </footer>

</body>

</html>
