<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Webklex\IMAP\Facades\Client;

use App\Services\ArticleService;
use App\Models\Articulo;
use App\Models\Caja;
use App\Models\Cart;
use App\Models\Pedido;
use App\Models\Pedido_linea;
use App\Models\Representante;

use Carbon\Carbon;

class CartController extends Controller
{
  protected $articleService;

  public function __construct(ArticleService $articleService)
  {
    $this->articleService = $articleService;
  }

  public function addToCart(Request $request, $artcod)
  {
    // stock
    $articulo = Articulo::where('artcod', $artcod)->firstOrFail();
    if ($articulo->artstocon < 1 && $articulo->artstock < 1) {
      return redirect()->back()->with('error', 'No hay stock disponible.');
    }

    // determina la cantidad basada en si se han seleccionado cajas o unidades
    $type = $request->input('input-tipo');
    $quantity = $request->input('quantity', 1);

    list($quantity_ud, $quantity_box) = Caja::quantityByType($artcod, $type, $quantity);

    // comprueba si el artículo ya está en el carrito para actualizar la cantidad o añadir uno nuevo
    Cart::updateOrAddItem($artcod, $type, $quantity_ud, $quantity_box);

    return redirect()->back()->with('success', 'Producto añadido al carrito con éxito');
  }

  public function showModalCart(Request $request)
  {
    $user = $request->user();
    $items = $this->getItems($user->id);

    if ($items->isEmpty()) {
      return response()->json(['message' => 'El carrito está vacío.'], 200);
    }

    $articulos = $items->pluck('articulo');
    $this->articleService->calculatePrices($articulos, $user->usutarcod);

    $itemDetails = $this->calculateItemDetails($items);

    if ($itemDetails->isEmpty()) {
      return response()->json(['message' => 'Los artículos en el carrito no están disponibles actualmente.'], 200);
    }

    return response()->json(['items' => $itemDetails], 200);
  }

  public function selectTipo($artcod)
  {
    $articulo = Articulo::with('cajas')->find($artcod);

    if (!$articulo) {
      return response()->json(['error' => 'Artículo no encontrado'], 404);
    }

    $cajas = $articulo->cajas;
    return response()->json(['cajas' => $cajas], 200);
  }

  public function changeSelect(Request $request, $cartcod, $cartcant, $selectedValue)
  {
    $user = Auth::user();
    $cart = Cart::where('cartcod', $cartcod)->first();

    if (!$cart) {
      return response()->json(['error' => 'Artículo no encontrado'], 404);
    }

    $existingCart = Cart::where('cartartcod', $cart->cartartcod)
      ->where('cartcajcod', $selectedValue)
      ->first();

    list($quantity_ud, $quantity_box) = Caja::quantityByType($cart->cartartcod, $selectedValue, $cartcant);
    if ($existingCart) {
      // Log::info('Datos procesados', ['existingCart' => $existingCart]);
      $existingCart->cartcant += $quantity_ud;
      $existingCart->cartcantcaj += $quantity_box;
      $existingCart->save();
      $cart->delete();
    } else {
      $cart->cartcajcod = $selectedValue;
      $cart->cartcantcaj = $quantity_box;
      $cart->cartcant = $quantity_ud;
      $cart->save();
    }

    return response()->json(['success' => true]);
  }

  public function showCart(Request $request)
  {
    $user     = $request->user();
    $items    = $this->getItems($user->id);

    if ($items->isEmpty()) {
      return view('pages.ecommerce.carrito.cart', ['message' => 'El carrito está vacío.']);
    }

    // descuento de primeras compras
    // $descuento = $this->discountForClient($user->id)->getData();

    $articulos = $items->pluck('articulo');

    $this->articleService->calculatePrices($articulos, $user->usutarcod);

    $itemDetails = $this->calculateItemDetails($items);

    if ($itemDetails->isEmpty()) {
      return view('pages.ecommerce.carrito.cart', ['message' => 'Todos los artículos en el carrito no están disponibles.']);
    }

    // descuento de primeras compras
    // if (!$descuento->result) {
    //   $subtotal = $itemDetails->sum('total');
    //   $descuento_aplicado = $subtotal * 0.05;
    //   $subtotal -= $descuento_aplicado;
    // } else {
    //   $subtotal     = $itemDetails->sum('total');
    // }

    $subtotal     = $itemDetails->sum('total');

    $shippingCost = 0.00;
    $total        = $subtotal + $shippingCost;

    Log::info('Datos procesados', ['existingCart' => $items->pluck('articulo.artivapor')->toArray()]);

    $artivapor = $itemDetails->sum('artivapor');
    $artrecpor = $itemDetails->sum('artrecpor');
    $artsigimp = $itemDetails->sum('artsigimp');

    Log::info('recargo: ' . $artrecpor);

    $total    = $subtotal + $shippingCost + $artivapor + $artrecpor + $artsigimp;

    Log::info('usudes: ' . $user->usudes1);
    Log::info('total usudes es 0 = ' . $subtotal . '+' . $shippingCost . '+' . $artivapor . '+' . $artrecpor . '+' . $artsigimp);

    if ($user->usudes1 != 0) {
      $descuento      = $subtotal * ($user->usudes1 / 100);
      $nuevo_subtotal = $subtotal - $descuento;
      $artivapor      = $nuevo_subtotal * ($itemDetails->avg('ivaPorcentaje') / 100);
      $total          = $nuevo_subtotal + $shippingCost + $artivapor + $artrecpor + $artsigimp;

      Log::info('total usudes != 0 = ' . $subtotal . '+' . $shippingCost . '+' . $artivapor . '+' . $artrecpor . '+' . $artsigimp);
    }

    return view('pages.ecommerce.carrito.cart', [
      'user'          => $user,
      'items'         => $itemDetails,
      'subtotal'      => $subtotal,
      'shippingCost'  => $shippingCost,
      'artivapor'     => $artivapor,
      'artrecpor'     => $artrecpor,
      'artsigimp'     => $artsigimp,
      'total'         => $total,
      'direcciones'   => $user->direcciones,
      // 'descuento'     => $descuento,
    ]);
  }

