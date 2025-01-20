<?php

namespace App\Services;

use App\Contracts\OfertaServiceInterface;
use App\Models\ClienteArticulo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\OfertaC;

class OfertasGeneralesService implements OfertaServiceInterface
{
    public function obtenerOfertas()
    {
        $today  = Carbon::now();



        if (Auth::user() && ClienteArticulo::where('clicod', Auth::user()->usuclicod)->exists()) {
            $excluidos = ClienteArticulo::where('clicod', Auth::user()->usuclicod)->pluck('artcod');
            $ofertas    = OfertaC::whereHas('articulo', function ($q) use ($excluidos) {
                $q->whereNotIn('artcod', $excluidos);
            })->with('articulo',)->where('ofccod', '=', '')
                ->whereDate('ofcfecini', '<=', $today)
                ->whereDate('ofcfecfin', '>=', $today)
                ->get();
        } else {
            $ofertas    = OfertaC::with('articulo')->where('ofccod', '=', '')
                ->whereDate('ofcfecini', '<=', $today)
                ->whereDate('ofcfecfin', '>=', $today)
                ->get();
        }

        foreach ($ofertas as $oferta) {
            if ($oferta->ofcima === null || $oferta->ofcima === '') {
                $oferta->ofcima = "noimage.jpg";
            }
        }

        return $ofertas;
    }

    public function obtenerArticulosEnOferta()
    {
        $today      = Carbon::now();
        $articulos  = OfertaC::with('articulo')->where('ofccod', '=', '')
            ->whereDate('ofcfecini', '<=', $today)
            ->whereDate('ofcfecfin', '>=', $today)
            ->get()
            ->pluck('articulo')
            ->filter(function ($articulo) {
                return $articulo !== null;
            });

        return $articulos;
    }
}
