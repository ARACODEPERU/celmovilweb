<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\CMS\Entities\CmsSectionItem;

class ClientesArea extends Component
{
    /**
     * Create a new component instance.
     */
    
    public $data;

    public function __construct()
    {
        $this->data = CmsSectionItem::with('item.items')
                        ->where('section_id', 5)
                        ->orderBy('position')
                        ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.clientes-area', [
            'data' => $this->data
        ]);
    }
}
