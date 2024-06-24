<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Cart;
use App\Models\Representante;

use Illuminate\Support\Facades\Auth;

class NavbarComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $contador = $user ? Cart::where('cartusucod', $user->id)->count() : 0;
        $representante = $user ? Representante::where('rprcod', $user->usurprcod)->first() : null;

        $view->with([
            'contador' => $contador,
            'representante' => $representante
        ]);
    }
}
