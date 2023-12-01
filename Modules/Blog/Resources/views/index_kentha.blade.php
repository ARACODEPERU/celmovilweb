@extends('layouts.kentha')

@section('content')
    <div id="page" class="page_wapper hfeed site">
        <!----header----->
        <x-header-area />
        <div class="page_header_default style_one">
            <div class="parallax_cover">
                <div class="simpleParallax">
                    <img src="{{ asset('themes/kentha/assets/images/page-header-default.jpg') }}" alt="bg_image"
                        class="cover-parallax">
                </div>
            </div>
            <div class="page_header_content">
                <div class="auto-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="banner_title_inner">
                                <div class="title_page">
                                    Blog & Noticias
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="breadcrumbs creote">
                                <ul class="breadcrumb m-auto">
                                    <li><a href="inicio">Home</a></li>
                                    <li class="active">Blog & Noticias</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----page-CONTENT----->

        <div id="content" class="site-content">
            <div class="auto-container">
                <div class="row default_row">
                    <div id="primary" class="content-area col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        <section class="blog_post_section one_column style_two">
                            <!--===============spacing==============-->
                            <div class="pd_top_90"></div>
                            <!--===============spacing==============-->
                            @if (count($articles) > 0)
                                <div class="grid_show_case grid_layout clearfix">
                                    @foreach ($articles as $article)
                                        <div class="grid_box _card">
                                            <div class="news_box default_style list_view has_images">
                                                <div class="image img_hover-1">
                                                    <img width="750" height="420" src="{{ $article->imagen }}"
                                                        class="img-fluid" alt="img" />
                                                    <a href="{{ route('blog_category', $article->category->id) }}"
                                                        class="categories">
                                                        <i class="icon-folder"></i>
                                                        {{ $article->category->description }}
                                                    </a>
                                                </div>
                                                <div class="content_box">
                                                    <div class="date">
                                                        <span class="date_in_number">
                                                            {{ formatShortMonth($article->created_at) }}
                                                        </span>
                                                    </div>
                                                    <div class="source">
                                                        <h2 class="title">
                                                            <a href="{{ route('blog_article_by_url', $article->url) }}"
                                                                rel="bookmark">
                                                                {{ $article->title }}
                                                            </a>
                                                        </h2>
                                                        <p class="short_desc">
                                                            {{ $article->short_description }}
                                                        </p>
                                                        <a href="{{ route('blog_article_by_url', $article->url) }}"
                                                            class="link__go">Leer Más</a>
                                                    </div>
                                                    <div class="auhtour_box">
                                                        <img alt="img"
                                                            src="{{ asset('storage/' . $article->author->avatar) }}"
                                                            height="60" width="60" class="img-fluid" />
                                                        <div class="contnet_a">
                                                            <p>PUBLICADO POR</p>
                                                            <h4>
                                                                {{ $article->author->name }}
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-lg-12">
                                    {{ $articles->links() }}
                                    {{-- <nav aria-label="Page navigation example">
                                    <ul class="pagination text-center">
                                        <li *ngIf="current_page > 1" class="next_link">
                                            <a (click)="onPageChange(current_page - 1)">
                                                <div class="nav-next">
                                                    <i class="fas fa-angle-left"></i>
                                                </div>
                                            </a>
                                        </li>
                                        <ng-container *ngFor="let link of links; let indice = index">
                                            <li *ngIf="indice > 0 && indice < last_page + 1"
                                                [ngClass]="{ active: link.active }">
                                                <a *ngIf="link.url" (click)="onPageChange(indice)">
                                                    {{ link . label }}
                                                </a>
                                            </li>
                                        </ng-container>

                                        <li *ngIf="current_page < last_page" class="next_link">
                                            <a (click)="onPageChange(current_page + 1)">
                                                <div class="nav-next">
                                                    <i class="fas fa-angle-right"></i>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </nav> --}}
                                </div>
                            </div>
                            <!--===============spacing==============-->
                            <div class="pd_bottom_70"></div>
                            <!--===============spacing==============-->
                        </section>
                    </div>
                    <aside id="secondary" class="widget-area all_side_bar col-lg-4 col-md-12 col-sm-12">
                        <div class="side_bar">
                            <!--===============spacing==============-->
                            <div class="pd_top_90"></div>
                            <!--===============spacing==============-->
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

            <x-news-teller-area></x-news-teller-area>
        </div>
        <!---==============footer start =================-->
        <x-footer-area />
    </div>
@endsection
