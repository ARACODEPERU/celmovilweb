<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\CMS\Entities\CmsSection;
use Modules\Onlineshop\Entities\OnliItem;

class PopularProductArea extends Component
{
    protected $products;
    protected $product_popular_area;

    public function __construct()
    {
        $this->products = OnliItem::with('product')->where('existence', 1)
                                    ->where('discount', '>', 0) // para buscar solo con descuentos
                                    ->inRandomOrder()->limit(15)->get();

        $this->product_popular_area = CmsSection::where('component_id', 'productos_populares_area_11')
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.popular-product-area', [
            'products_recommended' => $this->products,
            'product_popular_area' => $this->product_popular_area
        ]);
    }
}
