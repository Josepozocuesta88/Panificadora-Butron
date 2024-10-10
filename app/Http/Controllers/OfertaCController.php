<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

use App\Models\OfertaC;
use App\Models\User;
use App\Models\Category;
use App\Models\Articulo;
use App\Contracts\OfertaServiceInterface;
use App\Services\ArticleService;
use App\Services\OfertasGeneralesService;
use App\Services\OfertasPersonalizadasService;

class OfertaCController extends Controller
{

    private $ofertaService;

    public function __construct(OfertaServiceInterface $ofertaService)
    {
        $this->ofertaService = $ofertaService;
    }

    // Los banner publicitarios se muestran cuando estan en un determinado rango de fecha
    // ademas de mostrarse segun el cliente. Sino se ha asignado ningun cliente al banner, este se mostrara a
    // todos los clientes
    public function index(ArticleService $articleService, OfertasGeneralesService $ofG, OfertasPersonalizadasService $ofP )
    {
        // generales
        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();
        $categorias = Category::all();
        $novedades = Articulo::orderby('artfecrea', 'desc')->limit(15)->with('imagenes')->get();
        $articulosOferta = $ofG->obtenerArticulosEnOferta();

        // personalizas
        $ofertasServicePer = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertasPer = $ofertasServicePer->obtenerOfertas();
        $articulosOfertaPer = $ofP->obtenerArticulosEnOferta();

        if (Auth::user()) {
            $usutarcod = Auth::user()->usutarcod;
            // generales
            $articulosConPrecio = $articleService->calculatePrices($novedades, $usutarcod);
            $articleService->calculatePrices($articulosOferta, $usutarcod);
            // personalizadas
            $articulosConPrecioPer = $articleService->calculatePrices($novedades, $usutarcod);
            $articleService->calculatePrices($articulosOfertaPer, $usutarcod);
        }
        $favoritos = Auth::user() ? Auth::user()->favoritos->pluck('favartcod')->toArray() : [];
        return view('index', compact(
            'categorias',
            'ofertas',
            'novedades',
            'articulosOferta',
            'favoritos',
            'articulosOfertaPer',
            'ofertasPer'

        ));
    }
}
