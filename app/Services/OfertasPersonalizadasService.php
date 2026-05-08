<?php

namespace App\Services;

use App\Contracts\OfertaServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\OfertaC;

class OfertasPersonalizadasService implements OfertaServiceInterface
{
  // public function obtenerOfertas()
  // {
  //   $today      = Carbon::now();
  //   $usuofecod  = Auth::user()->usuofecod;

  //   $ofertas    = OfertaC::with('articulo')->whereDate('ofcfecfin', '>=', $today)
  //     ->where(function ($query) use ($usuofecod) {
  //       $query->where('ofccod', $usuofecod);
  //     })
  //     ->orderByRaw("CASE WHEN ofccod = ? THEN 1 ELSE 2 END", [$usuofecod])
  //     ->get();

  //   foreach ($ofertas as $oferta) {
  //     if ($oferta->ofcima === null || $oferta->ofcima === '') {
  //       $oferta->ofcima = "noimage.jpg";
  //     }
  //   }
  //   return $ofertas;
  // }

  // public function obtenerArticulosEnOferta()
  // {
  //   $today      = Carbon::now();
  //   $user       = Auth::user();
  //   $usuofecod  = $user ? $user->usuofecod : null;
  //   $articulos  = OfertaC::with('articulo')->whereDate('ofcfecfin', '>=', $today)
  //     ->where('ofccod', $usuofecod)
  //     ->orderByRaw("CASE WHEN ofccod = ? THEN 1 ELSE 2 END", [$usuofecod])
  //     ->get()
  //     ->pluck('articulo')
  //     ->filter(function ($articulo) {
  //       return $articulo !== null;
  //     });

  //   return $articulos;
  // }


  // prueba
  public function obtenerOfertas()
  {
    $today      = Carbon::now();
    $usuclicod  = Auth::user()->usuclicod;

    $ofertas    = OfertaC::with('articulo')
      ->whereDate('ofcfecfin', '>=', $today)
      ->where(function ($query) use ($usuclicod) {
        $query->where('ofccod', $usuclicod)
          ->orWhereHas('articulo', function ($q) use ($usuclicod) {
            $q->where('artfamcod', $usuclicod);
          });
      })
      ->orderByRaw("CASE WHEN ofccod = ? THEN 1 ELSE 2 END", [$usuclicod])
      ->get();

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
    $user       = Auth::user();
    $usuclicod  = $user ? $user->usuclicod : null;

    $articulos  = OfertaC::with('articulo')
      ->whereDate('ofcfecfin', '>=', $today)
      ->where(function ($query) use ($usuclicod) {
        $query->where('ofccod', $usuclicod)
          ->orWhereHas('articulo', function ($q) use ($usuclicod) {
            $q->where('artfamcod', $usuclicod);
          });
      })
      ->orderByRaw("CASE WHEN ofccod = ? THEN 1 ELSE 2 END", [$usuclicod])
      ->get()
      ->pluck('articulo')
      ->filter(function ($articulo) {
        return $articulo !== null;
      });

    return $articulos;
  }
}
