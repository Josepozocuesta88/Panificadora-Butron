<?php
// app/Services/ArticleService.php

namespace App\Services;

use Carbon\Carbon;
// use App\Models\Articulo;

class ArticleService
{
    /**
     * Calcula los precios de una colección de artículos.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $articulos
     * @param  string  $usutarcod
     * @param  string  $usuofecod
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function calculatePrices($articulos, $usutarcod, $usuofecod)
    {
        $today = Carbon::now();

        foreach ($articulos as $articulo) {
            $precioTarifa = $articulo->getPriceForUser($usutarcod);
            $articulo->precioTarifa = $precioTarifa;
            $oferta = $articulo->getPriceWithOffer($usuofecod, $today);

            if ($oferta) {
                if ($oferta['ofctip'] == 'XP') {
                    $articulo->precioOferta = $oferta['ofcimp'];
                    $articulo->precioDescuento = null;
                } elseif ($oferta['ofctip'] == 'XD') {
                    $descuento = ($precioTarifa * $oferta['ofcimp']) / 100;
                    $articulo->precioOferta = $precioTarifa - $descuento;
                    $articulo->precioDescuento = $oferta['ofcimp'];
                }
            } else {
                $articulo->precioOferta = null;
                $articulo->precioDescuento = null;
            }
        }

        return $articulos;
    }
}
