<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Webklex\IMAP\Facades\Client;

class SupportController extends Controller
{
    public function reportarError(Request $request)
    {
        $data = $request->validate([
            'pasos' => 'required',
            'error' => 'required',
            'ubicacion' => 'required',
        ]);

        $sendEmail = Mail::send('pages.cuenta.support.email-report', $data, function ($message) use ($data) {
            $message->to('marialuisa@redesycomponentes.com')
                ->subject('Reporte de Error')
                ->from('marialuisa@redesycomponentes.com', config('app.name'));
        });

        $this->saveSendEmail($sendEmail->toString());

        return back()->with('success', '¡Reporte de error enviado con éxito!');
    }

    public function contactoEmail(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'email' => 'required',
            'asunto' => 'required',
            'mensaje' => 'required',
        ]);


        try {
            $sendEmail = Mail::send('contacto.email', $data, function ($message) use ($data) {
                $message->to($data['email'])
                    ->subject($data['asunto'])
                    ->from('marialuisa@redesycomponentes.com', config('app.name'));
            });

            $this->saveSendEmail($sendEmail->toString());
        } catch (\Exception $e) {
            Log::error("Error al enviar correo: " . $e->getMessage());
            return back()->with('error', 'Su mensaje no se ha podido enviar en estos momentos, intentelo más tarde.');
        }

        return back()->with('success', '¡Su mensaje se ha enviado con éxito!');
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
