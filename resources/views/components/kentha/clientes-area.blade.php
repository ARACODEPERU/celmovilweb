<div>
    <section class="client-section text-center bg_op_1"
      style="background: url({{ asset('themes/kentha/assets/images/home-13-client-bg.jpg') }});"> 
      <!--===============spacing==============-->
      <div class="pd_top_60"></div>
      <!--===============spacing==============-->
      <div class="container">
          <div class="row align-items-center">
              <div class="col-lg-12">
                  <div class="swiper-container"
                      data-swiper='{
           "autoplay": {
             "delay": 6000
           },
           "freeMode": true,
           "loop": true,
           "speed": 1000,
           "centeredSlides": false,
           "slidesPerView": 5,
           "spaceBetween": 30,
           "pagination": {
             "el": ".swiper-pagination",
             "clickable": true
           },
            
           "breakpoints": {
              "1200": {
                 "slidesPerView": 5
              },
              "1024": {
               "slidesPerView": 4
              },
             "768": {
               "slidesPerView": 3
             },
             "576": {
               "slidesPerView": 2 
             },
             "250": {
               "slidesPerView": 2 
             },
             "0": {
               "slidesPerView": 1 
             }
           }
         }'>
                      <div class="swiper-wrapper">
                          @foreach($data as $k =>$group)
                              <div class="swiper-slide">
                                  <div class="image">
                                      <img src="{{ $group->item->items[0]->content }}" alt="clients-logo"
                                          class="img-fluid" />
                                  </div>
                              </div>
                          @endforeach
                      </div>
  
                  </div>
              </div>
          </div>
      </div>
      <!--===============spacing==============-->
      <div class="pd_bottom_60"></div>
      <!--===============spacing==============-->
    </section>
  </div>