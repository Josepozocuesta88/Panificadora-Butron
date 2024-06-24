<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Pedido_linea;
use App\Models\Historico;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\FormatoNumeroService;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $fecha = $request->query('fecha');
        
        if ($request->ajax()) {
            $endDate = Carbon::today();
            $startDate = $endDate->copy()->subYear();

            switch ($fecha) {
                case 'mesActual':
                    $startDate = Carbon::now()->subMonth();
                    break;
                case 'ultimoMes':
                    $startDate = Carbon::now()->startOfMonth();
                    break;
                case 'trimestreActual':
                    $startDate = Carbon::now()->startOfQuarter();
                    $endDate = Carbon::now()->endOfQuarter();
                    break;
                case 'ultimoTrimestre':
                    $startDate = Carbon::now()->subQuarter()->startOfQuarter();
                    $endDate = Carbon::now()->subQuarter()->endOfQuarter();
                    break;
                case 'anioActual':
                    $startDate = Carbon::now()->startOfYear();
                    $endDate = Carbon::now()->endOfYear();
                    break;
                case 'utlimoAnio':
                    $startDate = Carbon::now()->subYear()->startOfYear();
                    $endDate = Carbon::now()->subYear()->endOfYear();
                    break;
            }
    
            $data = $this->getData($startDate, $endDate, $fecha);
            $chartPurchasesByMonth = $this->getChart($startDate, $endDate);
            $topSellingItems = $this->getTop10($startDate, $endDate);

            // Log::info('Datos procesados', ['data' => $chartPurchasesByMonth]);
            return response()->json([
                'data' => $data,
                'selectedRange' => '1y',
                'chartPurchasesByMonth' => $chartPurchasesByMonth,
                'topSellingItems' => $topSellingItems,
            ]);
        } else {
           
            return view('pages.dashboard.dashboard');
        }

    }
    

    private function getData($startDate, $endDate)
    {
        $usucod = Auth::user()->usuclicod;

        
        $currentPeriodOrders = Historico::whereBetween('estalbfec', [$startDate, $endDate])
        ->where('estclicod', $usucod)
        ->select(DB::raw('count(DISTINCT estalbnum) as order_count'))
        ->get()
        ->first()
        ->order_count;
        
        $previousPeriodEndDate = $startDate->copy()->subDay(1); 
        $previousPeriodStartDate = $previousPeriodEndDate->copy()->subDays($endDate->diffInDays($startDate));
        
        $previousPeriodOrders = Historico::whereBetween('estalbfec', [$previousPeriodStartDate, $previousPeriodEndDate])
        ->where('estclicod', $usucod)
        ->count();
        
        $purchaseAmount = round(Historico::whereBetween('estalbfec', [$startDate, $endDate])
        ->where('estclicod', $usucod)
        ->sum('estalbimptot'), 2);

        $purchaseAmountFormat = FormatoNumeroService::convertirADecimal($purchaseAmount);


        $accountBalance = Auth::user()->usudocpen;
        $accountBalanceFormat = FormatoNumeroService::convertirADecimal($accountBalance);
        
        return [
            'ordersCount' => $currentPeriodOrders,
            'purchaseAmount' => $purchaseAmountFormat,
            'accountBalance' => $accountBalanceFormat,
        ];
    }

    private function getChart($startDate, $endDate)
    {
        $usucod = Auth::user()->usuclicod;

        $chartPurchasesByMonth = Historico::select(DB::raw('MONTH(estalbfec) as mes'), DB::raw('SUM(estalbimptot) as importe'))
        ->whereBetween('estalbfec', [$startDate, $endDate])
        ->where('estclicod', $usucod)
        ->groupBy('mes')
        ->get();
    
        return $chartPurchasesByMonth;

    }

    private function getTop10($startDate, $endDate){
   
        $user = Auth::user();

        $topSellingItems = $user->historico()
        ->join('qanet_articulo', 'qanet_estadistica.estartcod', '=', 'qanet_articulo.artcod')
        ->select(
            'qanet_articulo.artcod',
            'qanet_articulo.artnom',          
            'qanet_estadistica.estpre', 
            DB::raw('SUM(ROUND(qanet_estadistica.estpre)) as totalVendido'),
            DB::raw('SUM(ROUND(qanet_estadistica.estcan)) as vecesComprado'),
            'qanet_estadistica.estclicod'
        )
        ->groupBy('qanet_estadistica.estclicod', 'qanet_articulo.artcod')
        ->orderByDesc('vecesComprado') 
        ->take(10)
        ->get();
    
        // Log::info('Datos procesados',  ['topSellingItems' => $topSellingItems]);  // Loguear los datos procesados
        // Log::info('SQL Query', ['query' => $topSellingItems->toSql(), 'bindings' => $topSellingItems->getBindings()]);

        return $topSellingItems;

    }

}
