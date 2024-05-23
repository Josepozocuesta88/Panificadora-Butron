<?php
namespace App\Services;

use App\Contracts\OfertaServiceInterface;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; 
use App\Models\OfertaC;

class OfertasPersonalizadasService implements OfertaServiceInterface
{
    public function obtenerOfertas()
    {
        $today = Carbon::now();
        $user = Auth::user();
    
        $ofertasPersonalizadas = $user->ofertas()
                        ->whereDate('ofcfecini', '<=', $today)
                        ->whereDate('ofcfecfin', '>=', $today)
                        ->get();
      
        $ofertasGenerales = OfertaC::where('ofccod', '=', '')
            ->whereDate('ofcfecini', '<=', $today)
            ->whereDate('ofcfecfin', '>=', $today)
            ->get();
    
        $ofertas = $ofertasGenerales->concat($ofertasPersonalizadas);
        foreach ($ofertas as $oferta) {
            if ($oferta->ofcima === null || $oferta->ofcima === '') {
                $oferta->ofcima = "noimage.jpg";
            }
        }
        
        // dd($ofertas);
    
        return $ofertas;
    }
    
}


