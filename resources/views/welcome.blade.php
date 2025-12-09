<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>VisualHub360</title>

    @vite(['resources/js/app.js', 'resources/css/app.css'])


    <style>
        body {
            font-family: 'Poppins', sans-serif;
            /* Usamos Poppins para un toque más moderno */
            background: linear-gradient(to right bottom, #e0e7ff, #f0f4f8);
            /* Degradado suave de fondo */
            justify-content: center;
            align-items: center;
            margin: 0;
            box-sizing: border-box;
            height: 100%;

        }

        *::-webkit-scrollbar {
            width: 2px;
        }

        *::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 5px;
        }

        *::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 5px;
        }

        *::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }


        /* Estilo para el botón con degradado */
        .gradient-button {
            background-image: linear-gradient(to right, #4F46E5 0%, #8B5CF6 51%, #4F46E5 100%);
            background-size: 200% auto;
            color: white;
            transition: 0.5s;
            border-radius: 8px;
        }

        .gradient-button:hover {
            background-position: right center;
            /* Cambia el degradado al pasar el mouse */
            color: #fff;
            text-decoration: none;
        }


        .coompany-title-color {
            color: #4F46E5 !important;
            /* Color púrpura para el título */
        }

          .upper-all {
        /*text-transform: uppercase;*/
         text-transform: capitalize;
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="antialiased">
    <div id="app"> Loading....</div>
</body>

</html>
