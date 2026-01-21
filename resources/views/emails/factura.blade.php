<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura de Venta</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .barra {
            height: 10px;
            background: #e10600;
        }

        .contenedor {
            padding: 15px 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* ENCABEZADO */
        .header td {
            vertical-align: top;
        }

        .logo-box {
            border: 1px dashed #ccc;
            width: 160px;
            height: 80px;
            text-align: center;
            line-height: 80px;
            margin-bottom: 8px;
        }

        .logo-box img {
            max-width: 100%;
            max-height: 100%;
        }

        .empresa {
            font-size: 11px;
            line-height: 1.4;
        }

        .factura-info {
            text-align: right;
            font-size: 11px;
        }

        .titulo {
            font-size: 22px;
            font-weight: bold;
            color: #e10600;
        }

        /* CLIENTE */
        .datos-cliente {
            margin-top: 15px;
            border: 1px solid #ddd;
        }

        .datos-cliente td {
            padding: 6px;
            font-size: 11px;
        }

        .datos-cliente strong {
            color: #444;
        }

        /* ITEMS */
        .items {
            margin-top: 15px;
        }

        .items th {
            background: #e10600;
            color: #fff;
            padding: 7px;
            font-size: 11px;
            border: 1px solid #999;
        }

        .items td {
            padding: 7px;
            border: 1px solid #999;
            font-size: 11px;
        }

        .right {
            text-align: right;
        }

        /* TOTALES */
        .totales {
            margin-top: 10px;
            width: 40%;
            float: right;
        }

        .totales td {
            padding: 6px;
            font-size: 11px;
        }

        .totales .label {
            text-align: right;
            font-weight: bold;
        }

        .total-final {
            background: #fff2b3;
            font-weight: bold;
            font-size: 13px;
        }

        /* FOOTER */
        .footer {
            clear: both;
            margin-top: 25px;
            text-align: center;
            font-size: 10px;
            color: #555;
        }

        .barra-bottom {
            height: 10px;
            background: #e10600;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<div class="barra"></div>

<div class="contenedor">

    <!-- ENCABEZADO -->
    <table class="header">
        <tr>
<<<<<<< HEAD
            <td>
                {{-- Logo --}}
                {{-- <img src="{{ public_path('imagenes/logo1.png') }}" class="logo"> --}}
                <strong>MI EMPRESA S.A.S</strong><br>
                NIT: 900.000.000-1<br>
                Dirección:cra 4 N 34-29 brr Cañarte, Pereira, Risaralda<br>
                Tel: 3216234420
=======
            <td width="60%">
                <!-- SECCIÓN LOGO -->
                <div class="logo-box">
                   <img src="{{ public_path('storage/logo1.png') }}" alt="Logo">


                </div>

                <div class="empresa">
                    <strong>TALLER AUTOMOTRIZ RALLYCARS PEREIRA</strong><br>
                    NIT 1.113.786.771<br>
                    Cra 4 # 34-29 Barrio Cañarte – Pereira<br>
                    Tel: 321 623 4420<br>
                    rallycarspereira@gmail.com
                </div>
            </td>

            <td width="40%" class="factura-info">
                <div class="titulo">FACTURA DE VENTA</div><br>

                <strong>Fecha:</strong> {{ $factura['fecha'] ?? date('d/m/Y') }}<br>
                <strong>N° Factura:</strong> {{ $factura['numero'] ?? '' }}
            </td>
        </tr>
    </table>

    <!-- DATOS CLIENTE -->
    <table class="datos-cliente">
        <tr>
            <td><strong>Cliente:</strong> {{ $cliente['nombre'] ?? '' }}</td>
            <td><strong>Cédula:</strong> {{ $cliente['cedula'] ?? '' }}</td>
        </tr>
        <tr>
            <td><strong>Placa:</strong> {{ $cliente['placa'] ?? '' }}</td>
            <td><strong>Teléfono:</strong> {{ $cliente['telefono'] ?? '' }}</td>
        </tr>
    </table>

    <!-- DETALLE -->
    <table class="items">
        <thead>
            <tr>
                <th>Descripción</th>
                <th width="80">Cant.</th>
                <th width="120">Valor Unit.</th>
                <th width="120">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item['descripcion'] }}</td>
                    <td class="right">{{ $item['cantidad'] }}</td>
                    <td class="right">$ {{ number_format($item['precio'], 0, ',', '.') }}</td>
                    <td class="right">
                        $ {{ number_format($item['cantidad'] * $item['precio'], 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTALES -->
    <table class="totales">
        <tr>
            <td class="label">Subtotal</td>
            <td class="right">$ {{ number_format($totales['subtotal'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">IVA</td>
            <td class="right">$ {{ number_format($totales['iva'], 0, ',', '.') }}</td>
        </tr>
        <tr class="total-final">
            <td class="label">TOTAL</td>
            <td class="right">$ {{ number_format($totales['total'], 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        EL MEJOR ALIADO PARA TU VEHÍCULO
    </div>

</div>

<div class="barra-bottom"></div>

</body>
</html>