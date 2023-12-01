@extends('layouts.kentha')

@section('content')
    <div id="page" class="page_wapper hfeed site">
        <!----header----->
        <x-header-area />
        <!----page-CONTENT----->
        @if ($article)
            <div id="content" class="site-content">
                <div class="auto-container">
                    <div class="row default_row">
                        <div id="primary" class="content-area service col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <main id="main" class="site-main" role="main">
                                <!--===============spacing==============-->
                                <div class="pd_top_90"></div>
                                <!--===============spacing==============-->
                                <section class="blog_single_details_outer">
                                    <div>
                                        {!! $article->content_text !!}
                                    </div>
                                </section>
                                <!--===============spacing==============-->
                                <div class="pd_bottom_70"></div>
                                <!--===============spacing==============-->
                            </main>
                        </div>
                        <aside id="secondary" class="widget-area all_side_bar col-lg-4 col-md-12 col-sm-12">
                            <div class="side_bar">
                                <!--===============spacing==============-->
                                <div class="pd_top_90"></div>
                                <!--===============spacing==============-->
                                <div class="widgets_grid_box">
                                    <h2 class="widget-title">Autor</h2>
                                    <div class="about_authour_widget">
                                        <h3>{{ $article->author->name }}</h3>
                                        <img src="{{ asset('storage/' . $article->author->avatar) }}"
                                            alt="{{ $article->author->name }}" />
                                        <p>{{ $article->author->information }}</p>
                                    </div>
                                </div>
                                @if (count($categories) > 0)
                                    <div class="widgets_grid_box">
                                        <h2 class="widget-title">Categorías de publicaciones</h2>
                                        <ul class="wp-block-categories">
                                            @foreach ($categories as $category)
                                                <li>
                                                    <a
                                                        href="{{ route('blog_category', $category->id) }}">{{ $category->description }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="widgets_grid_box">
                                    <h2 class="widget-title">Publicaciones Recientes</h2>
                                    <div class="widget_post_box">
                                        @foreach ($latest_articles as $latest_article)
                                            <div class="blog_in clearfix image_in">
                                                <div class="image">
                                                    <img decoding="async" src="{{ $latest_article->imagen }}"
                                                        alt="{{ $latest_article->title }}" />
                                                </div>
                                                <div class="content_inner">
                                                    <p class="post-date">
                                                        <span class="icon-calendar"></span>
                                                        {{ formatShortMonth($latest_article->created_at) }}
                                                    </p>
                                                    <h3>
                                                        <a href="blog-single.html">
                                                            {{ $latest_article->title }}
                                                        </a>
                                                    </h3>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!--===============spacing==============-->
                                <div class="pd_bottom_70"></div>
                                <!--===============spacing==============-->
                            </div>
                        </aside>
                    </div>
                </div>
                <!---newsteller--->
                <x-news-teller-area></x-news-teller-area>
                <!---newsteller end--->
            </div>
        @endif

        <x-footer-area />
    </div>
@endsection
