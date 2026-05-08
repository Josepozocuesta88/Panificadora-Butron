<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Categorias extends Component
{
    /**
     * Create a new component instance.
     */

     public $categorias;

    public function __construct($categorias)
    {
        $this->categorias = $categorias;
    
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.categorias');
    }
}
