<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\CMS\Entities\CmsSection;

class HeaderArea extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $tel_email = CmsSection::where('component_id', 'header_top_1')  //siempre cambiar el id del componente
        ->join('cms_section_items', 'section_id', 'cms_sections.id')
        ->join('cms_items', 'cms_section_items.item_id', 'cms_items.id')
        ->select(
            'cms_items.content',
            'cms_section_items.position'
        )
        ->orderBy('cms_section_items.position')
        ->get();

        return view('components.header-area',[
            'tel_email' => $tel_email,
        ]);
    }
}
