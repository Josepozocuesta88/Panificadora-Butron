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

    public function show($catcod)
    {
        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();

        $categoria = Category::where('id', $catcod)->firstOrFail();

        if (Auth::user()) {
            $articulos = $categoria->articulos()
                    ->where('artsit', 'C')
                    ->where('artcatcodw1', $catcod)
                    ->paginate(12);
        }else{

            $articulos = $categoria->articulos()->where(function ($query) {
                $query->where('artsolcli', '<>', 1)
                        ->orWhereNull('artsolcli');
                    })
                    ->where('artsit', 'C')
                    ->where('artcatcodw1', $catcod)
                    ->paginate(12);
        }

        return $this->prepareView($articulos, $categoria->nombre_es, $ofertas);
    }

    public function search(Request $request)
    {   

        $cadLeida = explode(' ', $request->get('query')); 

        if (Auth::user()) {
            $articulos = Articulo::where('artsit', 'C')
            ->where(function ($query) use ($cadLeida) {
                foreach ($cadLeida as $word) {
                    $query->orWhere('artnom', 'LIKE', '%' . $word . '%');
                }
            })->orWhere(function ($query) use ($cadLeida) {
                foreach ($cadLeida as $word) {
                    $query->orWhere('artobs', 'LIKE', '%' . $word . '%');
                }
            })->orWhere(function ($query) use ($cadLeida) {
                foreach ($cadLeida as $word) {
                    $query->orWhere('artcod', 'LIKE', '%' . $word . '%');
                }
            })
            ->with(['imagenes', 'cajas']) 
            ->paginate(12);
        }else{

            $articulos = Articulo::where(function ($query) {
                    $query->where('artsolcli', '<>', 1)
                        ->orWhereNull('artsolcli');
                })
                ->where('artsit', 'C')
                ->where(function ($query) use ($cadLeida) {
                    $query->where(function ($subQuery) use ($cadLeida) {
                        foreach ($cadLeida as $word) {
                            $subQuery->orWhere('artnom', 'LIKE', '%' . $word . '%');
                        }
                    })->orWhere(function ($subQuery) use ($cadLeida) {
                        foreach ($cadLeida as $word) {
                            $subQuery->orWhere('artobs', 'LIKE', '%' . $word . '%');
                        }
                    })->orWhere(function ($subQuery) use ($cadLeida) {
                        foreach ($cadLeida as $word) {
                            $subQuery->orWhere('artcod', 'LIKE', '%' . $word . '%');
                        }
                    });
                })
                ->with(['imagenes', 'cajas'])
                ->paginate(12);
        
        }

        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();
        
        return $this->prepareView($articulos, null, $ofertas);
    }

    
    public function info($artcod) {
        $articulo = Articulo::with('imagenes', 'alergenos', 'cajas')->find($artcod);
    
        if (!$articulo) {
            return redirect('sections.categories')->with('error', 'Artículo no encontrado');
        }
    
        $alergenos = $articulo->alergenos->pluck('tagnom');
        $cajas = $articulo->cajas;

        $articulos = collect([$articulo]); 
        $usutarcod = Auth::user() ? Auth::user()->usutarcod : '';
        $usuofecod = Auth::user() ? Auth::user()->usuofecod : '';
        $articulosConPrecio = $this->articleService->calculatePrices($articulos, $usutarcod, $usuofecod); 
        $articuloConPrecio = $articulosConPrecio->first(); 

        return view('sections.article-details', [
            'articulo' => $articuloConPrecio,
            'precio' => $articuloConPrecio->precio,
            'alergenos' => $alergenos,
            'cajas' => $cajas,
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
    
        if ($request->has('orden_oferta')) {
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
    
        if ($request->has('orden_nombre')) {
            $query->orderBy('artnom', $request->input('orden_nombre')); 
        }

        if (Auth::user()) {
            $articulos = $query->paginate(12)->appends($request->all());
        }else{
            $articulos = $query->where(function ($query) {
                $query->where('artsolcli', '<>', 1)
                    ->orWhereNull('artsolcli');
            })->paginate(12)->appends($request->all());
        }

        $ofertasService = app(\App\Contracts\OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();

        return $this->prepareView($articulos, $categoriaNombre, $ofertas);
    }
    


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