<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Pedido;
use App\Models\Pedido_linea;
use App\Models\Cart;
use App\Models\Caja;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Services\ArticleService;

class CartController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function addToCart(Request $request, $artcod)
    {
        $user = Auth::user();
        $type = $request->input('caja')? $request->input('caja') : "unidades" ;
        $articulo = Articulo::where('artcod', $artcod)->firstOrFail();

        if ($articulo->artstocon >= 1) {
            return redirect()->back()->with('error', 'No hay stock disponible.');
        }

        // Determinar la cantidad basada en si se han seleccionado cajas o unidades.
        if ($type === 'unidades') {
            $quantity_ud = $request->input('cantidad_unidades', 1) ? $request->input('cantidad_unidades', 1) : 1;
            $quantity_box = $request->input('cantidad_cajas', 0);
        }
        else {
            $caja = Caja::where('cajcod', $type)->where('cajartcod', $artcod)->firstOrFail();
            $quantity_box = $request->input('cantidad_cajas', 1);
            if ($caja->cajreldir > 0) {
                $quantity_ud = $request->input('cantidad_cajas', 1) * $caja->cajreldir; // Multiplica por la cantidad de unidades por caja
            }
            else{
                $quantity_ud = $request->input('cantidad_cajas', 1);
        // $request->input('cantidad_cajas', 0)
            }
        }
        // Comprobar si el artículo ya está en el carrito para actualizar la cantidad o añadir uno nuevo
        $cartItem = Cart::where('cartusucod', $user->id)
        ->where('cartartcod', $artcod)
        ->where('cartcajcod', $type)
        ->first();
        if ($cartItem) {
            $cartItem->increment('cartcant', $quantity_ud);
            $cartItem->increment('cartcantcaj', $quantity_box);
        } else {
            $cartItem = Cart::create([
                'cartusucod' => $user->id,
                'cartartcod' => $artcod,
                'cartcant' => $quantity_ud,
                'cartcantcaj' => $quantity_box,
                'cartcajcod' => $type,
            ]);
        }


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
    
        $this->articleService->calculatePrices($articulos, $user->usutarcod, $user->usuofecod);
    
        $itemDetails = $this->calculateItemDetails($items);
    
        if ($itemDetails->isEmpty()) {
            return response()->json(['message' => 'Todos los artículos en el carrito están actualmente no disponibles.'], 200);
        }
    
        return response()->json(['items' => $itemDetails], 200);
    }
    



    public function showCart(Request $request)
    {
        $user = $request->user();
        $items = $this->getItems($user->id);
        if ($items->isEmpty()) {
            return view('sections.cart', ['message' => 'El carrito está vacío.']);
        }
    
        $articulos = $items->pluck('articulo');
    
        $this->articleService->calculatePrices($articulos, $user->usutarcod, $user->usuofecod);
    
        $itemDetails = $this->calculateItemDetails($items);
        
        if ($itemDetails->isEmpty()) {
            return view('sections.cart', ['message' => 'Todos los artículos en el carrito están actualmente no disponibles.']);
        }
    
        // Calcular el subtotal
        $subtotal = $itemDetails->sum('total');
    
        // Determinar los gastos de envío y calcular el total
        $shippingCost = 0.00; // Ejemplo de tarifa fija de envío
        $total = $subtotal + $shippingCost;
        // dd($itemDetails);
        // Pasar los detalles del pedido a la vista
        return view('sections.cart', [
            'items' => $itemDetails,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'total' => $total
        ]);
    }
    
    

    public function removeItem($artcod)
    {
        //  Encuentra el producto en el carrito
        $cartItem = Cart::where('cartartcod', $artcod)->first();
    
        if($cartItem) {
            // Elimina el producto del carrito
            $cartItem->delete();
        }
        // Devuelve una respuesta
        return redirect()->back()->with(['message' => 'Producto eliminado del carrito con éxito.']);
    }
    public function removeCart()
    {
        // Obtiene el usuario actual
        $user = auth()->user();

        // Elimina todos los productos del carrito del usuario
        Cart::where('cartusucod', $user->id)->delete();

        // Devuelve una respuesta
        return redirect()->back()->with(['message' => 'Todos los productos han sido eliminados del carrito con éxito.']);
    }


    public function updateCart(Request $request)
    {
        $cart = Cart::where('cartcod', $request->cartcod)->first();
    
        if ($request->updateType == 'bulto') {
            // Busca la relación de unidades por bulto
            $caja = Caja::where('cajcod', $cart->cartcajcod)->first();
            // Actualiza cartcant basado en cartcantcaj y la relación
            $cart->cartcant = $request->quantity * $caja->cajreldir; // Multiplica cantidad de bultos por la relación
            $cart->cartcantcaj = $request->quantity; // Actualiza la cantidad de bultos
        } elseif ($request->updateType == 'unidades') {
            // Solo actualiza las unidades directamente
            $cart->cartcant = $request->quantity;
        }
    
        $cart->save();
    
        return response()->json(['success' => true]);
    }
    

    function makeOrder(){

        $user = auth()->user();
        $items = $this->getItems($user->id);
    
        if ($items->isEmpty()) {
            return view('sections.cart', ['message' => 'El carrito está vacío.']);
        }

    
        // Obtener todos los artículos en una colección
        $articulos = $items->pluck('articulo');

        // Utilizar el servicio para calcular los precios
        $this->articleService->calculatePrices($articulos, $user->usutarcod, $user->usuofecod);

        // detalles de los items
        $itemDetails = $this->calculateItemDetails($items);

        $data['itemDetails'] = $itemDetails;
        
        if ($itemDetails->isEmpty()) {
            return view('sections.cart', ['message' => 'Todos los artículos en el carrito están actualmente no disponibles.']);
        }
    
        // Calcular el subtotal
        $subtotal = $itemDetails->sum('total');
        $data['subtotal'] = $subtotal;


        // Determinar los gastos de envío (ejemplo con tarifa fija)
        $shippingCost = 0.00; // Tarifa fija de envío

        // Calcular el total
        $total = $subtotal + $shippingCost;
        $data['total'] = $total;


        $email = $user->email;
        $email_copia = config('mail.cc');
        // guardamos los datos en pedidos
        $pedido = new Pedido;
        $pedido->cliente_id = $user->id;
        $pedido->fecha = date('Y-m-d H:i:s');
        $pedido->subtotal = $data['subtotal'];
        $pedido->total = $data['total'];
        $pedido->save();
        // $pedido->gastos_envio = $user->id;
        // guardamos los datos en pedidos_lineas
        // dd($itemDetails);
        
        foreach ($itemDetails as $itemDetail) {
            $pedidoLinea = new Pedido_linea;

            $pedidoLinea->pedido_id = $pedido->id;
            $pedidoLinea->producto_ref = $itemDetail['artcod'];
            $pedidoLinea->cantidad = $itemDetail['cantidad_unidades'];
            $pedidoLinea->precio = $itemDetail['price'];
            if($itemDetail['cartcajcod']){
                $pedidoLinea->aclcancaj = $itemDetail['cantidad_cajas'];
                $pedidoLinea->aclcajcod = $itemDetail['cartcajcod'] == "unidades" ? "" : $itemDetail['cartcajcod'];
            }

            $pedidoLinea->save();
        }
        try {
            Mail::send('sections.email-order', $data, function ($message) use ($data, $email, $email_copia) {
                $message->to($email)
                        ->cc($email_copia)
                        ->subject('Su pedido ya se ha procesado')
                        ->from(config('mail.from.address'), config('app.name'));
            });
        } catch (\Exception $e) {
            Log::error("Error al enviar correo: " . $e->getMessage());
            return back()->with('error', 'Su pedido se no se procesó correctamente, intentelo más tarde.');
        }

         // Elimina todos los productos del carrito del usuario
         Cart::where('cartusucod', $user->id)->delete();

        return back()->with('success', '¡Su pedido se procesó correctamente!');
    } 





    // privadas
    private function getItems($userId) {
        return Cart::where('cartusucod', $userId)
                   ->selectRaw('cartcod, cartartcod, cartcant, cartcantcaj, cartcajcod, qanet_caja.cajnom, qanet_caja.cajreldir, qanet_caja.cajtip')
                   ->groupBy('cartartcod', 'cartcajcod')
                   ->leftJoin('qanet_caja', function($join) {
                    $join->on('qanet_caja.cajcod', '=', 'cart.cartcajcod')
                         ->on('qanet_caja.cajartcod', '=', 'cart.cartartcod');
                })
                   ->orderby('cartcod', 'desc')
                   ->with('articulo')
                   ->get();
    }

    private function calculateItemDetails($items){
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

                $isBox = $item->cartcajcod !== 'unidades';
                $unitCount = $isBox ? $item->cajreldir : 1;
                $totalUnits = $isBox ? $item->cartcantcaj * $unitCount : $item->cartcant;
                $cajtip = $item->cajtip == 'C'? 'Caja' : ($item->cajtip == 'M' ? 'Media' : 'Pieza');
                $name = $isBox ? $item->cajnom : $item->articulo->artnom;
                $pricePerUnit = round($price * $unitCount, 2);
                $total = round($pricePerUnit * ($isBox ? $item->cartcantcaj : $item->cartcant), 2);
                return [
                    'cartcod' => $item->cartcod,
                    'artcod' => $item->cartartcod,
                    'cajcod' => $item->cajcod,
                    'cajtip' => $cajtip,
                    'cartcajcod' => $item->cartcajcod,
                    'name' => $name,
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
    
}