<?php

namespace Modules\Blog\View\Components;

use Illuminate\View\Component;
use Modules\Blog\Entities\BlogCategory;

class BlogWebNavStories extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $categories = BlogCategory::where('status', true)->get();

        return view('blog::components.blogwebnavstories', compact('categories'));
    }
}
