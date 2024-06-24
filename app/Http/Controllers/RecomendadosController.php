<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\Articulo;
use App\Models\EtiquetaArticulo;
use App\Models\Favorito;
use App\Models\Precio;




class RecomendadosController extends Controller
{
    public function getRecomendados(Request $request)
    {
        $artcod = $request->artcod;
        // Obtiene el articulo actualmente mostrado
        $articulo = Articulo::find($artcod);

        if (!$articulo) {
            return response()->json(['error' => 'articulo no encontrado'], 404);
        }
        
        // Obtiene las etiquetas del articulo
        $etiquetas = $articulo->pluck('etiquetas.*.tagcod')->flatten();

        $usutarcod = Auth::user()->usutarcod;
        
        $subquery = DB::table('qarticulo_etiqueta')
        ->select('etiartcod', DB::raw('COUNT(*) as coincidencias'))
        ->whereIn('etitagcod', $etiquetas)
        ->groupBy('etiartcod');
        
        $favoritos = Articulo::with('imagenes')
        ->leftJoinSub($subquery, 'coincidencias', function ($join) {
            $join->on('qanet_articulo.artcod', '=', 'coincidencias.etiartcod');
        })
        ->join('qarticulo_precio', 'qarticulo_precio.preartcod', '=', 'qanet_articulo.artcod')
        ->where('qarticulo_precio.pretarcod', $usutarcod)
        ->where('qanet_articulo.artcod', '<>', $request->get('artcod'))
        ->select('qanet_articulo.artcod', 'qanet_articulo.artnom', 'qarticulo_precio.preimp', DB::raw('coincidencias.coincidencias as coincidencias'))
        ->where('coincidencias.coincidencias','<>', 0)
        ->whereHas('usuarios', function($q) {
            $q->where('users.usuclicod', Auth::user()->usuclicod); 
        })
        ->orderBy('coincidencias', 'desc')
        ->orderBy('qanet_articulo.artnom')
        ->distinct()
        ->limit(15)
        ->get();
        
        return response()->json($favoritos);

    }

}