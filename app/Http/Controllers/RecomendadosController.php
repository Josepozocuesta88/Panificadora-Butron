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
    public function getRecomendados(Request $artcod)
    {

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
    
        // SQL DE $favoritos
        // select distinct `qarticulo`.`artcod`, `qarticulo`.`artnom`, `qarticulo_precio`.`preimp`, coalesce(coincidencias.coincidencias, 0) as coincidencias 
        // from `qarticulo` 
        // left join (
        //      select `etiartcod`, COUNT(*) as coincidencias 
        //      from `qarticulo_etiqueta` 
        //      where `etitagcod` in (1, 3, 5, 6, 7) 
        //      group by `etiartcod`)
        //  as `coincidencias` on `qarticulo`.`artcod` = `coincidencias`.`etiartcod` 
        // inner join `qarticulo_precio` on `qarticulo_precio`.`preartcod` = `qarticulo`.`artcod` 
        // where `qarticulo_precio`.`pretarcod` = 'E' 
        // and `qarticulo`.`artcod` <> '000001' 
        // order by `coincidencias` desc, `qarticulo`.`artnom` asc limit 15
        $favoritos = Articulo::with('imagenes')
        ->leftJoinSub($subquery, 'coincidencias', function ($join) {
            $join->on('qanet_articulo.artcod', '=', 'coincidencias.etiartcod');
        })
        ->join('qarticulo_precio', 'qarticulo_precio.preartcod', '=', 'qanet_articulo.artcod')
        ->where('qarticulo_precio.pretarcod', $usutarcod)
        ->where('qanet_articulo.artcod', '<>', $artcod->get('artcod'))
        ->select('qanet_articulo.artcod', 'qanet_articulo.artnom', 'qarticulo_precio.preimp', DB::raw('coalesce(coincidencias.coincidencias, 0) as coincidencias'))
        ->orderBy('coincidencias', 'desc')
        ->orderBy('qanet_articulo.artnom')
        ->distinct()
        ->limit(15)
        ->get();
    

    
        return response()->json($favoritos);

    }

}