<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Category;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class NavbarComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $categorias = Category::all();
        $contador = $user ? Cart::where('cartusucod', $user->id)->count() : 0;
        $view->with('categorias', $categorias)->with('contador', $contador);
        
    }
}
