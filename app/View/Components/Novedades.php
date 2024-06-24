<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Novedades extends Component
{
    /**
     * Create a new component instance.
     */
    public $novedades;
    
    public function __construct($novedades)
    {
        $this->novedades = $novedades;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.novedades');
    }
}
