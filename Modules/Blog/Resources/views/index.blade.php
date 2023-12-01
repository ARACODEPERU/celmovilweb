@extends('blog::layouts.master')

<div class="container"> 
    <header class="blog-header lh-1 py-3"> 
        <div class="row flex-nowrap justify-content-between align-items-center"> 
            <div class="col-4 pt-1"> 
                {{-- <a class="link-secondary" href="#">Subscribe</a>  --}}
            </div> 
            <div class="col-4 text-center"> 
                <a class="blog-header-logo text-body-emphasis" href="#">Cuentos Cortos</a> 
            </div> 
            <div class="col-4 d-flex justify-content-end align-items-center"> 
                {{-- <a class="btn btn-sm btn-outline-secondary" href="#">Sign up</a>  --}}
            </div> 
        </div> 
    </header> 
    <div class="nav-scroller py-1 mb-2"> 
        <nav class="nav d-flex justify-content-between"> 
            <a class="p-2 link-secondary" href="#">TERROR</a> 
        </nav> 
    </div> 
</div> 
@section('content')
    
    <main class="container"> 
        <div class="p-4 p-md-5 mb-4 rounded text-bg-dark"> 
            <div class="col-md-6 px-0"> 
                <h1 class="display-4 fst-italic">Relatos folklóricos de Chimbote: Costumbres, mitos y narraciones populares</h1> 
                <p class="lead my-3">Es una recopilación de historias tradicionales y populares de la ciudad de Chimbote..</p> 
            
            </div> 
        </div> 

        <div class="row g-5"> 
            <div class="col-md-8"> 
                <h3 class="pb-4 mb-4 fst-italic border-bottom"> El Látigo del Zorro y el Fantasma </h3> 
                <article class="blog-post"> 
                    <p>Cuenta la historia que en Chimbote hubo un atleta excepcional que solía vestirse completamente de negro y llevar un látigo en la mano. Durante la noche, se presentaba en la Avenida Gálvez, cerca de un supermercado cooperativo que se encontraba junto a las antiguas casas de los empleados del ferrocarril. Su aparición causaba mucho temor entre la población, especialmente entre los viajeros que llegaban en horas de la madrugada y tenían que atravesar esa calle. El atleta saltaba por encima de las viejas tapias del "Muro de la Vergüenza" para propinar una golpiza a quien se cruzara en su camino, siendo diestro con el látigo. A pesar de que la gente no podía defenderse por el terror que los paralizaba, él desaparecía tan rápido como llegaba. La historia del "fantasma" creó una histeria colectiva, lo que hizo que muy pocos se atrevieran a salir de noche por miedo a encontrarse con este misterioso personaje.</p>
                </article>
                <h3>La Princesa y las veinticinco tinajas de chicha</h3>
                <article class="blog-post"> 
                    <p>En las laderas del cerro de arena, en el pueblo joven San Pedro, hay una casa de campo que alguna vez fue muy importante, pero en la actualidad está bastante descuidada. En el año 1962, una conocida compañía constructora estaba realizando trabajos de excavación en la zona. Un obrero que manejaba el tractor se sorprendió al descubrir una momia y varias piezas de oro brillante. Los curiosos se congregaron rápidamente para ver lo que estaba sucediendo. Junto a la momia, había un collar de oro y piedras preciosas que brillaba en su cuello y su ropa era de una finura sin igual. También se encontraron 25 tinajas de chicha de tiempos inmemoriales. El destino del collar de oro es desconocido y los que fueron remunerados por su hallazgo lo recuerdan de vez en cuando. La casa de campo todavía espera y se pregunta qué misterios encierra en su interior.</p>
                </article>
                <h3>La Huaca de San Pedro</h3>
                <article class="blog-post"> 
                    <p>Según cuentan los vecinos de la zona, en este lugar han ocurrido muchos misterios y eventos extraños a lo largo del tiempo. Uno de estos eventos es la aparición periódica de un misterioso sonido similar al tic tac de un reloj, el cual se escucha con frecuencia al atardecer, pero nadie ha logrado encontrar su origen. Además, se sabe que la dacha lleva ese nombre porque se dice que contiene muchos huacos, pero también se ha descubierto que al abrir calles y avenidas en San Pedro, se encontraron minerales y oro en barras, lo que provocó la interrupción de las excavaciones en el área. Los habitantes del lugar creen firmemente en todos estos eventos.</p>
                </article>
                <h3>El Ahogado</h3>
                <article class="blog-post"> 
                    <p>Según cuentan los primeros habitantes, un padre y sus dos hijos pequeños salieron a pescar cerca de la cueva conocida como "de las brujas". Sin darse cuenta, se adentraron tanto en el mar que cuando quisieron regresar, el atardecer había llegado y las sombras cubrían la bahía. En ese momento, una sombra fantasmal se levantó de las aguas y se llevó a uno de los hijos, desapareciendo entre las olas. Desde entonces, nadie se atrevía a salir a pasear o pescar de noche, debido al gemido del ahogado pidiendo ayuda que se escuchaba en la caleta. Esta leyenda se convirtió en terror para todos, haciendo que la gente se encerrara en sus casas al caer la tarde y la caleta quedara en silencio.</p>
                </article>
                <h3>El Puerto de Santa y la Semana Santa</h3>
                <article class="blog-post"> 
                    <p>Cuentan los habitantes originarios del distrito de Santa, que en su pasado, la población era próspera y contaba con un importante puerto y muelle para embarcaciones, así como un templo dedicado al Señor. Según la historia, durante la Semana Santa, se llevaba en procesión a las imágenes de la virgen por las calles del antiguo pueblo y en ese momento, se podía ver al Señor siendo llevado en andas acompañado de una multitud con velas encendidas, como si estuvieran caminando sobre las olas del mar, aunque esto era solo una ilusión óptica que duraba unos pocos segundos.</p>
                </article>
                <h3>La mujer que compró su marido</h3>
                <article class="blog-post"> 
                    <p>El año 1946 se presentó ante el Secretario del Concejo Provincial, una hermosa porteña que quería contraer matrimonio civil, fijada la fecha y la hora, en plena ceremonia hizo acto de presencia una mujer con su hija tratando de impedir el acto amparada en la Partida de Matrimonio que exhibía. La contrayente ni corta ni perezosa llevó a la mujer a un extremo de la Casa Municipal y le extendió un cheque por 250 mil soles de aquel entonces, que fue aceptado. El Secretario no quiso continuar la ceremonia, exclamando la mujer que no se preocupara que ella firmaría como testigo, autorizando el Alcalde la compra del marido por la mujer adinerada.</p>
                </article>
                <h3>La Llorona de Coishco</h3>
                <article class="blog-post"> 
                    <p>Se cuenta que en Coishco, había una mujer muy humilde, la cual tuvo un hijo, pero su padre no la quiso aceptar con el niño, ella suplicó su perdón y vio la manera de que su padre la perdonara, pero su padre por no dejar de la lado su orgullo, decidió darle fin a la criatura, pero como ésta se oponía y estaba dispuesta a cualquier cosa para que no le pasara nada a su hijo, su padre no tuvo compasión, ni tuvo otra solución que acabar con la vida de ambos.</p>
                    <p>Desde aquel día el alma de aquella muchacha no puede descansar en paz, es por eso que cada cierto tiempo baja desde los cerros en busca de su hijo, dicen que su apariencia es, gringa, alta y muy bonita (moradores que la han visto). Este personaje recorre las calles de Coishco, esto es como a las doce de la media noche, y empieza a llorar desconsoladamente es así como va llorando y pasa muy cerca de las casas.</p>
                    <p>Su llanto es insistente como para que la auxilien, pero si alguien sale o abre su puerta, esta desaparece instantáneamente y se lleva su víctima. Los moradores de este lugar están apercibidos de esto, tal es así que cada vez que la llorona pasa, no le abren la puerta.</p>
                </article>
                <h3>El Caballero Invisible</h3>
                <article class="blog-post"> 
                    <p>Después de varios años de la ocupación chilena y la destrucción de muchas viviendas, una casa en particular llamada "Cuesta Chile" comenzó a recibir la visita de un misterioso "Caballero Invisible" que solo era visible para la dueña de la casa. El anciano dueño de la casa, don Mauricio Beltrán Banzur, había trabajado en el ferrocarril de la Peruvian en su juventud y estaba casado con doña Claudia Cerna de Beltrán. El caballero visitante aparecía solo cuando don Mauricio estaba fuera de la casa y parecía tener un plan desconocido para la dueña de la casa.</p>
                    <p>Después de que la señora le informara a su esposo sobre la extraña visita, decidieron idear un plan para descubrir al misterioso visitante invisible. Un día, cuando don Mauricio salió de la casa, regresó inesperadamente y encontró a su esposa hablando con alguien invisible. Después de buscar en la casa y no encontrar a nadie, el misterio solo se profundizó. El caballero invisible continuó visitando la casa, lo que eventualmente provocó los celos y la ira de don Mauricio. En un día de calor insoportable, después de beber varias copas de licor con sus amigos ferrocarriles, regresó a casa y enfrentó al caballero invisible, haciendo tres disparos y exigiendo que se fuera de su casa. El visitante invisible explicó que solo quería guiar a la dueña de la casa a una fortuna enterrada, pero que ahora todo estaba perdido debido a la acción violenta de don Mauricio. Después de este incidente, el caballero invisible nunca más volvió a visitar la casa y la paz reinó una vez más.</p>
                </article>
                <h3></h3>
                <article class="blog-post"> 
                    <p></p>
                </article>
                <h3></h3>
                <article class="blog-post"> 
                    <p></p>
                </article>
                {{-- <nav class="blog-pagination" aria-label="Pagination"> 
                    <a class="btn btn-outline-primary rounded-pill" href="#">Older</a> 
                    <a class="btn btn-outline-secondary rounded-pill disabled">Newer</a> 
                </nav>  --}}
            </div> 
            <div class="col-md-4"> 
                <div class="position-sticky" style="top: 2rem;"> 
                    {{-- <div class="p-4 mb-3 bg-body-tertiary rounded"> 
                        <h4 class="fst-italic">About</h4> 
                        <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p> 
                    </div> 
                    <div class="p-4"> 
                        <h4 class="fst-italic">Elsewhere</h4> 
                        <ol class="list-unstyled"> 
                            <li><a href="#">GitHub</a></li> 
                            <li><a href="#">Twitter</a></li> 
                            <li><a href="#">Facebook</a></li> 
                        </ol> 
                    </div>  --}}
                    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2128776301009629"
                    crossorigin="anonymous"></script>
                </div> 
            </div> 
        </div> 
    </main> 
   {{-- <footer class="blog-footer"> 
        <p>Blog template built for 
            <a href="">Bootstrap</a> by 
            <a href="">@mdo</a>.
        </p> 
        <p> <a href="#">Back to top</a> </p> 
   </footer>   --}}
  
@endsection
