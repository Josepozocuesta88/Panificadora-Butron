<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Articulo;

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
        // $category = new Category();
        // $categories = Auth::user() ? $category->esCliente(true) : $category->esCliente(false);

        $categories = Category::all();
        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();
        $novedades = Articulo::orderby('artfecrea', 'desc')->limit(15)->with('imagenes')->get();

        return view('welcome', compact('categories', 'ofertas', 'novedades'));
    }

    public function show() {
        $categories = Category::all();
        return view('sections.categories', compact('categories'));
    }

    public function searchCategory(Request $request)
    {   
        $query = $request->get('query');

        $categorias = Category::where('nombre_es', 'like', "%{$query}%")->get();
        
        $articulos = Articulo::with('imagenes')->paginate(12);
        
        $favoritos = Auth::user()? Auth::user()->favoritos->pluck('favartcod')->toArray() : [];
        
        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();

        $usutarcod = Auth::user() ? Auth::user()->usutarcod : '';
        $usuofecod = Auth::user() ? Auth::user()->usuofecod : '';
        $articulosConPrecio = $this->articleService->calculatePrices($articulos, $usutarcod, $usuofecod);

        return view('sections.categories', ['categorias' => $categorias, 'articulos' => $articulos, 'favoritos' => $favoritos, 'ofertas' => $ofertas]);
    }
}