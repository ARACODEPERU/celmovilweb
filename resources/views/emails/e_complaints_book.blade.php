<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Celmovil | Libro de reclamaciones</title>

    <!--Google Fonts-->
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"> --}}

    <style>
        * {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }

        *:after,
        *:before {
            box-sizing: border-box;
        }

        .bienvenida {
            padding: 50px 10px 0px 10px;
        }

        /* Establece el ancho al 100% y la altura a 250px */
        .banner {
            width: 100%;
            background-color: #3498db;
            /* Cambia el color de fondo según tus preferencias */
            /* Puedes agregar más estilos según tus necesidades */
        }


        img {
            max-width: 100%;
            display: block;
        }

        .icon-button {
            border: 0;
            background-color: #fff;
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
            font-size: 1.25rem;
            transition: 0.25s ease;
            box-shadow: 0 0 0 1px rgba(#000, 0.05), 0 3px 8px 0 rgba(#000, 0.15);
            z-index: 1;
            cursor: pointer;
            color: #565656;

            svg {
                width: 1em;
                height: 1em;
            }

            &:hover,
            &:focus {
                background-color: #ec4646;
                color: #fff;
            }
        }

        .card-footer {
            margin-top: 1.25rem;
            border-top: 1px solid #ddd;
            padding-top: 1.25rem;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .card-meta {
            display: flex;
            align-items: center;
            color: #787878;

            &:first-child:after {
                display: block;
                content: "";
                width: 4px;
                height: 4px;
                border-radius: 50%;
                background-color: currentcolor;
                margin-left: 0.75rem;
                margin-right: 0.75rem;
            }

            svg {
                flex-shrink: 0;
                width: 1em;
                height: 1em;
                margin-right: 0.25em;
            }
        }

        .subTitle {
            text-align: center;
            font-size: 25px;
            color: #808080;
        }

        .title {
            text-align: center;
            font-size: 40px;
            font-weight: 700;
            color: #0c161f;
        }

        h3{
            color: #ff8607;
        }

        /* Estilos para la línea */
        .linea {
            border: 2px solid #ff8607;
            /* Cambia el grosor y el color de la línea según tus preferencias */
            margin: 10px auto;
            /* Centra la línea horizontalmente y agrega espacio vertical */
            width: 5%;
            /* Establece el ancho de la línea al 50% de la página */
        }


        .contenedor {
            place-items: center;
            /* Esto centra tanto horizontal como verticalmente */
            margin: 0px auto;
            width: 60%;
            display: flex;
            flex-wrap: wrap;
        }

        .contenedor-texto {
            margin: 0px auto;
            width: 50%;
        }

        .columna {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .btn {
            border: none;
            color: white;
            padding: 14px 28px;
            cursor: pointer;
            border-radius: 5px;
        }

        .primary {
            background-color: #ff8607;
        }

        .primary:hover {
            background: #010101;
        }

        footer {
            padding: 15px;
            text-align: center;
            background: #000;
            color: #fff;
        }

        footer a {
            text-decoration: none;
            color: yellow;
        }

        footer a:hover {
            text-decoration: none;
            color: orange;
        }

        /* Estilos adicionales para hacerlo adaptable y estilizado */
        @media (max-width: 768px) {
            .contenedor {
                flex-direction: column;
                margin: 0px auto;
                width: 95%;
            }

            .columna {
                flex: 1;
                margin: 5px;
            }
        }
    </style>
</head>

<body>
    <section>
        <img class="banner" src="{{ asset('img/bienvenida.jpg') }}" alt="">
    </section>

    <section class="bienvenida">
        <h5 class="title">LIBRO DE RECLAMACIONES</h5>
        <hr class="linea">
    </section>

    <section style="padding: 15px;">
        <div class="contenedor">
            <div class="contenedor-texto">
                <h3>1. IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE</h3>
                <p style="margin-top: 10px;">
                    <b>Nombre completo:</b> Jesús Anaya Aguirre <br>
                    <b>Correo electrónico:</b> jesus@gmail.com <br>
                    <b>Teléfono:</b> 977627207 <br>
                    <b>DNI:</b> 42858706 <br>
                    <b>Dirección:</b> mi house 265 <br>
                    <b>Distrito:</b> San Juan de Miraflores <br>
                    <b>Ciudad:</b> Lima <br>
                    <b>Departamento:</b> Lima
                </p>
                <br>
                <h3>2. IDENTIFICACIÓN DEL BIEN CONTRATADO</h3>
                <p style="margin-top: 10px;">
                    <b>Producto: </b> Móto <br>
                    <b>Descripción del producto/servicio: </b> Móto de carga <br>
                    <b>Monto del producto/servicio: </b> S/ 1260<br>
                    <b>Lugar de compra: </b> Trujillo<br>
                    <b>Fecha de compra: </b> 23/02/2025 <br>
                    <b>Modelo: </b> AX250
                </p>
                <br>
                <h3>3. DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR</h3>
                <p style="margin-top: 10px;">
                    <b>Queja / Reclamo: </b> Queja <br>
                    <b>Detalle: </b><br>
                    Aqui vendria toda la queja o reclamo. 
                    <br>
                    <b>Pedido: </b><br>
                    Aqui vendria el pedido que se le hace a la empresa por solucionar su problema. 
                </p>
                <br>
                <h3>4. OBSERVACIONES Y ACCIONES ADOPTADAS POR EL PROVEEDOR</h3>
                <p style="margin-top: 10px;">
                    <b>Detalle: </b><br>
                    Aqui vendria las acciones que adopto el proveedor.
                </p>
            </div>

        </div>
    </section>
    <br>

    <section style="padding: 15px;">
        <div class="contenedor">
            <div class="contenedor-texto" style="text-align: center; padding: 15px; background-color: #F9FAFD;">
                En la brevedad nuestro equipo se pondra en contacto con usted
            </div>
        </div>
    </section>
    <footer>
        <p>
            &copy; Derechos Reservados {{ env('APP_NAME') }} | Desarrollado por <a href="https://aracodeperu.com/"
                style="">Aracode Smart Solutions</a>
        </p>
    </footer>
</body>

</html>
