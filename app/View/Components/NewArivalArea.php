<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Onlineshop\Entities\OnliItem;

class NewArivalArea extends Component
{
    protected $products;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->products = OnliItem::with('product')->where('additional5', 'DE')->paginate(10);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.new-arival-area', [
            'products' => $this->products
        ]);
    }
}
