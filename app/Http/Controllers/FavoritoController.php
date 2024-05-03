<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; 
use App\Models\Favorito;
use App\Models\Articulo;
use App\Models\Precio;
use App\Models\OfertaC;




class FavoritoController extends Controller {

    public function index() {
        $usuarioId = Auth::id(); 
    
        $favoritos = Favorito::where('favusucod', $usuarioId)->get();
    
        // Recupera los artículos asociados a los favoritos
        $articulosIds = $favoritos->pluck('favartcod'); 
        $articulos = Articulo::whereIn('artcod', $articulosIds)->paginate(8);
        $articulos = $this->getPrice($articulos);
    
        return view('sections.favoritos', compact('articulos'));
    }
    
    
    public function store(Request $request) {
        $artcod = $request->artcod;

        // Asegúrate de validar y verificar que el usuario no haya marcado ya el producto como favorito

        $favorito = new Favorito();
        $favorito->favusucod = Auth::id();
        $favorito->favartcod = $artcod;
        $favorito->save();

        return response()->json(['message' => 'Producto añadido a favoritos']);
    }

    public function delete(Request $request) {
        $artcod = $request->artcod;
        $usuarioId = Auth::id();
    
        $favorito = Favorito::where('favusucod', $usuarioId)->where('favartcod', $artcod)->first();
        
        if ($favorito) {
            $favorito->delete();
            return response()->json(['message' => 'Producto eliminado de favoritos']);
        } else {
            return response()->json(['message' => 'Producto no encontrado en favoritos'], 404);
        }
    }


    private function getPrice($articulos) {
        $usutarcod = Auth::user()->usutarcod;
        $usuofecod = Auth::user()->usuofecod;
        $today = Carbon::now();
    
        foreach ($articulos as $articulo) {
            // Obtener el precio de la tarifa
            $precioTarifa = Precio::where('preartcod', $articulo->artcod)
                                   ->where('pretarcod', $usutarcod)
                                   ->first();
    
            $articulo->precioTarifa = $precioTarifa ? $precioTarifa->preimp : null;
    
            // Intentar obtener el precio de oferta
            $precioOferta = OfertaC::where('ofcartcod', $articulo->artcod)
                                   ->where('ofccod', $usuofecod)
                                   ->whereDate('ofcfecfin', '>=', $today)
                                   ->first();
    
            if ($precioOferta && $precioOferta->OFCIMP != null) {
                if ($precioOferta->ofctip == 'XP') {
                    // Precio de oferta directo
                    $articulo->precioOferta = $precioOferta->OFCIMP;
                    $articulo->precioDescuento = null; // No hay porcentaje de descuento
                } elseif ($precioOferta->ofctip == 'XD') {
                    // Aplicar descuento porcentual al precio de la tarifa
                    $descuento = ($precioTarifa->preimp * $precioOferta->OFCIMP) / 100;
                    $articulo->precioOferta = $precioTarifa->preimp - $descuento;
                    $articulo->precioDescuento = $precioOferta->OFCIMP; 
                }
            } else {
                $articulo->precioOferta = null;
                $articulo->precioDescuento = null;
            }
        }
    
        return $articulos;
    }
    
}