  public function removeItem($artcod)
  {
    $cartItem = Cart::where('cartartcod', $artcod)->first();

    if ($cartItem) {
      $cartItem->delete();
    }

    return redirect()->back()->with(['message' => 'Producto eliminado del carrito con éxito.']);
  }

  public function removeCart()
  {
    $user = auth()->user();
    Cart::where('cartusucod', $user->id)->delete();

    return redirect()->back()->with(['message' => 'Todos los productos han sido eliminados del carrito con éxito.']);
  }

  public function updateCart(Request $request, $cartcod)
  {
    try {
      $cart = Cart::where('cartcod', $cartcod)->first();

      if (!$cart) {
        return response()->json(['error' => 'Carrito no funciona correctamente, intentelo más tarde.'], 404);
      }

      list($quantity_ud, $quantity_box) = Caja::quantityByType($cart->cartartcod, $request->type, $request->box_quantity);
      $cart->cartcantcaj = $quantity_box;
      $cart->cartcant = $quantity_ud;
      $cart->cartcajcod = $request->type;
      $cart->save();

      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      Log::error('Update cart failed: ' . $e->getMessage());
      return response()->json(['error' => 'Server error'], 500);
    }
  }

  public function makeOrder()
  {
    Log::info('makeOrder');

    $user   = auth()->user();
    $items  = $this->getItems($user->id);

    if ($items->isEmpty()) {
      return view('pages.ecommerce.carrito.cart', ['message' => 'El carrito está vacío.']);
    }

    $articulos            = $items->pluck('articulo');

    $this->articleService->calculatePrices($articulos, $user->usutarcod);

    $itemDetails          = $this->calculateItemDetails($items);
    $data['itemDetails']  = $itemDetails;

    if ($itemDetails->isEmpty()) {
      return view('pages.ecommerce.carrito.cart', ['message' => 'Todos los artículos en el carrito no están disponibles.']);
    }

    $subtotal       = $itemDetails->sum('total');
    $descuento      = 0.00;
    $shippingCost   = 0.00;
    $artivapor      = $itemDetails->sum('artivapor');
    $artrecpor      = $itemDetails->sum('artrecpor');
    $artsigimp      = $itemDetails->sum('artsigimp');
    $iva_porcentaje = $itemDetails->sum('ivaPorcentaje');

    if (Auth::user()->usudes1 != 0) {
      $descuento      = $subtotal * (Auth::user()->usudes1 / 100);
      $subtotal       = $subtotal - $descuento;
      $artivapor      = $subtotal * ($itemDetails->avg('ivaPorcentaje') / 100);
      $iva_porcentaje = $itemDetails->sum('ivaPorcentaje');
      $total          = $subtotal +  $artivapor +  $artrecpor + $artsigimp; //artrecpor no se suma!! -> MIRAR ESTO
    } else {
      $total          = $subtotal + $artivapor + $artrecpor + $artsigimp;
    }

    $email        = $user->email;
    $repre        = Representante::where('rprcod', $user->usurprcod)->first();
    $email_copia  = $repre->rprema ?? '';

    $pedido                       = new Pedido;
    $pedido->cliente_id           = $user->id;
    $pedido->accclicod            = $user->usuclicod;
    $pedido->acccencod            = $user->usucencod;
    $pedido->estado               = 2;
    $pedido->fecha                = date('Y-m-d H:i:s');
    $pedido->subtotal             = $subtotal;
    $pedido->descuento            = $descuento;
    $pedido->descuento_porcentaje = Auth::user()->usudes1;
    $pedido->gasto_envio          = $shippingCost;
    $pedido->total                = $total;
    $pedido->iva_porcentaje       = $iva_porcentaje;
    $pedido->iva_importe          = $artivapor;
    $pedido->save();

    foreach ($itemDetails as $itemDetail) {
      $pedidoLinea                = new Pedido_linea;
      $pedidoLinea->pedido_id     = $pedido->id;
      $pedidoLinea->producto_ref  = $itemDetail['artcod'];
      $pedidoLinea->cantidad      = $itemDetail['cantidad_unidades'];
      $pedidoLinea->precio        = $itemDetail['price'];

      if ($itemDetail['cartcajcod']) {
        $pedidoLinea->aclcancaj = $itemDetail['cantidad_cajas'];
        $pedidoLinea->aclcajcod = $itemDetail['cartcajcod'] == "unidades" ? "" : $itemDetail['cartcajcod'];
      }

      $pedidoLinea->save();
    }

    $data['usuario'] = Auth::user();

    try {
      $sendEmail = Mail::send('pages.ecommerce.pedidos.email-order', $data, function ($message) use ($data, $email, $email_copia) {
        $message->to($email)
          ->cc($email_copia)
          ->subject('Su pedido ya se ha procesado')
          ->from(config('mail.from.address'), config('app.name'));
      });

      $this->saveSendEmail($sendEmail->toString());
    } catch (\Exception $e) {
      Log::error("Error al enviar correo: " . $e->getMessage());

      return back()->with('error', 'Su pedido no se procesó correctamente, intentelo más tarde.');
    }

    Cart::where('cartusucod', $user->id)->delete();

    return back()->with('success', '¡Su pedido se procesó correctamente!');
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
        $iva_porcentaje = $item->articulo->artivapor;
        // Auth::user()->usuivacod === "R" ? $artrecpor = $total * ($item->articulo->artrecpor / 100) : $artrecpor = 0;
        Auth::user()->usuivacod !== "N" && Auth::user()->usuivacod !== "E" && Auth::user()->usuivacod !== "O"  ? $artrecpor = $total * ($item->articulo->artrecpor / 100) : $artrecpor = 0;
        $artsigimp = $total * ($item->articulo->artsigimp / 100);
        // Log::info('recargo desde calculateItemDetails: ' . $item->articulo->artrecpor);

        return [
          'ivaPorcentaje' => $iva_porcentaje,
          'cartcod' => $item->cartcod,
          'artcod' => $item->cartartcod,
          'cajcod' => $item->cajcod,
          'cartcajcod' => $item->cartcajcod,
          'name' => $name,
          'artivapor' => $artivapor,
          'artrecpor' => $artrecpor,
          'artsigimp' => $artsigimp,
          'promedcod' => $item->articulo->promedcod,
          'image' => $img,
          'cantidad_unidades' => $item->cartcant,
          'cantidad_cajas' => $item->cartcantcaj,
          'isOnOffer' => $isOnOffer,
          'price' => $price,
          'tarifa' => $tarifa,
          'total' => $total
        ];
      }
    })->filter();
  }

  private function discountForClient($clienteId)
  {
    // Obtener el primer pedido del cliente
    $primerPedido = Pedido::where('cliente_id', $clienteId)
      ->orderBy('fecha', 'asc')
      ->first();

    // Si no tiene pedidos, no califica
    if (!$primerPedido) {
      return response()->json([
        'result' => false,
        'message' => 'El cliente aún no tiene pedidos.'
      ]);
    }

    // Calcular la ventana de 2 meses a partir del primer pedido
    $fechaInicio = $primerPedido->fecha;
    $fechaFin = Carbon::parse($fechaInicio)->addMonths(2)->endOfDay();

    // Obtener todos los pedidos dentro de esa ventana
    $pedidosEnRango = Pedido::where('cliente_id', $clienteId)
      ->whereBetween('fecha', [$fechaInicio, $fechaFin])
      ->orderBy('fecha', 'asc')
      ->get();

    if ($pedidosEnRango->count() >= 3) {
      return response()->json([
        'result' => true,
        'message' => 'El cliente completó 3 pedidos en los 2 meses desde su primer pedido.'
      ]);
    }

    return response()->json([
      'result' => false,
      'message' => 'El cliente aún no ha completado los 3 pedidos en el plazo de 2 meses.'
    ]);
  }

  public function saveSendEmail($mimeMessage)
  {
    try {
      $client = Client::account('default');
      $client->connect();

      $folder = $client->getFolderByName('Sent');
      $folder->appendMessage($mimeMessage);
    } catch (\Exception $e) {
      // \Log::error('Error al guardar el correo en Enviados: ' . $e->getMessage());
    }
  }
}
