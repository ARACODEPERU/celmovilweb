<div>
    <section class="creote-service-box">
       <div class="container">
          <div class="row">
            @foreach ($data as $k => $group)
             <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="service_post style_one">
                   <div class="image">
                      <div class="overlay"></div>
                      <img loading="lazy" width="500" height="500" src="{{ $group->item->items[0]->content }}"" alt="img">
                   </div>
                   <div class="service_content icon_yes">
                      <div class="icon_box">
                         <span class="icon icon-thumbs-up icon"></span>
                      </div>
                      <h2 class="title_service"><a href="#" rel="bookmark">{{ $group->item->items[1]->content }}</a></h2>
                      <p class="short_desc">{{ $group->item->items[2]->content }}</p>
                      {{-- <a class="read_more" href="#"> Leer Más<i class="icon-right-arrow-long"></i></a> OCULTO--}}
                   </div>
                </div>
             </div>
             @endforeach

          </div>
       </div>
    </section>
</div>