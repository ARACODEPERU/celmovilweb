<div>
    <section class="faq-section bg_op_1 position-relative"
        style="background: url(themes/kentha/assets/images/footer-bg-two.jpg);">
        <div class="position_absolute top curve_shape_top_2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path class="elementor-shape-fill" opacity="0.33"
                    d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z">
                </path>
                <path class="elementor-shape-fill" opacity="0.66"
                    d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z">
                </path>
                <path class="elementor-shape-fill"
                    d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z">
                </path>
            </svg>
        </div>
        <div class="container-fluid pd_zero">
            <div class="row">
                <div
                    class="col-lg-6 col-sm-12 col-xs-12  pd_left_100 pd_right_100 md_pd_left_15 md_pd_right_15">
                    <!--===============spacing==============-->
                    <div class="pd_top_110"></div>
                    <!--===============spacing==============-->
                    <div class="title_all_box style_six light_color">
                        <div class="title_sections">
                            <div class="before_title">
                                <span class="icon-briefcase icon"></span>
                                {{ $titles[0]->item->content }}
                            </div>
                            <div class="title">{{ $titles[1]->item->content }}</div>
                        </div>
                    </div>
                    <!--===============spacing==============-->
                    <div class="pd_bottom_20"></div>
                    <!--===============spacing==============-->
                    <div class="faq_box_all  border_enable">
                        <dl class="accordion faqs_accordion type_one light_color">
                            @foreach ($data as $k => $group)  
                                <dt class="article-title">
                                    <div class="title_box">
                                        <span class="faq_no">{{ $group->item->items[0]->content }} </span> {{ $group->item->items[1]->content }}
                                    </div>
                                </dt>
                                <dd class="accordion-content">
                                    {{ $group->item->items[2]->content }}
                                </dd>
                            @endforeach

                            <!--
                            <dt class="article-title ">
                                <div class="title_box">
                                    <span class="faq_no">2 </span> How can content marketing help purchase
                                    journey?
                                </div>
                            </dt>
                            <dd class="accordion-content">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </dd>
                            <dt class="article-title ">
                                <div class="title_box">
                                    <span class="faq_no">3 </span> How do we measure content’s on sales and
                                    revenue?
                                </div>
                            </dt>
                            <dd class="accordion-content">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </dd>
                            <dt class="article-title ">
                                <div class="title_box">
                                    <span class="faq_no">4 </span> Pain these cases are perfectly simple and
                                    easy to
                                    distinguish.
                                </div>
                            </dt>
                            <dd class="accordion-content">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                            </dd>
                            -->

                        </dl>
                    </div>
                    <!--===============spacing==============-->
                    <div class="pd_bottom_110"></div>
                    <!--===============spacing==============-->
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12 position-relative z_99"
                    style="background-image: url({{ $titles[2]->item->content }});">

                </div>

            </div>
        </div>
        <div class="position_absolute curve_shape_bottom_2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                <path class="elementor-shape-fill" opacity="0.33"
                    d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z">
                </path>
                <path class="elementor-shape-fill" opacity="0.66"
                    d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z">
                </path>
                <path class="elementor-shape-fill"
                    d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z">
                </path>
            </svg>
        </div>
    </section>
</div>