<?php

namespace App\Services;

use App\Contracts\OfertaServiceInterface;
use App\Models\ClienteArticulo;
use App\Models\ClienteGrupo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\OfertaC;

class OfertasGeneralesService implements OfertaServiceInterface
{
  public function obtenerOfertas()
  {
    $today  = Carbon::now();

    if (Auth::check() && !is_null(Auth::user()->usuofecod)) {
      $usuarioCodigo = Auth::user()->usuclicod;
      $query = OfertaC::with('articulo')
        ->where('ofccod', '=', '')
        ->whereDate('ofcfecini', '<=', $today)
        ->whereDate('ofcfecfin', '>=', $today);

      $excluidosArticulos = ClienteArticulo::where('clicod', $usuarioCodigo)->pluck('artcod')->toArray();
      $excluidosGrupos = ClienteGrupo::where('clicod', $usuarioCodigo)->pluck('grucod')->toArray();

      if (!empty($excluidosArticulos)) {
        $query->whereHas('articulo', function ($q) use ($excluidosArticulos) {
          $q->whereNotIn('artcod', $excluidosArticulos);
        });
      }

      if (!empty($excluidosGrupos)) {
        $query->whereHas('articulo', function ($q) use ($excluidosGrupos) {
          $q->whereNotIn('artgrucod', $excluidosGrupos);
        });
      }

      $ofertas = $query->get();
    } else {
      $ofertas = OfertaC::with('articulo')
        ->where('ofccod', '=', '')
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
