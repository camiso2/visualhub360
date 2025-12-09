<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Etiquetas de Códigos de Barras</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 5px;
        }

        /* Contenedor Principal: Usa table-layout: fixed */
        .barcode-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 0;
        }

        /* Celda de la Etiqueta (Fijar el área) */
        .label-cell {
            width: 33.333%;
            padding: 2px;
            text-align: center;
            vertical-align: top;
        }

        /* Contenido de la Etiqueta (Aquí definimos la altura real) */
        .label-content {
            height: 60px;
            /* Altura Fija de la Etiqueta */
            border: 1px solid #ddd;
            padding: 3px 0;
            box-sizing: border-box;

            /* VITAL: Evita que DOMPDF rompa esta sección */
            page-break-inside: avoid;
        }

        /* Contenido interno */
        h4 {
            font-size: 9px;
            font-weight: bold;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 0 2px;
        }

        p {
            font-size: 8px;
            margin: 1px 0 0 0;
        }

        img {
            display: block;
            margin: 0 auto;
            width: 95%;
            height: 35px;
            /* Altura del código de barras */
        }

        .header {
            width: 100%;
            margin-bottom: 30px;
            overflow: auto;
            /* Para contener los floats */
        }

        .company-details {
            font-size: 11px;
            color: #555;
            line-height: 1.5;
            margin-top: 10px;

            width: 50%;
        }

        .company-details strong {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
            font-size: 22px;
            text-transform: uppercase
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <div class="logo">

                <div class="company-details">
                    <strong>{{ $company->name }}</strong><br>
                    {{ $company->address }}<br>
                    NIT: {{ $company->document_number }}<br>
                    Tel: {{ $company->phone }}<br>
                    Email: {{ $company->email }}

                </div>

            </div>
        </div>
    </div>


    <table class="barcode-table">
        @php $column = 0; @endphp

        @foreach ($barcodes as $index => $barcode)
            @if ($column === 0)
                <tr>
            @endif

            <td class="label-cell">
                <div class="label-content">
                    <h4>{{ $barcode['name'] }}</h4>
                    <img src="{{ $barcode['barcode_base64_src'] }}" alt="SKU: {{ $barcode['sku'] }}">
                    <p>{{ $barcode['sku'] }}</p>
                </div>
            </td>

            @php $column++; @endphp

            @if ($column === 3)
                </tr>
                @php $column = 0; @endphp
            @endif
        @endforeach

        @if ($column > 0)
            @while ($column < 3)
                <td class="label-cell"></td>
                @php $column++; @endphp
            @endwhile
            </tr>
        @endif
    </table>




</body>

</html>
