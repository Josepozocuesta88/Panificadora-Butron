<?php

namespace App\Http\Controllers;

use App\Models\Articulo_imagen;
use App\Models\Pedido;
use App\Models\Pedido_linea;
use App\Models\Representante;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Email; // 👈 importante
use Webklex\IMAP\Facades\Client;

class OrderEmailFromAppController extends Controller
{
  public function sendOrderEmailFromApp($pedidoId)
  {
    $pedido = Pedido::where('id', $pedidoId)->first();
    $lineas = Pedido_linea::where('pedido_id', $pedidoId)->get();

    // Agregar imágenes y cálculos
    foreach ($lineas as $linea) {
      $linea->image = Articulo_imagen::where('imaartcod', $linea->producto_ref)->first()->imanom ?? null;
      $linea->totalIva = $linea->cantidad * $linea->iva;
      $linea->total = $linea->cantidad * $linea->precio + $linea->totalIva + $linea->recargo;
    }

    $subtotal      = $pedido->subtotal;
    $totalIVA      = $lineas->sum('totalIva');
    $totalRecargo  = $lineas->sum('recargo');
    $total         = $pedido->total;

    $user  = User::where('usuclicod', $pedido->accclicod)->first();
    $repre = Representante::where('rprcod', $user->usurprcod)->first();
    $email = $user->email;

    // Corrección de $emails_copia
    if ($user->usuWebPedRpr == 1) {
      $emails_copia = [$repre->rprema];
    } else {
      $emails_copia = [$repre->rprema, config('mail.cc')];
    }

    $data = [
      'user'         => $user,
      'pedido'       => $pedido,
      'lineas'       => $lineas,
      'subtotal'     => $subtotal,
      'totalIVA'     => $totalIVA,
      'totalRecargo' => $totalRecargo,
      'total'        => $total,
    ];

    try {
      $mimeMessage = null;

      Mail::send('pages.ecommerce.pedidos.email-orderfromapp', $data, function ($message) use ($email, $emails_copia, &$mimeMessage) {
        $message->to($email)
          ->cc(array_merge(['web.jorge@redesycomponentes.com'], $emails_copia))
          ->subject('Su pedido ya se ha procesado')
          ->from(config('mail.from.address'), config('app.name'));

        // Obtener mensaje Symfony para guardarlo en IMAP
        $symfonyMessage = $message->getSymfonyMessage();
        if ($symfonyMessage instanceof Email) {
          $mimeMessage = $symfonyMessage->toString();
        }
      });

      Log::info('Correo enviado', ['destinatario' => $email, 'estado' => 'enviado']);

      // Guardar en carpeta Enviados
      if (!empty($mimeMessage)) {
        $this->saveSendEmail($mimeMessage);
      }
    } catch (\Exception $e) {
      Log::error('Error al enviar correo', [
        'destinatario' => $email,
        'estado'       => 'fallido',
        'error'        => $e->getMessage()
      ]);
    }
  }

  public function saveSendEmail($mimeMessage)
  {
    try {
      $client = Client::account('default');
      $client->connect();

      // carpeta "Sent" (depende del servidor, a veces "Enviados" o "INBOX.Sent")
      $folder = $client->getFolderByName('Sent');
      $folder->appendMessage($mimeMessage);

      Log::info("Correo guardado en Sent correctamente.");
    } catch (\Exception $e) {
      Log::error('Error al guardar el correo en Enviados: ' . $e->getMessage());
    }
  }
}
