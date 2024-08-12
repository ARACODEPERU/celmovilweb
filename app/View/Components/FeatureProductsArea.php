<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\CMS\Entities\CmsSection;
use Modules\Onlineshop\Entities\OnliItem;

class FeatureProductsArea extends Component
{
    protected $feature_products;
    protected $product_new_area;

    public function __construct()
    {
        $this->feature_products = OnliItem::with('product')
        ->orderBy('id', 'desc')
        ->limit(6)
        ->get();
        
        $this->product_new_area = CmsSection::where('component_id', 'productos_nuevos_area_10')
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
        return view('components.feature-products-area', [
            'feature_products' => $this->feature_products,
            'product_new_area' => $this->product_new_area
        ]);
    }
}
