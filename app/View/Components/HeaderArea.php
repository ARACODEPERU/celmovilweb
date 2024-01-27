<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\CMS\Entities\CmsSection;
use Modules\Sales\Entities\SaleProductCategory;

class HeaderArea extends Component
{
    protected $categories;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categories = SaleProductCategory::with('subcategories')
            ->where('status', true)
            ->whereNull('category_id')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $tel_email_logo = CmsSection::where('component_id', 'header_1')  //siempre cambiar el id del componente
            ->join('cms_section_items', 'section_id', 'cms_sections.id')
            ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
            ->select(
                'cms_items.content',
                'cms_section_items.position'
            )
            ->orderBy('cms_section_items.position')
            ->get();

        return view('components.header-area', [
            'tel_email_logo' => $tel_email_logo,
            'categories' => $this->categories
        ]);
    }
}
