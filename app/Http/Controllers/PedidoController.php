<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Models\Pedido;
use App\Models\Pedido_linea;
use App\Models\Cart;
use App\Models\ClienteDireccion;
use App\Models\Representante;


use App\Services\ArticleService;

class PedidoController extends Controller
{
    //
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function makeOrder(Request $request)
    {
        try {
            $data = $request->all();
            $direccionId = $data['direccionId'];
            $comentario = $data['comentario'];
            $user = auth()->user();
            $direccion = ClienteDireccion::where([['dirid', $direccionId], ['dirclicod', $user->usuclicod]])->first();
            if (!$direccion) {
                return back()->with('error', 'La dirección seleccionada no existe');
            }
            $items = $this->getItems($user->id);
            $articulos = $items->pluck('articulo');
            $this->articleService->calculatePrices($articulos, $user->usutarcod);
            $itemDetails = $this->calculateItemDetails($items);
            $itemDetails = $this->addTaxes($itemDetails, $articulos);
            $data = $this->prepareOrderData($user, $itemDetails, $comentario);
            $pedido = $this->createPedido($data, $user, $direccion);
            $data['pedido'] = $pedido;
            $this->sendOrderEmail($data, $user);
            Cart::where('cartusucod', $user->id)->delete();

            return ['message' => '¡Su pedido se procesó correctamente!', 'data' => $pedido];
        } catch (\Throwable $th) {

            // return ['message' => 'Error al procesar el pedido', 'error' => $th->getMessage()];
        }
    }

    public function orderResult($result)
    {
        if ($result == 'ok') {
            return back()->with('success', '¡Su pedido se procesó correctamente!');
        }

        return back()->with('Error', '¡Hubo un error al procesar su pedido!');
    }

    private function addTaxes($itemDetails, $articulos)
    {
        $newItems = $itemDetails->toArray();
        for ($i = 0; $i < count($newItems); $i++) {
            $articulo = $articulos->firstWhere('artcod', $newItems[$i]['artcod']);
            $newItems[$i]['iva'] = $articulo->precioTarifa * $articulo->artivapor / 100;
            $newItems[$i]['iva_porcentaje'] = $articulo->artivapor;
            $newItems[$i]['recargo'] = $articulo->precioTarifa * $articulo->artrecpor / 100;
            $newItems[$i]['recargo_porcentaje'] = $articulo->artrecpor;
            if (Auth::user()->usuivacod == 'N') {
                $newItems[$i]['recargo'] = 0;
                $newItems[$i]['recargo_porcentaje'] = 0;
            }
        }

        return collect($newItems);
    }


    public function makeOrderOld()
    {
        $user = auth()->user();
        $items = $this->getItems($user->id);
        $articulos = $items->pluck('articulo');
        $this->articleService->calculatePrices($articulos, $user->usutarcod);
        $itemDetails = $this->calculateItemDetails($items);
        $data = $this->prepareOrderData($user, $itemDetails);
        $pedido = $this->createPedido($data, $user);
        $this->sendOrderEmail($data, $user);
        Cart::where('cartusucod', $user->id)->delete();
        session()->forget('comentario');

        return back()->with('success', '¡Su pedido se procesó correctamente!');
    }

    public function mostrarPedido($id = null)
    {
        $user = Auth::user();
        $userId = $user->id;
        if (is_null($id)) {
            $pedido = Pedido::where('cliente_id', $userId)->latest('fecha')->first();
        } else {
            $pedido = Pedido::findOrFail($id);
        }
        if (is_null($pedido)) {
            return view('pages.ecommerce.pedidos.estado', ['message' => "Aún no tiene ningún pedido realizado"]);
        }
        $items = Pedido_linea::where('pedido_id', $pedido->id)->get();

        return view('pages.ecommerce.pedidos.estado', ['pedido' => $pedido, 'items' => $items, 'user' => $user]);
    }

    public function mostrarTodos()
    {
        $userId = Auth::id();
        $pedidos = Pedido::where('cliente_id', $userId)->get();
        if ($pedidos->isEmpty()) {
            return response()->json(['message' => 'Actualmente no tiene ningún pedido.'], 200);
        }

        return response()->json(['data' => $pedidos], 200);
    }

    private function createPedido($data, $user, $direccion = null)
    {
        $pedido = new Pedido;
        $pedido->cliente_id = $user->id;
        $pedido->accclicod = $user->usuclicod;
        $pedido->acccencod = $user->usucencod;
        $pedido->observaciones = $data['comentario'];
        $pedido->estado = 2;
        $pedido->fecha = date('Y-m-d H:i:s');
        $pedido->subtotal = $data['subtotal'];
        $pedido->descuento = $data['descuento'];
        $pedido->descuento_porcentaje = $data['descuento_porcentaje'];
        $pedido->gastos_envio = $data['gastos_envio'];
        $pedido->total = $data['total'];
        if ($direccion) {
            $pedido->env_nombre = $direccion->dirnom;
            $pedido->env_apellidos = $direccion->dirape;
            $pedido->env_pais_txt = $direccion->dirpai;
            $pedido->env_direccion = $direccion->dirdir;
            $pedido->env_poblacion = $direccion->dirpob;
            $pedido->env_cp = $direccion->dircp;
            $pedido->env_tfno_1 = $direccion->dirtfno1;
            $pedido->env_tfno_2 = $direccion->dirtfno2;
        }
        $pedido->save();
        foreach ($data['itemDetails'] as $itemDetail) {
            $this->createPedidoLinea($pedido, $itemDetail);
        }

        return $pedido;
    }

