<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Articulo;
use App\Models\Category;
use App\Models\Precio;

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


    public function showByCategory($catcod)
    {
        $ofertasService = app(OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();

        $categoria = Category::where('id', $catcod)->firstOrFail();

        if (Auth::user()) {
            if (auth()->user()->categorias()->count() == 0 && auth()->user()->articulos()->count() == 0) {
                $articulos = $categoria->articulos()
                    ->where('artsit', 'C')
                    ->where('artcatcodw1', $catcod)
                    ->restrictions()
                    ->paginate(12);
            } else {
                $articulos = auth()->user()->accessibleArticles()->orwhereHas('usuarios', function ($q) {
                    $q->where('users.usuclicod', Auth::user()->usuclicod);
                })->with(['cajas', 'imagenes'])->paginate(12);
            }
        } else {

            $articulos = $categoria->articulos()->where(function ($query) {
                $query->where('artsolcli', '<>', 1)
                    ->orWhereNull('artsolcli');
            })
                ->where('artsit', 'C')
                ->where('artcatcodw1', $catcod)
                ->paginate(12);
        }

        session()->forget('search');
        return $this->prepareView($articulos, $categoria->nombre_es, $ofertas);
    }

    public function info($artcod)
    {
        $articulo = Articulo::with('imagenes', 'alergenos', 'cajas')->find($artcod);


        if (!$articulo) {
            return redirect('/articles/search?query=')->with('error', 'Artículo no encontrado');
        }

        $alergenos = $articulo->alergenos->pluck('tagnom');
        $cajas = $articulo->cajas;

        $articulos = collect([$articulo]);
        $usutarcod = Auth::user() ? Auth::user()->usutarcod : '';
        $articulosConPrecio = $this->articleService->calculatePrices($articulos, $usutarcod);
        $articuloConPrecio = $articulosConPrecio->first();

        return view('pages.ecommerce.productos.article-details', [
            'articulo' => $articuloConPrecio,
            'precio' => $articuloConPrecio->precio,
            'alergenos' => $alergenos,
            'cajas' => $cajas,
        ]);
    }

    public function search(Request $request)
    {
        session(['search' => $request->get('query')]);
        // session(['filters' => $request->all()]);

        $keywords = explode(' ', $request->get('query'));


        if (Auth::user()) {
            if (auth()->user()->categorias()->count() == 0 && auth()->user()->articulos()->count() == 0) {
                $articulos = Articulo::situacion('C')
                    ->search($keywords)
                    ->restrictions()
                    ->with(['imagenes', 'cajas'])
                    ->paginate(12);
            } else {
                $articulos = auth()->user()->accessibleArticles()->orwhereHas('usuarios', function ($q) {
                    $q->where('users.usuclicod', Auth::user()->usuclicod);
                })->with(['cajas', 'imagenes'])->paginate(12);
            }
        } else {
            $articulos = Articulo::situacion('C')
                ->search($keywords)
                ->where(function ($query) {
                    $query->where('artsolcli', '<>', 1)
                        ->orWhereNull('artsolcli');
                })
                ->with(['imagenes', 'cajas'])
                ->paginate(12);
        }
        // dd($articulos);
        $ofertasService = app(OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();

        return $this->prepareView($articulos, null, $ofertas);
    }

    public function filters(Request $request, $catnom = null)
    {
        $search = session('search');
        // $filters = session('filters');

        $keywords = explode(' ', $search);
        if (auth()->user()->categorias()->count() == 0 && auth()->user()->articulos()->count() == 0) {
            $query = Articulo::situacion('C')
                ->search($keywords)
                ->restrictions()
                ->with(['imagenes', 'cajas']);

        } else {
            $query = auth()->user()->accessibleArticles()->situacion('C')
                ->search($keywords)->orwhereHas('usuarios', function ($q) {
                    $q->where('users.usuclicod', Auth::user()->usuclicod);
                })->with(['cajas', 'imagenes']);
        }

        // logica filtros
        $today = Carbon::now();
        $usutarcod = Auth::user() ? Auth::user()->usutarcod : '';
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

        $articulos = $query->paginate(12)->appends($request->all());

        $ofertasService = app(OfertaServiceInterface::class);
        $ofertas = $ofertasService->obtenerOfertas();

        return $this->prepareView($articulos, $catnom, $ofertas);
    }



    private function prepareView($articulos, $catnom = null, $ofertas = null)
    {
        $favoritos = Auth::user() ? Auth::user()->favoritos->pluck('favartcod')->toArray() : [];

        $categorias = Category::all();

        if (Auth::user()) {
            $usutarcod = Auth::user()->usutarcod;
            $usuofecod = Auth::user()->usuofecod;

            $articulosConPrecio = $this->articleService->calculatePrices($articulos, $usutarcod);
        }

        return view('pages.ecommerce.productos.products', compact('categorias', 'articulos', 'catnom', 'favoritos', 'ofertas'));
    }

}