<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Política de Cookies</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    h1 {
        color: #333;
    }
    p {
        color: #666;
    }
</style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Política de Cookies</h1>
        <p>Esta política de cookies explica cómo {{ env('APP_NAME') }} utiliza cookies y tecnologías similares para reconocerte cuando visitas nuestro sitio web.</p>

        <h2>¿Qué son las cookies?</h2>
        <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web. Se utilizan ampliamente para que los sitios web funcionen de manera más eficiente y para proporcionar información a los propietarios del sitio.</p>

        <h2>¿Cómo utilizamos las cookies?</h2>
        <ul>
            <li>Utilizamos cookies esenciales para autenticar usuarios y mantener la sesión de inicio de sesión.</li>
            <li>También incorporamos contenido de terceros, como videos de Vimeo, que pueden establecer sus propias cookies para ofrecer servicios personalizados.</li>
        </ul>

        <h2>¿Qué tipos de cookies utilizamos?</h2>
        <ul>
            <li>Cookies estrictamente necesarias: Estas cookies son esenciales para que puedas navegar por el sitio y utilizar sus funciones básicas.</li>
            <li>Cookies de funcionalidad: Estas cookies se utilizan para recordar tus preferencias y mejorar tu experiencia de usuario.</li>
            <li>Cookies de terceros: Algunas de nuestras páginas pueden mostrar contenido incrustado, como videos de Vimeo o Youtube, que a su vez pueden establecer sus propias cookies.</li>
        </ul>

         <h2>Cambios en nuestra política de cookies</h2>
        <p>Nos reservamos el derecho de modificar esta política de cookies en cualquier momento. Cualquier cambio significativo será publicado en esta página con una notificación destacada.</p>

        <p>Al utilizar nuestro sitio web, aceptas el uso de cookies de acuerdo con esta política.</p>

        <p>Si tienes alguna pregunta sobre nuestra política de cookies, contáctanos en <a href="mailto:{{ env('MAIL_USERNAME') }}">{{ env('MAIL_USERNAME') }}</a>.</p>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
