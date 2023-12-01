<?php

namespace App\View\Components\Kentha;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\CMS\Entities\CmsSectionItem;

class HeaderArea extends Component
{
    /**
     * Create a new component instance.
     */
    public $data;

    public function __construct()
    {
        $this->data = CmsSectionItem::with('item.items')->where('section_id', 14)->get();
        //dd($this->data);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.kentha.header-area', [
            'data' => $this->data
        ]);
    }
}
