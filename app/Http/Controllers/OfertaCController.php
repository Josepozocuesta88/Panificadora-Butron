<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Articulo;
use App\Contracts\OfertaServiceInterface;
use App\Models\ClienteArticulo;
use App\Models\ClienteCategoria;
use App\Models\ClienteGrupo;
use App\Models\User;
use App\Services\ArticleService;
use App\Services\OfertasGeneralesService;
use App\Services\OfertasPersonalizadasService;

use function PHPUnit\Framework\isEmpty;

class OfertaCController extends Controller
{
  private $ofertaService;

  public function __construct(OfertaServiceInterface $ofertaService)
  {
    $this->ofertaService = $ofertaService;
  }
  // Los banner publicitarios se muestran cuando están en un determinado rango de fecha
  // ademas de mostrarse según el cliente. Sino se ha asignado ningún cliente al banner, este se mostrara a todos los clientes
  public function index(ArticleService $articleService, OfertasGeneralesService $ofG, OfertasPersonalizadasService $ofP)
  {
    $usutarcod              = Auth::user()->usutarcod;

    // Generales
    $ofertasService     = app(\App\Contracts\OfertaServiceInterface::class);
    $ofertas            = $ofertasService->obtenerOfertas();
    $articulosOferta    = $ofG->obtenerArticulosEnOferta();

    if (ClienteCategoria::where('clicod', Auth::user()->usuclicod)->exists()) {
      $excluidos  = ClienteCategoria::where('clicod', Auth::user()->usuclicod)->pluck('catcod')->toArray();
      $categorias = Category::whereNotIn('catcod', $excluidos)->get();
    } else {
      $categorias = Category::all();
    }

    $usuarioCodigo = Auth::user()->usuclicod;
    $query = Articulo::with('imagenes')->orderby('artfecrea', 'desc')->limit(15);

    $excluidosArticulos = ClienteArticulo::where('clicod', $usuarioCodigo)->pluck('artcod')->toArray();
    $excluidosGrupos = ClienteGrupo::where('clicod', $usuarioCodigo)->pluck('grucod')->toArray();
    $excluidasCategorias = ClienteCategoria::where('clicod', $usuarioCodigo)->pluck('catcod')->toArray();

    if (!empty($excluidosArticulos)) {
      $query->whereNotIn('artcod', $excluidosArticulos);
    }

    if (!empty($excluidosGrupos)) {
      $query->whereNotIn('artgrucod', $excluidosGrupos);
    }

    if (!empty($excluidasCategorias)) {
      $query->whereNotIn('artcatcodw1', $excluidasCategorias);
    }

    $novedades = $query->get();

    // Generales
    $articulosConPrecio     = $articleService->calculatePrices($novedades, $usutarcod);
    // $articleService->calculatePrices($articulosOferta, $usutarcod);

    // Personalizas
    $ofertasServicePer      = app(\App\Contracts\OfertaServiceInterface::class);
    $ofertasPer             = $ofertasServicePer->obtenerOfertas();
    $articulosOfertaPer     = $ofP->obtenerArticulosEnOferta();
    // $articulosConPrecioPer  = $articleService->calculatePrices($novedades, $usutarcod);
    $articulosConPrecioPer  = $articleService->calculatePrices($articulosOfertaPer, $usutarcod);
    // dd($articulosConPrecioPer);
    $favoritos    = Auth::user() ? Auth::user()->favoritos->pluck('favartcod')->toArray() : [];
    $existeOferta = $articulosOfertaPer === null ||  $articulosOfertaPer->isEmpty() ? 0 : 1;

    return view('index', compact(
      'categorias',
      'ofertas',
      'novedades',
      'articulosOferta',
      'favoritos',
      'articulosOfertaPer',
      'ofertasPer',
      'existeOferta',
    ));
  }
}
