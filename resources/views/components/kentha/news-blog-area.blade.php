<section class="blog-post" id="blog">
    <!--===============spacing==============-->
    <div class="pd_top_80"></div>
    <!--===============spacing==============-->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="title_all_box style_six text-center  dark_color">
                    <div class="title_sections">
                        <div class="before_title"> <span class="icon-briefcase icon"></span>ACTUALIZACIÓN DE LAS NOTICIAS
                        </div>
                        <h2>Noticias y actualizaciones destacadas</h2>
                        <p>We work with your company to identify position requirements, implement
                            recruitment
                            programs, and initiate employee assessments that maximize recruitment efforts
                        </p>
                    </div>
                </div>
                <!--===============spacing==============-->
                <div class="pd_bottom_10"></div>
                <!--===============spacing==============-->
            </div>
        </div>
        <div class="blog_all_styles grid ">
            <div class="row">
                @foreach ($articles as $article)
                    <div class="col-xl-4 col-md-6 col-sm-6  col-xs-12">

                        <div class="news_box type_one clearfix">
                            <div class="news_inner">
                                <div class="image_box">
                                    <img src="{{ $article->imagen }}" class="img-fluid" alt="img">
                                    <div class="overlay"></div>
                                    <div class="post-category">
                                        <a href="{{ route('blog_category', $article->category->id) }}"
                                            class="categories">
                                            <i class="icon-folder"></i>
                                            {{ $article->category->description }}
                                        </a>
                                    </div>
                                </div>
                                <div class="content_box">
                                    <ul class="post-info clearfix">
                                        <li class="authour_name">
                                            <i class="fa fa-user"></i>
                                            <a href="#"> {{ $article->author->name }} </a>
                                        </li>
                                        <li class="date">
                                            <a href="blog-single.html">
                                                <i class="fa fa-calendar"></i>
                                                {{ formatShortMonth($article->created_at) }}
                                            </a>
                                        </li>
                                    </ul>
                                    <h2 class="entry-title">
                                        <a href="blog-single.html">
                                            {{ $article->title }}
                                        </a>
                                    </h2>
                                    <p class="short_desc">
                                        {{ $article->short_description }}
                                    </p>
                                    <div class="bottom_content clearfix">
                                        <div class="continure_reading">
                                            <a href="{{ route('blog_article_by_url', $article->url) }}"
                                                class="read_more type_one">
                                                Leer más <span class="icon-arrow-right"></span></a>
                                        </div>
                                        {{-- <div class="comments">
                                            <i class="icon-text"></i>
                                            <a href="blog-single.html#respond" class="Comments are Closed">Post
                                                Comment</a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.col-lg-3 -->
                @endforeach
            </div>
        </div><!-- /.blog-one -->
    </div>
    <!--===============spacing==============-->
    <div class="pd_bottom_70"></div>
    <!--===============spacing==============-->
</section>
