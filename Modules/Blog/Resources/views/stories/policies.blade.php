@extends('blog::layouts.stories')
@section('title', 'Políticas del sitio')

@section('title')
<meta name="robots" content="index, follow">
<meta name="keywords" content="Política del Sitio, Del Ventas">

@stop

@section('content')

    <main class="container"> 
        <div class="row g-5"> 
            <div class="col-md-8"> 
                <div class="mt-4">
                    <h3>Política del Sitio</h3>
                </div>
                <article class="blog-post"> 
                    <p>Fecha de vigencia: 11 de mayo de 2023</p>
                    <p style="text-align: justify;">Agradecemos tu interés en nuestro sitio web Cuentos Cortos. En esta política de privacidad, describimos cómo recopilamos, utilizamos y protegemos la información personal que puedas proporcionarnos a través de nuestro sitio web.</p>
                    <strong>Propiedad intelectual:</strong>
                    <p style="text-align: justify;">El sitio web "Cuentos Cortos" recopila historias de diferentes fuentes con el objetivo de compartir y entretener a los lectores. no se reclama la propiedad intelectual de las historias individuales.</p>
                    <strong>Recopilación de información:</strong>
                    <p style="text-align: justify;">No recopilamos información personal identificable de los usuarios que visitan nuestro sitio web a menos que la proporcionen voluntariamente a través de un formulario de contacto o algún otro medio de comunicación.</p>
                    <strong>Uso de la información:</strong>
                    <p style="text-align: justify;">La información personal que nos proporciones será utilizada únicamente para responder a tus consultas. No compartiremos tu información personal con terceros sin tu consentimiento, a menos que estemos legalmente obligados a hacerlo.</p>
                    <strong>Cookies:</strong>
                    <p style="text-align: justify;">No utilizamos cookies en nuestro sitio web. Sin embargo, es posible que algunos de nuestros proveedores de servicios externos utilicen cookies y tecnologías similares para recopilar información anónima y mejorar la funcionalidad de nuestro sitio web.</p>
                    <strong>Enlaces a sitios web de terceros:</strong>
                    <p>Nuestro sitio web puede contener enlaces a otros sitios web de terceros. No nos responsabilizamos de las prácticas de privacidad de esos sitios y te recomendamos que revises las políticas de privacidad de cada sitio web al que accedas.</p>
                    <strong>Seguridad:</strong>
                    <p style="text-align: justify;">Implementamos medidas de seguridad razonables para proteger la información personal que nos proporcionas. Sin embargo, debes tener en cuenta que ninguna transmisión de datos a través de Internet o método de almacenamiento electrónico es completamente seguro.</p>
                    <strong>Cambios en la política de privacidad:</strong>
                    <p>Nos reservamos el derecho de actualizar o modificar esta política de privacidad en cualquier momento. Cualquier cambio importante será notificado mediante una publicación destacada en nuestro sitio web.</p>
                    {{-- <p>Si tienes alguna pregunta o inquietud sobre nuestra política de privacidad, no dudes en ponerte en contacto con nosotros a través de [correo electrónico de contacto].</p> --}}

                </article>
            </div> 
            <div class="col-md-4"> 
                <div class="position-sticky" style="top: 2rem;"> 

                </div> 
            </div> 
        </div> 
    </main> 
    {{-- <footer class="bg-light py-4">
        <div class="container text-center">
        <p>&copy; 2023 {{ env('APP_NAME') }} Blog. Todos los derechos reservados.</p>
        </div>
    </footer> --}}
    
@endsection
