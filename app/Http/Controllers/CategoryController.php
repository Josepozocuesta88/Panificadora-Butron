<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Articulo;
use App\Models\ClienteArticulo;
use App\Models\ClienteCategoria;
use App\Services\ArticleService;


class CategoryController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $categories = Category::all();
        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();
        $novedades = Articulo::orderby('artfecrea', 'desc')->limit(15)->with('imagenes')->get();

        return view('welcome', compact('categories', 'ofertas', 'novedades'));
    }

    public function show()
    {
        if (ClienteCategoria::where('clicod', Auth::user()->usuclicod)->exists()) {
            $excluidos = ClienteCategoria::where('clicod', Auth::user()->usuclicod)->pluck('catcod');
            $categorias = Category::whereNotIn('catcod', $excluidos)->get();
        } else {
            $categorias = Category::all();
        }

        return view('pages.ecommerce.productos.categories', compact('categorias'));
    }

    public function searchCategory(Request $request)
    {
        $query = $request->get('query');

        $categorias = Category::where('catnom', 'like', "%{$query}%")->get();

        if (ClienteArticulo::where('clicod', Auth::user()->usuclicod)->exists()) {
            $excluidos = ClienteArticulo::where('clicod', Auth::user()->usuclicod)->pluck('artcod');
            $articulos = Articulo::whereNotIn('artcod', $excluidos)
                ->with('imagenes')
                ->paginate(12);
        } else {
            $articulos = Articulo::with('imagenes')->paginate(12);
        }

        $favoritos = Auth::user() ? Auth::user()->favoritos->pluck('favartcod')->toArray() : [];

        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();

        $usutarcod = Auth::user() ? Auth::user()->usutarcod : '';
        $usuofecod = Auth::user() ? Auth::user()->usuofecod : '';
        $articulosConPrecio = $this->articleService->calculatePrices($articulos, $usutarcod);

        return view('pages.ecommerce.productos.categories', ['categorias' => $categorias, 'articulos' => $articulos, 'favoritos' => $favoritos, 'ofertas' => $ofertas]);
    }
}
