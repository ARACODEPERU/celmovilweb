@extends('blog::layouts.master')
@section('title', 'Contactenos')

@section('title')
<meta name="robots" content="index, follow">
<meta name="keywords" content="laravel 10, php8">
{{-- <meta name="description" content="Descripción breve de la página"> --}}

@stop

@section('content')

    <main class="container"> 
        <div class="row g-5"> 
            <div class="col-md-8"> 
                <div class="mt-4">
                    <h2 class="mb-4" >formulario de Contacto</h2>
                    <form class="mb-4">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="name" placeholder="Nombres" maxlength="255" required>
                            <label for="name">Nombres</label>
                        </div> 
                        <div class="form-floating mb-2">
                            <input type="email" class="form-control" id="email" placeholder="Correo Electrónico" required>
                            <label for="email">Correo Electrónico</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" id="naaffairme" placeholder="Asunto" maxlength="255" required>
                            <label for="affair">Asunto</label>
                        </div> 
                        <div class="form-floating mb-2">
                            <textarea class="form-control" placeholder="mensaje" id="message" required></textarea>
                            <label for="message">Mensaje</label>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M8 0a8 8 0 1 0 8 8A8 8 0 0 0 8 0zm3.854 8.146a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708 0L5.5 8.707a.5.5 0 1 1 .708-.708L10 10.793l2.146-2.147a.5.5 0 0 1 .708 0z"/>
                                  </svg>
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="text-center">
                    <a href="https://www.facebook.com/profile.php?id=100054635552311" style="text-decoration: none" target="_blank">
                      <img src="{{ asset('img/facebook.png') }}" alt="Facebook" width="64" height="64">
                    </a>
                    <a href='https://www.youtube.com/@ElmerRodriguezB' target="_blank">
                      <img src="{{ asset('img/youtube.png') }}" alt="YouTube" style="text-decoration: none" width="64" height="64" >
                    </a>
                  </div>
                  
            </div> 
            <div class="col-md-4"> 
                <div class="position-sticky mt-4"> 
                    <div class="p-4 mb-3 bg-body-tertiary rounded"> 
                        <h4 class="fst-italic">Acerca de Nosotros</h4> 
                        <p>Somos un equipo de desarrolladores de software comprometidos en crear sistemas web a medida para tu negocio. Nuestra especialidad radica en utilizar tecnologías de vanguardia como Laravel, Vue.js, Angular, Inertia.js, Livewire, MySQL y JavaScript para ofrecerte soluciones tecnológicas de calidad.</p>
                        <p>En lugar de simplemente mencionar las tecnologías que utilizamos, podemos resaltar cómo nuestro enfoque personalizado y nuestra experiencia en estas tecnologías nos permiten crear sistemas web que se adaptan perfectamente a las necesidades específicas de tu negocio.</p>
                        <p>Nuestro objetivo es brindarte una solución tecnológica que optimice tus procesos, mejore la experiencia de tus usuarios y te ayude a alcanzar tus objetivos comerciales. Ya sea que necesites un sistema de gestión, un sitio web interactivo o una aplicación web compleja, estamos listos para convertir tus ideas en realidad.</p>
                        <p>Confía en nosotros para desarrollar sistemas web de calidad que impulsen tu negocio hacia el éxito. ¡Permítenos ser tus socios tecnológicos y llevar tu negocio al siguiente nivel!</p> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </main> 

@endsection
