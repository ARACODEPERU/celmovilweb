<div>
    <!--about-->
    <section id="about" class="about-section">
        <!--===============spacing==============-->
        <div class="pd_top_70"></div>
        <!--===============spacing==============-->
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="image_box_new type_one clearfix">
                        <div class="image_one">
                            <img src="{{ $data[0]->item->content }}" class="img-fluid height_570px object-fit-cover"
                                alt="img" />
                        </div>
                        <div class="video_box video-inner text-center">
                            <a href="https://youtu.be/RN81h85V6D4" class="lightbox-image">
                                <i class="icon-play"></i>
                            </a>
                        </div>
                        <div class="image_two">
                            <img src="{{ $data[1]->item->content }}" class="img-fluid" alt="img" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="title_all_box style_six dark_color">
                        <div class="title_sections">
                            <div class="before_title">
                                <span class="icon-briefcase icon"></span>
                                {{ $data[2]->item->content }}
                            </div>
                            <div class="title">{{ $data[3]->item->content }}</div>
                            <p class="description_text">
                                {{ $data[4]->item->content }}
                            </p>
                        </div>
                    </div>
                    <!--===============spacing==============-->
                    <div class="pd_bottom_30"></div>
                    <!--===============spacing==============-->

                    <div class="row gutter_25px">
                        <div class="col-lg-4 col-md-4 col-ms-12">
                            <div class="theme_btn_all color_one">
                                <a href="{{ route('web_nosotros') }}" rel="nofollow" class="theme-btn one">
                                    Leer Más
                                </a>
                            </div>
                            <!--===============spacing==============-->
                            <div class="pd_bottom_25"></div>
                            <!--===============spacing==============-->
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--===============spacing==============-->
        <div class="pd_bottom_80"></div>
        <!--===============spacing==============-->
    </section>
    <!---about end-->

</div>
