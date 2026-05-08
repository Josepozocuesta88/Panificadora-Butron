<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Pedido;
use App\Models\Puntos;
use App\Models\Articulo;
use Carbon\Carbon;


class PuntosController extends Controller
{
    //
    public function allPoints(){
        $user = Auth::user();
        $clienteId = Auth::user()->id;

        $puntos = DB::table('pedidos')
        ->join('pedidos_lineas', 'pedidos.id', '=', 'pedidos_lineas.pedido_id')
        ->join('qanet_articulo', 'pedidos_lineas.producto_ref', '=', 'qanet_articulo.artcod')
        ->where('qanet_articulo.puntos', '>', 0)
        ->sum('qanet_articulo.puntos');
        

        return view('pages.ecommerce.pedidos.points')->with('puntos', $puntos);
        
    }

    public function getPoints(Request $request){
        if ($request->ajax()) {
          
            $user = Auth::user();
            $clienteId = Auth::user()->usuclicod;

            $puntos = DB::table('pedidos')
                ->join('pedidos_lineas', 'pedidos.id', '=', 'pedidos_lineas.pedido_id')
                ->join('qanet_articulo', 'pedidos_lineas.producto_ref', '=', 'qanet_articulo.artcod')
                ->select('pedidos.fecha', 'qanet_articulo.artcod', 'qanet_articulo.artnom', 'pedidos_lineas.cantidad', 'pedidos_lineas.precio', 'qanet_articulo.puntos')
                ->where('qanet_articulo.puntos', '>', 0)
                // ->where('cliente_id', $clienteId)
                ->get();
            Log::info('Datos procesados', ['puntos' => $puntos]);
        
            $data = collect($puntos);
        
            return response()->json(['data' => $data]);
        }
        return view('pages.ecommerce.pedidos.points');
    }

}
