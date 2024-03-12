@extends('layouts.celmovil')
@section('content')
    <!-- Preloader Start                                                                                                                                    </div> -->
    <!-- Preloader End -->

    <!-- header - section start -->
    <x-header-area />
    <!-- header - section end -->

    
		<!-- page banner area start -->
        <div class="page-banner">
            <img style="width: 100%; height: 250px;" src="{{ $banner[0]->content }}" alt="Page Banner" />
        </div>
		<!-- page banner area end -->
		
		<!-- about us section start -->
		<section class="about-area section-padding">
			<div class="container">
                <div class="row">
                    <div class="col-md-10 col-text-center">
                        <div class="section-title text-center">
                            <h3><span>Preguntas</span> Frecuentes</h3>
                            <div class="shape">
                                <img src="{{ asset('themes/celmovil/img/icon/t-shape.png') }}" alt="Title Shape" />
                            </div>
                            <p>
                                ¡Bienvenido a nuestra sección de Preguntas Frecuentes (FAQ)! Aquí encontrarás respuestas a las preguntas más comunes que nuestros clientes suelen hacer. Sabemos que cuando visitas nuestro sitio web, es posible que tengas algunas dudas sobre nuestros productos/servicios, políticas, procesos de compra, y más.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="padding: 10px;">
                        <h4 style="padding: 5px 15px;">Conozcamos más de las Motos Eléctricas</h4>
                        <div class="panel-group" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            ¿Cómo funciona una moto eléctrica?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        Generalmente una <b>moto eléctrica</b> (vehículo menor eléctrico, son motos vmp, motos, bicimotos y trimotos eléctricas, excluye autos eléctricos) utiliza como fuente de energía baterías ( plomo ácido o litio en diversos tipos), estas baterías transmiten energía a un motor eléctrico, generando su propulsión y movimiento. Al no usar gasolina, no hay combustión y por consiguiente no hay fuente de ruido ni emisión de gases contaminantes.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            ¿Cuál es la diferencia ente las motos eléctricas y las de gasolina?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Las motos eléctricas funcionan con electricidad, se deben conectar a una toma corriente convencional para cargarlos, esta energía se almacena en una batería que luego alimenta el motor para hacer desplazar el vehículo. Las diferencias principales son: <br><br>
                                            a) No requiere gasolina ni aceite.<br>
                                            b) Es más económico su carga (S/ 1.20 por carga aprox.)y mantenimiento (es decir, revisión simple).<br>
                                            c) Son amigables con el medio ambiente pues no emite gases contaminantes.<br>
                                            d) El motor no hace ruido ni emite vibraciones, por lo que hace más cómodo en manejo.<br>
                                            e) No requiere revisiones para cambio de aceite.<br>
                                            f) Tiene menor posibilidad de falla por tener menor cantidad de piezas.<br>
                                            g) No tiene cambios en transmisión, la potencia del motor se entrega inmediatamente cuando acelera.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            ¿Qué tipo de mantenimiento necesita el sistema eéctrico de las motos eléctricas?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        El sistema eléctrico no requiere mantenimiento ya que sus componentes están diseñados para ser libre de mantenimiento. 
                                        El motor eléctrico es tipo "DC sin escobillas" por lo cual no tienen piezas que tengan desgaste mecánico de uso. Las baterías 
                                        de los diferentes vehículos tanto de ácido-plomo, como las de Litio son selladas y libres de mantenimiento, por lo que nunca se 
                                        deben de abrir para recargarle ningún líquido o compuesto activo. Estas solo deben de recargarse cada vez que se descarguen.
                                        Los demás componentes como el controlador, convertidor y demás sistemas son componentes que no necesitan ningún tipo de mantenimiento.
                                        Sin embargo, al tratarse de un vehículo ciclomotor como bicicleta, se recomienda realizar una revisión periódica del estado de las ruedas, los frenos y luces como una medida de prevención.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingFour">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            ¿Cuánto es el costo en consumo de energía de los vehículos eléctricos? ¿Es costoso cargar la beteria?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        No, todo lo contrario, es mucha más económica que una de gasolina, Por ejemplo, una moto con batería de 70v20ah, carga 10 horas, solo cuesta S/ 1.20. Se adjunta la calculación de consumo de luz en cargar la batería por hora para la referencia.
                                        <img src="{{ asset('themes/celmovil/img/costo-de-cargador.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingFive">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            ¿Es costoso mantener una moto eléctrica?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        No, todo lo contrario. A diferencia de las motos tradicionales, las motos eléctricas no requieren ni de cambios de aceite, afinamientos, ni otros procesos que generan gastos periódicos al usuario, en consecuencia, son muchísimo más económicas.
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingSix">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                            ¿Dónde puedo cargar los productos eléctricos?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSix" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Cargar una moto eléctrica es muy fácil, solo tienes que conectar el enchufe del cargador a cualquier tomacorriente de 220 voltios (en Perú) como el que tiene en casa o cualquier lugar y el otro extremo lo conectas al puerto de carga del vehículo o de la batería (batería extraíble), consulta el manual de us0 o pregúntale a asesor comercial para ubicar el puerto de carga en el vehículo.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingSeven">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                            ¿Cuánto tiempo tiene que recargar la baterías?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseSeven" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        El tiempo de carga depende de la potencia de la batería, así como de la potencia del cargador. Para una bicicleta eléctrica el proceso de carga demora alrededor de 3 a 5 horas. Para una moto eléctrica demora alrededor de las 6 a 10 horas. Generalmente no se recorren distancias superiores a los 20 km en los trayectos cotidianos, en este caso el tiempo de recarga puede demorar menos tiempo y varía dependiendo del vehículo. Cuando está cargada completamente, la luz indicativa del cargador gira a color verde. Pero, aun que los cargadores se apaga automáticamente cuando esté cargada, es recomendable no cargar más de 12 horas ni mezclar cargadores, y cualquier duda revisar las instrucciones del manual y/o contactarnos para poder orientarlo.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingOcho">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseOcho" aria-expanded="false" aria-controls="collapseOcho">
                                            ¿Qué tipo de bateria llevan las motos eléctricas y cuál es la vida útil de ellas?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOcho" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Hasta la fecha, la mayoría de las motos eléctricas suelen tener baterías de plomo ácido que son las más económicas y seguras, sin embargo, también existen versiones que vienen con baterías de litio de varios tipos que son mucho mas caros que las de plomo ácido.
                                        La vida útil de las baterías de plomo ácido puede ser de 300 a 500 ciclos de carga/descarga profunda (según el vehículo y el fabricante) al emplearse 100% de la energía almacenada en ellas. El promedio de vida útil de baterías de las motos eléctricas se encuentra entre 1.5 a 2 años y depende fuertemente de la frecuencia de uso. La vida útil de las baterías de Litio puede ser de 500 a 1000 ciclos de carga/descarga profunda (según el vehículo y el fabricante) al emplearse 100% de la energía almacenada en ellas.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingNueve">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseNueve" aria-expanded="false" aria-controls="collapseNueve">
                                            ¿A cuántos de fuerza equivale un Watt? Y, ¿Cuánto es la potencia equivalente en C.C. con una moto eléctrica?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseNueve" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        La potencia de los motores eléctricos se mide en watts, 1 caballo de fuerza (hp) equivale a 745,7 Watts. Considerando que las motos eléctricas no tienen un motor a combustión como las motocicletas tradicionales, para poder realizar una comparación tendríamos que convertir la potencia del motor a un valor estándar. Generalmente la potencia de los motores eléctricos fluctúa entre 250w–1500w (tipo pistera se encuentra con motor de alta potencia); sin embargo, un motor eléctrico un poco mas potente (por ejemplo1200w) apenas llegaría a aproxi.27CC equivalente,cual es mucho menor a 50CC, desde luego.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding: 10px;">
                        <h4 style="padding: 5px 15px;">Mantenimiento y servicio Post Venta de CelMovil</h4>
                        <div class="panel-group" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingOne">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            ¿Cuál es la garantia de CelMovil?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        Nuestro principal objetivo es brindar al cliente una satisfacción total en su compra, por ello nos preocupamos en su tranquilidad y ofrecemos una GARANTÍA VERDADERA en todos nuestros productos para casos de defectos atribuidos a la calidad o daños de fábrica, cual esta dellada en el <b>Certificado de Garantía.</b>
                                        Ademas, tenemos los Repuestos AL INSTANTE en Lima, y contamos con un equipo de mecánicos para ofrecer un Servicio Técnico especializado para atender cualquier eventualidad, reparar y/o cambiar de forma gratuita las piezas que estén cubiertas o no en el periodo de garantía.
                                        También ponemos a disposición, la venta de todo tipo de accesorios y repuestos para aquellos casos que estuvieran fuera de garantía. Específicamente, los daños, averías o usos inapropiados causados por el usuario no están cubiertos por la garantía, tampoco el derrame de líquidos en la parte electrónica, ni la carga excesiva de la batería, entre otros.
                                        Y en provincia, tenemos los distribuidores entrenados para atender los servicios técnicos y están respaldo en los repuestos en GreenLine Central en Lima.
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            ¿Qué tipo de mantenimiento o revisión necesitan las motos eléctricas y donde hacerlo?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        El motor no requiere de ningún tipo de mantenimiento, sin embargo, al tratarse de un vehículo ciclomotor, se recomienda realizar una revisión periódica del estado de las ruedas, los frenos y luces como una medida de prevención.
                                        Más detalle, puede consultar a las dos tiendas & talleres en Lima: tienda Lince & tienda Surco. 
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            ¿A dónde debo acudir en caso de requerir alguna asistencia técnica con mi moto eléctrica?
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Debes acudir solamente a los talleres autorizados de CelMovil, los cuales están equipados con todos los repuestos orginales y necesarios para poder refaccionar tu moto bajo estándares del fabricante. Se recomienda estrictamente NO llevar tu moto eléctrica a talleres no autorizados ni donde mecánicos de motos a combustión. Pronto estaremos abriendo más locales en nivel nacional.
                                        También puedes contactarnos vía telefónica, por correo electrónico o por WhatsApp para coordinar una cita.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</section>
		<!-- about us section end -->

    <br><br>
    <!-- footer - section start -->
    <x-footer-area />
    <!-- footer - section end -->

@stop
