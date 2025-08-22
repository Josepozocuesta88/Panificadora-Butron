<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Webklex\IMAP\Facades\Client;

use App\Models\Articulo_imagen;
use App\Models\Pedido;
use App\Models\Pedido_linea;
use App\Models\Representante;
use App\Models\User;

class OrderEmailFromAppController extends Controller
{
  public function sendOrderEmailFromApp($pedidoId)
  {
    $pedido = Pedido::where('id', $pedidoId)->first();
    $lineas = Pedido_linea::where('pedido_id', $pedidoId)->get();

    Log::info('lineas: ' . $lineas);

    // Agregar imágenes y cálculos a las líneas del pedido
    foreach ($lineas as $linea) {
      $linea->image = Articulo_imagen::where('imaartcod', $linea->producto_ref)->first()->imanom ?? null;
      $linea->totalIva = $linea->cantidad * $linea->iva;
      $linea->total = $linea->cantidad * $linea->precio + $linea->totalIva + $linea->recargo;
    }

    // $subtotal = $lineas->sum('total');
    $subtotal = $pedido->subtotal;
    $totalIVA = $lineas->sum('totalIva');
    $totalRecargo = $lineas->sum('recargo');
    $total = $pedido->total;

    $user = User::where('usuclicod', $pedido->accclicod)->first();
    $repre = Representante::where('rprcod', $user->usurprcod)->first();
    $email = $user->email;
    $emails_copia = $repre->rprema ?? '';

    // Preparar datos para la vista
    $data = [
      'user' => $user,
      'pedido' => $pedido,
      'lineas' => $lineas,
      'subtotal' => $subtotal,
      'totalIVA' => $totalIVA,
      'totalRecargo' => $totalRecargo,
      'total' => $total,
    ];

    // Enviar correo
    try {
      Mail::send('pages.ecommerce.pedidos.email-orderfromapp', $data, function ($message) use ($email, $emails_copia) {
        $message->to($email)
          ->cc($emails_copia)
          ->subject('Su pedido ya se ha procesado')
          ->from(config('mail.from.address'), config('app.name'));
      });
      Log::info("Correo enviado correctamente al usuario: {$email}");
    } catch (\Exception $e) {
      Log::error("Error al enviar el correo al usuario: {$email}. Detalle: " . $e->getMessage());
    }

    // $this->saveSendEmail($sendEmail->toString());
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
