<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Onlineshop\Entities\OnliItem;

class ProductDescArea extends Component
{
    protected $products_desc;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->products_desc = OnliItem::with('product')
            ->where('additional5', 'DE')
            ->where('existence', 1)
            ->orderBy('id', 'DESC')
            ->paginate(4);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-desc-area', [
            'products_desc' => $this->products_desc
        ]);
    }
}
