<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Models\Articulo;
use App\Models\Historico;
use App\Models\User;
use App\Models\HistoricoAgrupado;

use Carbon\Carbon;

class HistoryController extends Controller
{
    public function getHistory(Request $request)
    {

        if ($request->ajax()) {
          
            $user = Auth::user();


            $data = $user->historico() 
                ->join('qanet_articulo', 'qanet_estadistica.estartcod', '=', 'qanet_articulo.artcod') 
                ->join('qarticulo_imagen', 'qanet_articulo.artcod', '=', 'qarticulo_imagen.imaartcod')
                ->orderby('estalbfec', 'desc') 
                ->get([
                    'qanet_articulo.artcod', 
                    'qanet_articulo.artnom', 
                    'qarticulo_imagen.imanom', 
                    'qanet_estadistica.estalbfec', 
                    'qanet_estadistica.estpre', 
                    'qanet_estadistica.estcan' 
                ]);
            return response()->json(['data' => $data]);
        
        }
        return view('sections.history');

    }



    public function getHistoryGroup(Request $request)
    {
        if ($request->ajax()) {
          
            $user = Auth::user();

            $data = $user->historico()
            ->join('qanet_articulo', 'qanet_estadistica.estartcod', '=', 'qanet_articulo.artcod')
            ->leftJoin('qarticulo_imagen', 'qanet_articulo.artcod', '=', 'qarticulo_imagen.imaartcod')
            ->select(
                'qanet_articulo.artcod',
                'qanet_articulo.artnom',          
                'qarticulo_imagen.imanom',
                'qanet_estadistica.estalbfec',
                'qanet_estadistica.estpre', 
                DB::raw('SUM(ROUND(qanet_estadistica.estcan)) as estcan'),
                'qanet_estadistica.estclicod'
            )
            ->groupBy('qanet_estadistica.estclicod', 'qanet_articulo.artcod')
            ->orderby('estalbfec', 'desc') 
            ->get();

            return response()->json(['data' => $data]);
        
        }
        return view('sections.history');
    }
}