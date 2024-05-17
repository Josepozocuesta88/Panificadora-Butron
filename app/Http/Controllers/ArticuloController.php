<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; 
use Illuminate\Http\Request;

use App\Models\Articulo;
use App\Models\Articulo_imagen;
use App\Models\Category;
use App\Models\Precio;
use App\Models\Etiqueta;
use App\Models\Caja;
use App\Models\Albarancc;
use App\Models\OfertaC;

use App\Services\ArticleService;
use App\Contracts\OfertaServiceInterface;

class ArticuloController extends Controller
{
    protected $articleService;
    private $ofertaService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }
    //
    // public function index()
    // {
    //     $articulos = Articulo::all();
    //     return $this->prepareView($articulos);
    // }

    public function show($catcod)
    {
        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();

        $categoria = Category::where('id', $catcod)->firstOrFail();
        $articulos = $categoria->articulos()->where('artsit', 'C')->where('artcatcodw1', $catcod)->paginate(12);

        return $this->prepareView($articulos, $categoria->nombre_es, $ofertas);
    }

    public function search(Request $request)
    {   
        $query = $request->get('query');
       
        // $articulos = Articulo::where('artnom', 'like', "%{$query}%")
        //     ->orWhere('artobs', 'like', "%{$query}%")
        //     ->orWhere('artcod', 'like', "%{$query}%")
        //     ->where('artsit', 'C')
        //     ->with('imagenes')
            // ->paginate(12);
        $articulos = Articulo::where(function ($query) use ($request) {
            $searchTerm = $request->get('query');
            $query->where('artnom', 'like', "%{$searchTerm}%")
                  ->orWhere('artobs', 'like', "%{$searchTerm}%")
                  ->orWhere('artcod', 'like', "%{$searchTerm}%");
        })
        ->where('artsit', 'C')
        ->with(['imagenes', 'cajas']) 
        ->paginate(12);
        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();
        
        return $this->prepareView($articulos, null, $ofertas);
    }


    
    public function info($artcod) {
        // Obtenemos el artículo cuyo artcod coincida con el que se pasó por parámetro
        $articulo = Articulo::with('imagenes', 'alergenos', 'cajas')->find($artcod);
    
        if (!$articulo) {
            return redirect('sections.categories')->with('error', 'Artículo no encontrado');
        }
    
        // Obtenemos los alérgenos que contiene este artículo
        $alergenos = $articulo->alergenos->pluck('tagnom');
        $cajas = $articulo->cajas;
        // Obtenemos el precio del artículo
        $articulos = collect([$articulo]); // Crear una colección con el artículo
        $usutarcod = Auth::user() ? Auth::user()->usutarcod : '';
        $usuofecod = Auth::user() ? Auth::user()->usuofecod : '';
        $articulosConPrecio = $this->articleService->calculatePrices($articulos, $usutarcod, $usuofecod); // Obtener precios
        $articuloConPrecio = $articulosConPrecio->first(); // Obtener el artículo actualizado con precio
        // dd($articuloConPrecio);
        return view('sections.article-details', [
            'articulo' => $articuloConPrecio,
            'precio' => $articuloConPrecio->precio,
            'alergenos' => $alergenos,
            'cajas' => $cajas,
            // 'unidades' => $unidades
        ]);
    }
    


    
    public function filters(Request $request, $catnom = null)
    {
        $query = Articulo::query();
        $today = Carbon::now();
        $usutarcod = Auth::user()->usutarcod;
        $query->whereNotNull('artnom');
        $categoriaNombre = null;
        if ($catnom) {
            $query->whereHas('categoria', function ($query) use ($catnom) {
                $query->where('nombre_es', $catnom);
            });
            $categoriaNombre = $catnom;
        }
    
        // Ordenar por oferta
        if ($request->has('orden_oferta')) {
            /*SELECT qarticulo.* FROM qarticulo
            LEFT JOIN qofertac ON qarticulo.artcod = qofertac.ofcartcod
                AND qofertac.ofccod = $usuofecod
                AND qofertac.ofcfecfin >= $today
            GROUP BY qarticulo.artcod
            ORDER BY ISNULL(qofertac.ofcartcod);
            */
            $usuofecod = Auth::user()->usuofecod;
            $query->leftJoin('qofertac', function ($join) use ($today, $usuofecod) {
                $join->on('qanet_articulo.artcod', '=', 'qofertac.ofcartcod')
                     ->where('qofertac.ofccod', $usuofecod)
                     ->where('qofertac.ofcfecfin', '>=', $today);
            })            
            ->orderByRaw('ISNULL(qofertac.ofcartcod)')
            ->select('qanet_articulo.*')
            ->groupBy('qanet_articulo.artcod');
        }
    
        // Ordenar por precio
        if ($request->has('orden_precio')) {
            $usutarcod = Auth::user()->usutarcod;
        
            $query->orderBy(
                Precio::select('preimp')
                    ->whereColumn('preartcod', 'qanet_articulo.artcod')
                    ->where('pretarcod', $usutarcod)
                    ->orderBy('preimp', $request->input('orden_precio'))
                    ->limit(1), 
                $request->input('orden_precio')
            );
        }
    
        // Ordenar por nombre
        if ($request->has('orden_nombre')) {
            $query->orderBy('artnom', $request->input('orden_nombre')); 
        }
        $articulos = $query->paginate(12)->appends($request->all());
        // dd($articulos);
        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();

        return $this->prepareView($articulos, $categoriaNombre, $ofertas);
    }
    
    


    // funciones privadas
    private function prepareView($articulos, $catnom = null, $ofertas = null)
    {
        $favoritos = Auth::user() ? Auth::user()->favoritos->pluck('favartcod')->toArray() : [];
        $categorias = Category::all();

        if (Auth::user()) {
            $usutarcod = Auth::user()->usutarcod;
            $usuofecod = Auth::user()->usuofecod;

            $articulosConPrecio = $this->articleService->calculatePrices($articulos, $usutarcod, $usuofecod);
        }

        return view('sections.categories', [
            'categorias' => $categorias, 
            'articulos' => $articulos, 
            'catnom' => $catnom,
            'favoritos' => $favoritos,
            'ofertas' => $ofertas,
        ]);
    }
    
}