    private function createPedidoLinea($pedido, $itemDetail)
    {
        $pedidoLinea = new Pedido_linea;
        $pedidoLinea->pedido_id = $pedido->id;
        $pedidoLinea->producto_ref = $itemDetail['artcod'];
        $pedidoLinea->nombre_articulo = $itemDetail['name'];
        $pedidoLinea->cantidad = $itemDetail['cantidad_unidades'];
        $pedidoLinea->precio = $itemDetail['price'];
        if ($itemDetail['cartcajcod']) {
            $pedidoLinea->aclcancaj = $itemDetail['cantidad_cajas'];
            $pedidoLinea->aclcajcod = $itemDetail['cartcajcod'] == "unidades" ? "" : $itemDetail['cartcajcod'];
        }
        $pedidoLinea->iva = $itemDetail['iva'];
        $pedidoLinea->iva_porcentaje = $itemDetail['iva_porcentaje'];
        $pedidoLinea->recargo = $itemDetail['recargo'];
        $pedidoLinea->recargo_porcentaje = $itemDetail['recargo_porcentaje'];
        $pedidoLinea->save();
    }

    private function sendOrderEmail($data, $user)
    {
        $email = $user->email;
        $email_empresa = config('mail.cc');
        $representante = $user ? Representante::where('rprcod', $user->usurprcod)->first() : "";
        if ($representante !== null && isset($representante->rprema)) {
            $email_copia_rpr = $representante->rprema;
        } else {
            // para prueba (modificar)
            $email_copia_rpr = "Web.Jorge@redesycomponentes.com";
        }
        $emails_copia = array($email_empresa, $email_copia_rpr);

        Mail::send('pages.ecommerce.pedidos.email-order', $data, function ($message) use ($data, $email, $emails_copia) {
            $message->to($email)
                ->cc($emails_copia)
                ->subject('Su pedido ya se ha procesado')
                ->from(config('mail.from.address'), config('app.name'));
        });
    }

    public function guardarComentario(Request $request)
    {
        $request->session()->put('comentario', $request->comentario);

        return response()->json(['message' => 'Comentario guardado en la sesión']);
    }

    private function getItems($userId)
    {
        return Cart::where('cartusucod', $userId)
            ->selectRaw('cartcod, cartartcod, cartcant, cartcantcaj, cajcod, cartcajcod, qanet_caja.cajnom, qanet_caja.cajreldir')
            ->groupBy('cartartcod', 'cartcajcod')
            ->leftJoin('qanet_caja', function ($join) {
                $join->on('qanet_caja.cajcod', '=', 'cart.cartcajcod')
                    ->on('qanet_caja.cajartcod', '=', 'cart.cartartcod');
            })
            ->orderby('cartcod', 'desc')
            ->with('articulo')
            ->get();
    }

    private function calculateItemDetails($items)
    {
        return $items->map(function ($item) {
            if ($item->articulo) {
                $name = $item->articulo->artnom;
                $img = $item->articulo->primeraImagen();
                $tarifa = $item->articulo->precioTarifa;
                $price = $item->articulo->precioOferta ?? $tarifa;
                if ($tarifa === null) {
                    return ['name' => $name, 'price' => 'Precio no disponible'];
                }
                $isOnOffer = $tarifa != $price;
                $isBox = in_array($item->cartcajcod, ['0001', '0002', '0003']);
                $unitCount = $isBox ? $item->cajreldir : 1;
                $totalUnits = $isBox ? $item->cartcantcaj * $unitCount : $item->cartcant;
                if ($isBox) {
                    $name = $item->cajnom;
                }
                $total = round($price * $totalUnits, 2);
                $artivapor = $total * ($item->articulo->artivapor / 100);
                $artrecpor = $total * ($item->articulo->artrecpor / 100);
                $artsigimp = $total * ($item->articulo->artsigimp / 100);

                return [
                    'cartcod' => $item->cartcod,
                    'artcod' => $item->cartartcod,
                    'cajcod' => $item->cajcod,
                    'cartcajcod' => $item->cartcajcod,
                    'name' => $name,
                    'promedcod' => $item->articulo->promedcod,
                    'image' => $img,
                    'cantidad_unidades' => $item->cartcant,
                    'cantidad_cajas' => $item->cartcantcaj,
                    'isOnOffer' => $isOnOffer,
                    'price' => $price,
                    'tarifa' => $tarifa,
                    'artivapor' => $artivapor,
                    'artrecpor' => $artrecpor,
                    'artsigimp' => $artsigimp,
                    'total' => $total
                ];
            }
        })->filter();
    }

    private function prepareOrderData($user, $itemDetails, $comentario = "")
    {
        $data['itemDetails'] = $itemDetails;
        $subtotal = $itemDetails->sum('total');
        $data['subtotal'] = $subtotal;
        $artivapor = $itemDetails->sum('artivapor');
        $artrecpor = $itemDetails->sum('artrecpor');
        $user->usudes1 == 0 ? $data['descuento'] = $user->usudes1 : $data['descuento'] = $subtotal * ($user->usudes1 / 100);
        $data['descuento_porcentaje'] = $user->usudes1 . '%';
        $shippingCost = 0.00;
        $data['gastos_envio'] = $shippingCost;
        $data['comentario'] = $comentario;
        if ($user->usudes1 != 0) {
            $descuento = $subtotal * ($user->usudes1 / 100);
            $nuevo_subtotal = $subtotal - $descuento;
            $total = $nuevo_subtotal + $shippingCost + $artivapor + $artrecpor;
            $data['total'] = $total;
        } else {
            $total = $subtotal + $shippingCost + $artivapor + $artrecpor;
            $data['total'] = $total;
        }
        $data['usuario'] = $user;

        return $data;
    }
}
