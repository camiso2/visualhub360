<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>FACTURA #{{ $sale->invoice_number ?? $sale->id }}</title>
    <style>
        /* ----------------------------------------------------- */
        /* BASE & TYPOGRAPHY */
        /* ----------------------------------------------------- */
        body {
            font-family: 'Helvetica', Arial, sans-serif; /* Helvetica es más limpio */
            font-size: 10px; /* Reducir ligeramente la base para más espacio */
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            margin: auto;
            padding: 25px; /* Más padding para aire */
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* ----------------------------------------------------- */
        /* HEADER & FACTURA ID */
        /* ----------------------------------------------------- */
        .header {
            width: 100%;
            margin-bottom: 30px;
            overflow: auto; /* Para contener los floats */
        }
        .logo {
            float: left;
            width: 50%;
        }
        .invoice-id {
            float: right;
            width: 45%;
            background-color: #004080; /* Azul oscuro corporativo */
            color: #ffffff;
            padding: 15px;
            border-radius: 4px;
        }
        .invoice-id h1 {
            font-size: 18px;
            margin: 0;
            font-weight: normal;
        }
        .invoice-id strong {
            font-size: 20px;
            display: block;
            margin-top: 5px;
        }
        .company-details {
            font-size: 11px;
            color: #555;
            line-height: 1.5;
            margin-top: 10px;
            float: left;
            width: 50%;
        }
        .company-details strong { font-weight: bold; color: #333; display: block; margin-bottom: 5px; font-size: 16px;text-transform: uppercase }

        /* ----------------------------------------------------- */
        /* SECTION BOXES (CLIENTE / FACTURA INFO) */
        /* ----------------------------------------------------- */
        .details-box {
            width: 100%;
            margin-bottom: 25px;
            clear: both;
        }
        .box-column {
            width: 45%;
            float: left;
            margin-right: 4%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-height: 80px;
        }
        .box-column.right {
            float: right;
            margin-right: 0;
        }
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #004080; /* Color corporativo */
            text-transform: uppercase;
            margin-bottom: 8px;
            padding-bottom: 3px;
            border-bottom: 1px dashed #ccc; /* Línea de separación suave */
        }
        .detail-item { line-height: 1.6; }
        .detail-item strong { width: 90px; display: inline-block; font-weight: bold; color: #333; }

        /* ----------------------------------------------------- */
        /* ITEMS TABLE */
        /* ----------------------------------------------------- */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .items-table th, .items-table td {
            border: 1px solid #eee; /* Borde más suave */
            padding: 10px 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #004080; /* Fondo de encabezado corporativo */
            color: #ffffff;
            font-weight: normal;
            font-size: 11px;
            text-transform: uppercase;
        }
        .items-table td {
            font-size: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        .items-table tr:nth-child(even) {
            background-color: #fcfcfc; /* Zebra suave */
        }

        /* ----------------------------------------------------- */
        /* TOTALS SECTION */
        /* ----------------------------------------------------- */
        .total-container {
            width: 100%;
            overflow: auto;
            margin-top: 20px;
        }
        .total-section {
            width: 250px; /* Ancho ajustado */
            float: right;
        }
        .total-row {
            padding: 5px 0;
            overflow: auto;
        }
        .total-row .label {
            float: left;
            font-weight: normal;
            color: #555;
            font-size: 11px;
        }
        .total-row .value {
            float: right;
            font-weight: bold;
            color: #333;
            font-size: 11px;
        }
        .grand-total {
            background-color: #004080; /* Color de fondo corporativo */
            color: #ffffff !important;
            padding: 10px !important;
            margin-top: 10px;
            border-radius: 4px;
            height: 25px !important
        }
        .grand-total .label, .grand-total .value {
            font-size: 14px;
            font-weight: bold;
            color: #ffffff !important;
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="header">
            <div class="logo">
                <div class="company-details">
                    <strong>{{ $company->name ?? 'NOMBRE DE LA COMPAÑÍA' }}</strong>
                    {{ $company->address ?? '' }} <br>
                    NIT: {{ $company->document_number ?? 'N/A' }} <br>
                    Contacto: {{ $company->phone ?? '' }} <br>
                    Email: {{ $company->email ?? '' }}
                </div>
            </div>

            <div class="invoice-id">
                <h1>FACTURA DE VENTA</h1>
                <strong># {{ $sale->invoice_number ?? 'REC-' . $sale->id }}</strong>
            </div>
        </div>

        <div style="clear: both; border-top: 1px solid #ddd; margin-bottom: 25px;"></div>

        <div class="details-box">

            <div class="box-column">
                <div class="section-title">DETALLES DE LA TRANSACCIÓN</div>
                <div class="detail-item"><strong>Fecha de Venta:</strong> {{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d H:i') }}</div>
                <div class="detail-item"><strong>Método de Pago:</strong> {{ $sale->payment_method ?? 'N/A' }}</div>
                <div class="detail-item"><strong>Vendedor:</strong> {{ $sale->user->name ?? 'N/A' }}</div>
            </div>

            <div class="box-column right">
                <div class="section-title">CLIENTE</div>
                <div class="detail-item"><strong>Nombre:</strong> {{ $client->name ?? 'Consumidor Final' }}</div>
                <div class="detail-item"><strong>Documento:</strong> {{ $client->document_number ?? 'N/A' }}</div>
                <div class="detail-item"><strong>Teléfono:</strong> {{ $client->phone ?? 'N/A' }}</div>
                <div class="detail-item"><strong>Dirección:</strong> {{ $client->address ?? 'N/A' }}</div>
            </div>
        </div>

        <div style="clear: both;"></div>

        <div style="margin-top: 25px;">
            <div class="section-title">DETALLE DE LOS PRODUCTOS/SERVICIOS</div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 45%;">Descripción</th>
                    <th style="width: 10%;" class="text-center">Cant.</th>
                    <th style="width: 15%;" class="text-right">P. Unitario</th>
                    <th style="width: 10%;" class="text-right">Desc.(%)</th>
                    <th style="width: 20%;" class="text-right">Total Producto</th>
                </tr>
            </thead>
            <tbody>
                @foreach($saleItems as $item)
                <tr>
                    <td>{{ $item->inventory->name ?? $item->sku }}</td>
                    <td class="text-center">{{ number_format($item->quantity, 0) }}</td>
                    <td class="text-right">$ {{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ number_format(($item->discount_applied / ($item->quantity * $item->unit_price)) * 100 ?? 0, 2) }}%</td>
                    <td class="text-right">$ {{ number_format($item->line_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-container">
            <div class="total-section">

                <div class="total-row">
                    <span class="label">Subtotal:</span>
                    <span class="value">$ {{ number_format($sale->total_amount, 2) }}</span>
                </div>
                <div class="total-row">
                    <span class="label">Descuento:</span>
                    <span class="value">-$ {{ number_format($sale->discount_amount, 2) }}</span>
                </div>
                <div class="total-row">
                    <span class="label">Impuestos (IVA/Otros):</span>
                    <span class="value">$ {{ number_format($sale->tax_amount, 2) }}</span>
                </div>
                <div class="total-row grand-total">
                    <span class="label">TOTAL A PAGAR:</span>
                    <span class="value">$ {{ number_format($sale->grand_total, 2) }}</span>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
