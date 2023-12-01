<div>
    <section class="project_all filt_style_two filter_enabled">
       <div class="pd_top_90"></div>
          <div class="container">
           <div class="project_container clearfix">
              <div class="row clearfix">
                @foreach ($data as $k => $group)  
                <div class="project-wrapper grid-item col-lg-12 col-md-12 col-sm-12 col-xs-12 project_category-coaching">
                    <div class="project_box style_three clearfix">
                       <div class="content_inner">
                          <div><a href="{{ $group->item->items[3]->content }}" target="_blank">Proyecto Exitoso!</a></div>
                          <h2><a href="{{ $group->item->items[3]->content }}" target="_blank">{{ $group->item->items[1]->content }}</a></h2>
                          <p class="short_desc">
                            {{ $group->item->items[2]->content }} 
                          </p>
                          <a href="{{ $group->item->items[3]->content }}" target="_blank" class="read_more">Más Información <span
                                class="icon-right-arrow-long"></span></a>
                       </div>
                       <div class="image">
                          <img loading="lazy" width="370" height="247" src="{{ $group->item->items[0]->content }}"  class="wp-post-image" alt="img">
                          <a href="{{ $group->item->items[3]->content }}" target="_blank" class="pro-link"></a>
                          <div class="overlay"> </div>
                       </div>
                    </div>
                </div>
                @endforeach

              </div>
           </div>
        </div>
       <div class="pd_bottom_90"></div>
    </section>
</div>