<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Onlineshop\Entities\OnliItem;

class PopularProductArea extends Component
{
    protected $products;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->products = OnliItem::inRandomOrder()->limit(12)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.popular-product-area', [
            'products_recommended' => $this->products
        ]);
    }
}
