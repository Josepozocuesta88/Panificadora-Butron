<?php
namespace App\Services;

use App\Contracts\OfertaServiceInterface;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; 
use App\Models\OfertaC;


class OfertasGeneralesService implements OfertaServiceInterface
{
    public function obtenerOfertas()
    {
        // Lógica para recuperar ofertas generales
        $today = Carbon::now();

        $ofertas = OfertaC::where('ofccod', '=', '')
                        ->whereDate('ofcfecini', '<=', $today)
                        ->whereDate('ofcfecfin', '>=', $today)
                        ->get();

        return $ofertas;
    }
}



