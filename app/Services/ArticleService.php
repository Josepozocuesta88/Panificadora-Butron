<?php
// app/Services/ArticleService.php

namespace App\Services;

use Carbon\Carbon;
// use App\Models\Articulo;

class ArticleService
{

    public function calculatePrices($articulos, $usutarcod)
    {
        foreach ($articulos as $articulo) {
            $precioTarifa = $articulo->getPriceForUser($usutarcod);
            $articulo->precioTarifa = $precioTarifa;
            $oferta = $articulo->getPriceWithOffer();

            if ($oferta) {
                if ($oferta['ofctip'] == 'XD') {
                    $descuento = ($precioTarifa * $oferta['ofcimp']) / 100;
                    $articulo->precioOferta = $precioTarifa - $descuento;
                    $articulo->precioDescuento = $oferta['ofcimp'];
                }else{
                    $articulo->precioOferta = $oferta['ofcimp'];
                    $articulo->precioDescuento = null;
                }
            } else {
                $articulo->precioOferta = null;
                $articulo->precioDescuento = null;
            }
        }

        return $articulos;
    }
}
