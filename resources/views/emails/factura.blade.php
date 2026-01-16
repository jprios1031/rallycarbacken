<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
            color: #333;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
        }

        .company-info {
            text-align: right;
            font-size: 12px;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #999;
            padding: 6px;
            font-size: 11px;
        }

        .items-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .total-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .total-table td {
            padding: 6px;
            font-size: 12px;
        }

        .total-table .label {
            text-align: right;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #e00707;
        }
    </style>
</head>
<body>

    {{-- ENCABEZADO --}}
    <table class="header">
        <tr>
            <td>
                {{-- Logo --}}
                {{-- <img src="{{ public_path('imagenes/logo.png') }}" class="logo"> --}}
                <strong>MI EMPRESA S.A.S</strong><br>
                NIT: 900.000.000-1<br>
                Dirección:cra 4 N 34-29 brr Cañarte, Pereira, Risaralda<br>
                Tel: 3216234420
            </td>
            <td class="company-info">
                <strong>Factura Nº:</strong> {{ $factura['numero'] ?? NULL }}<br>
                <strong>Fecha:</strong> {{ $factura['fecha'] ?? date('Y-m-d') }}<br>
               
            </td>
        </tr>
    </table>

    {{-- TITULO --}}
    <div class="title">FACTURA DE VENTA</div>

    {{-- DATOS CLIENTE --}}
    <table class="info-table">
        {{-- <tr>
            <td><strong>Cliente:</strong> {{ $user['nombre'] ?? 'Cliente genérico' }}</td>
            <td><strong>Documento:</strong> {{ $cliente['documento'] ?? '123456789' }}</td>
        </tr> --}}
        {{-- <tr>
            <td><strong>Dirección:</strong> {{ $cliente['direccion'] ?? 'N/A' }}</td>
            <td><strong>Ciudad:</strong> {{ $cliente['ciudad'] ?? 'N/A' }}</td>
        </tr> --}}
    </table>

    {{-- DETALLE --}}
    <table class="items-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Descripción</th>
                <th>Cant.</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $i => $item)
                <tr>
                    <td class="right">{{ $i + 1 }}</td>
                    <td>{{ $item['tipo'] }}</td>
                    <td class="right">{{ $item['descripcion'] }}</td>
                    <td class="right">
                        $ {{ number_format($item['precio'], 0, ',', '.') }}
                    </td>
                    <td class="right">
                        $ {{ number_format($item['cantidad'] * $item['precio'], 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTALES --}}
    <table class="total-table">
        <tr>
            <td class="label" width="80%">Subtotal:</td>
            <td class="right">
                $ {{ number_format($totales['subtotal'], 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td class="label">IVA ({{ $totales['iva_porcentaje'] }}%):</td>
            <td class="right">
                $ {{ number_format($totales['iva'], 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td class="label">TOTAL A PAGAR:</td>
            <td class="right">
                <strong>
                    $ {{ number_format($totales['total'], 0, ',', '.') }}
                </strong>
            </td>
        </tr>
    </table>

    {{-- PIE --}}
    <div class="footer">
        Gracias por su compra<br>
        Documento generado electrónicamente
    </div>

</body>
</html>
