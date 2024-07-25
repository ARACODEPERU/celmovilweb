<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Onlineshop\Entities\OnliItem;

class FeatureProductsArea extends Component
{
    protected $feature_products;

    public function __construct()
    {
        $this->feature_products = OnliItem::with('product')
        ->orderBy('id', 'desc')
        ->limit(6)
        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.feature-products-area', [
            'feature_products' => $this->feature_products
        ]);
    }
}
