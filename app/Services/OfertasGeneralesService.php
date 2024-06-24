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
        $today = Carbon::now();

        $ofertas = OfertaC::where('ofccod', '=', '')
                          ->whereDate('ofcfecini', '<=', $today)
                          ->whereDate('ofcfecfin', '>=', $today)
                          ->get();

        foreach ($ofertas as $oferta) {
            if ($oferta->ofcima === null || $oferta->ofcima === '') {
                $oferta->ofcima = "noimage.jpg";
            }
        }

        return $ofertas;
    }
}