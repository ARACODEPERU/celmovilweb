<!---==============footer start =================-->
<div class="footer_area thirteen" id="footer_contents">
    <div class="footer_widgets_wrap bg_op_1"
        style="background: url({{ asset('themes/kentha/assets/images/footer-bg.jpg') }});">
        <!--===============spacing==============-->
        <div class="pd_top_80"></div>
        <!--===============spacing==============-->
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="footer_widgets about_company light_color">
                        <div class="about_company_inner">
                            <div class="footer_logo">
                                <a href="inicio" rel="nofollow">
                                    <img src="{{ asset('themes/kentha/assets/images/logo-white.png') }}"
                                        class="img-fluid" alt="logo" style="width: 60%;" />
                                </a>
                                <!--===============spacing==============-->
                                <div class="pd_bottom_30"></div>
                                <!--===============spacing==============-->
                            </div>
                            <div class="content_box">
                                <p class="color_white">
                                    Nos esforzamo por mejorar constantemente nuestros servicios
                                    escuchando y comprendiendo las preocupaciones de nuestros clientes,
                                    con el fin de ofrecerle el mejor servicio de calidad y a un precio asequible.
                                </p>

                            </div>
                        </div>
                        <!--===============spacing==============-->
                        <div class="pd_bottom_10"></div>
                        <!--===============spacing==============-->
                        <div class="social_media_v_one style_three">
                            <ul>
                                <li>
                                    <a href="{{ $data[7]->item->content }}" target="_blank"> <span
                                            class="fa fa-facebook"></span>
                                        <small>facebook</small>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $data[8]->item->content }}" target="_blank"> <span
                                            class="fa fa-instagram"></span>
                                        <small>instagram</small>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $data[9]->item->content }}" target="_blank"> <span
                                            class="fa fa-twitter"></span>
                                        <small>twitter</small>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $data[10]->item->content }}" target="_blank"> <span
                                            class="fa fa-linkedin"></span>
                                        <small>Linkedin</small>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $data[11]->item->content }}" target="_blank"> <span
                                            class="fa fa-youtube-square"></span>
                                        <small>Youtube</small>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-12">
                    <div class="footer_widgets wid_tit style_one">
                        <div class="fo_wid_title">
                            <h2>Esenciales</h2>
                        </div>
                    </div>
                    <!--===============spacing==============-->
                    <div class="pd_bottom_25"></div>
                    <!--===============spacing==============-->
                    <div class="footer_widgets clearfix">
                        <ul class="list_items_new_box type_one ">
                            <li>
                                <a routerLink="inicio" class="color_white">
                                    <span class=" icon-right-arrow icon"></span>
                                    Home
                                </a>
                            </li>
                            <li>
                                <a routerLink="nosotros" class="color_white">
                                    <span class=" icon-right-arrow icon"></span>
                                    Nosotros
                                </a>
                            </li>
                            <li>
                                <a routerLink="servicios" class="color_white">
                                    <span class=" icon-right-arrow icon"></span>
                                    Servicios
                                </a>
                            </li>
                            <li>
                                <a routerLink="proyectos" class="color_white">
                                    <span class=" icon-right-arrow icon"></span>
                                    Proyectos
                                </a>
                            </li>
                            <li>
                                <a routerLink="blog" class="color_white">
                                    <span class=" icon-right-arrow icon"></span>
                                    Blog
                                </a>
                            </li>
                            <li>
                                <a routerLink="contacto" class="color_white">
                                    <span class=" icon-right-arrow icon"></span>
                                    Contacto
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="footer_widgets wid_tit style_one">
                        <div class="fo_wid_title">
                            <h2>Noticias Recientes</h2>
                        </div>
                    </div>
                    <!--===============spacing==============-->
                    <div class="pd_bottom_25"></div>
                    <!--===============spacing==============-->
                    <div class="footer_widgets recent_news_em_wp style_one  clearfix">
                        <div class="news_boxed light_color">
                            @foreach ($articles as $article)
                                <div class="news_recent clearfix image_s">
                                    <div class="image">
                                        <img width="750" height="420" src="{{ $article->imagen }}"
                                            class="img-fluid" alt="img" loading="lazy">
                                    </div>
                                    <div class="content ">
                                        <h2 class="title">
                                            <a href="{{ route('blog_article_by_url', $article->url) }}" rel="bookmark">
                                                {{ $article->title }}
                                            </a>
                                        </h2>
                                        <a class="date">
                                            <span class="fa fa-clock-o"></span>
                                            {{ formatShortMonth($article->created_at) }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="footer_widgets wid_tit style_one">
                        <div class="fo_wid_title">
                            <h2>Contactanos</h2>
                        </div>
                    </div>
                    <!--===============spacing==============-->
                    <div class="pd_bottom_25"></div>
                    <!--===============spacing==============-->
                    <div class="footer_contact_widget">
                        <div class="contact_info_nbox type_one">
                            <div class="single">
                                <h6 class="color_white"> <span class="icon-location2 color_white"></span> Dirección
                                </h6>
                                <p class="color_white">{{ $data[3]->item->content }}</p>
                            </div>
                        </div>
                        <!--===============spacing==============-->
                        <div class="pd_bottom_20"></div>
                        <!--===============spacing==============-->
                        <div class="contact_info_nbox type_one">
                            <div class="single">
                                <h6 class="color_white"> <span class="icon-telephone color_white"></span> Teléfono </h6>
                                <p><a href="tel:{{ $data[4]->item->content }}"
                                        class="color_white">{{ $data[4]->item->content }}</a></p>
                            </div>
                        </div>
                        <!--===============spacing==============-->
                        <div class="pd_bottom_20"></div>
                        <!--===============spacing==============-->
                        <div class="contact_info_nbox type_one">
                            <div class="single">
                                <h6 class="color_white"> <span class="icon-mail color_white"></span> Correo
                                    Electrónico</h6>
                                <p><a href="mailto:{{ $data[5]->item->content }}"
                                        class="color_white">{{ $data[5]->item->content }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--===============spacing==============-->
        <div class="pd_bottom_50"></div>
        <!--===============spacing==============-->
    </div>
    <div class="creote-footer-copyright bg_dark_1">
        <!--===============spacing==============-->
        <div class="pd_top_20"></div>
        <!--===============spacing==============-->
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12">
                    <div class="footer_copy_content color_white">
                        © 2023 <a href="https://aracodeperu.com/" class="color_white">Aracode Perú.</a>
                        Todos los derechos reservados.
                    </div>
                </div>

            </div>
        </div>
        <!--===============spacing==============-->
        <div class="pd_bottom_20"></div>
        <!--===============spacing==============-->
    </div>
</div>
