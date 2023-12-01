<div>
    <!---testimonial-->

<section class="testimonial-section">
    <!--===============spacing==============-->
    <div class="pd_top_50"></div>
    <!--===============spacing==============-->
    <div class="container">
      <div class="row">
        <div class="col-lg-7 m-auto">
          <div class="title_all_box style_six text-center dark_color">
            <div class="title_sections">
              <div class="before_title">
                <span class="icon-briefcase icon"></span>
                {{ $titles[0]->item->content }}
              </div>
              <div class="title">{{ $titles[1]->item->content }}</div>
              <p>{{ $titles[2]->item->content }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="testimonial_all owl_new_one">
            <div
              class="owl-carousel owl_nav_block owl_dots_none owl_type_two theme_carousel owl-theme"
              data-options='{"loop": true, "margin": 0, "autoheight":true, "lazyload":true, "nav": true, "dots": true, "autoplay": true, "autoplayTimeout": 7000, "smartSpeed": 1800, "responsive":{ "0" :{ "items": "1" }, "768" :{ "items" : "3" } , "1000":{ "items" : "2" }}}'
            >

            @foreach ($data as $k => $group)
                <div class="testimonial_box type_one">
                    <span class="icon-quote"></span>
                    <div class="testimonial_inner">
                    <div class="description">
                        <p>
                        {{ $group->item->items[0]->content }}
                        </p>
                    </div>
                    <div class="lower_content clearfix">
                        <div class="image_box">
                        <img
                            decoding="async"
                            src="{{ $group->item->items[1]->content }}"
                            alt="image"
                        />
                        </div>
                        <div class="authour_name">
                        <h2>{{ $group->item->items[2]->content }}</h2>
                        <h6>{{ $group->item->items[3]->content }}</h6>
                        </div>
                    </div>
                    </div>
                </div>    
            @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
    <!--===============spacing==============-->
    <div class="pd_bottom_90"></div>
    <!--===============spacing==============-->
  </section>
  <!--testimonial end-->
  
</div>