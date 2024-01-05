<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\CMS\Entities\CmsSectionItem;

class TestimoniosArea extends Component
{
    public $data;
    public $titles;

    public function __construct()
    {
        $this->data = CmsSectionItem::with('item.items')
            ->where('section_id', 18)
            ->orderBy('position')
            ->get();

        $this->titles = $this->data;
        $this->data = $this->data->slice(3)->toArray();
        $this->data = json_decode(json_encode($this->data));
    }

    public function render(): View|Closure|string
    {
        return view('components.testimonios-area', [
            'data' => $this->data,
            'titles' => $this->titles
        ]);
    }
}