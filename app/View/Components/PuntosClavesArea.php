<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\CMS\Entities\CmsSectionItem;

class PuntosClavesArea extends Component
{
    /**
     * Create a new component instance.
     */
    public $titles;
    public $data;

    public function __construct()
    {
        $this->data = CmsSectionItem::with('item.items')->where('section_id', 20)
                                                                ->orderBy('position')   //hay que revisar el ORDEN aqui es medio raro funciona por ahora 21/09/2023
                                                                ->get();

        $this->titles = $this->data;
        $this->data = $this->data->toArray();
        $this->data = array_slice($this->data, 3); // Quitar los primeros tres elementos ya que ellos tienen información del titulo y ensucian el arreglo de los demas elementos
        $this->data = json_decode(json_encode($this->data));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.puntos-claves-area', [
            'data' => $this->data,
            'titles' => $this->titles
        ]);
    }
}
