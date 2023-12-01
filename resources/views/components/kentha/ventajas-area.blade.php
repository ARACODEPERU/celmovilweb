<div>
    <section class="content-section">
        <!--===============spacing==============-->
        <div class="pd_top_50"></div>
        <!--===============spacing==============-->
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    <div class="title_all_box style_six text-center">
                        <div class="title_sections">
                            <div class="before_title">
                                <span class="icon-briefcase icon"></span>
                                {{ $titles[0]->item->content }}
                            </div>
                            <div class="title">{{ $titles[1]->item->content }}</div>
                            <p class="description_text">
                                {{ $titles[2]->item->content }}
                            </p>
                        </div>
                        <!--===============spacing==============-->
                        <div class="pd_bottom_20"></div>
                        <!--===============spacing==============-->
                    </div>
                </div>
            </div>
            <div class="row">
                
                @foreach ($data as $k => $group)  
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="choose_box  type_one">
                        <div class="image_box">
                            <img src="{{ $group->item->items[0]->content }}" class="img-fluid svg_image"
                                alt="icon png">
                        </div>
                        <div class="content_box">
                            <span class="step_no">{{ $group->item->items[1]->content }}</span>
                            <div class="text_box">
                                <h2>
                                    <a href="" target="_blank">{{ $group->item->items[2]->content }}</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!--===============spacing==============-->
        <div class="pd_bottom_65"></div>
        <!--===============spacing==============-->
    </section>
</div>