<?php

namespace App\Services;

class FormatoNumeroService
{
    public static function convertirADecimal($num)
    {
        if ($num == "") {
            return "";
        } else {
            return number_format($num, 2, ",", ".");
        }
    }
}
