<div>
    <!-- slider - pc - section start -->
    <div class="slider-area slider-one clearfix view-pc" style="margin-top: 60px;">
        <div class="slider" id="mainslider" style="height: 500px;">
            @foreach ($sliders as $slide)
                <div data-src="{{ $slide->content }}"></div>
            @endforeach
        </div>
    </div>
    <!-- slider - pc - section end -->
</div>