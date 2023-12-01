<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Blog\Entities\BlogArticle;
use Modules\CMS\Entities\CmsSectionItem;

class NewsBlogArea extends Component
{
    /**
     * Create a new component instance.
     */
    public $latest_articles;
    public $data;

    public function __construct()
    {
        $this->data = CmsSectionItem::with('item.items')->where('section_id', 14)->get();

        $this->latest_articles = BlogArticle::with('author')
            ->where('status', true)
            ->latest('created_at') // Ordena por la columna created_at en orden descendente
            ->take(3) // Limita el resultado a 4 registros
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.news-blog-area', [
            'articles' => $this->latest_articles,
            'data'  => $this->data
        ]);
    }
}
