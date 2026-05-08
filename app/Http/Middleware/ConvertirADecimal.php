<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertirADecimal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Lista de campos a convertir
        $camposParaConvertir = ['campo1', 'campo2', 'campo3'];

        foreach ($camposParaConvertir as $campo) {
            if ($request->has($campo)) {
                $request->merge([$campo => $this->convertirADecimal($request->input($campo))]);
            }
        }

        return $next($request);
    }

    private function convertirADecimal($num)
    {
        if ($num == "") {
            return "";
        } else {
            return number_format($num, 2, ",", ".");
        }
    }
}
