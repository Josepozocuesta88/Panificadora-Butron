<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function reportarError(Request $request)
    {
        $data = $request->validate([
            'pasos' => 'required',
            'error' => 'required',
            'ubicacion' => 'required',
        ]);

        Mail::send('pages.cuenta.support.email-report', $data, function ($message) use ($data) {
            $message->to('marialuisa@redesycomponentes.com')
                    ->subject('Reporte de Error')
                    ->from('marialuisa@redesycomponentes.com', config('app.name'));
        });

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
            Mail::send('contacto.email', $data, function ($message) use ($data) {
                $message->to($data['email'])
                        ->subject($data['asunto'])
                        ->from('marialuisa@redesycomponentes.com', config('app.name'));
            });
        } catch (\Exception $e) {
            Log::error("Error al enviar correo: " . $e->getMessage());
            return back()->with('error', 'Su mensaje no se ha podido enviar en estos momentos, intentelo más tarde.');
        }

        return back()->with('success', '¡Su mensaje se ha enviado con éxito!');
    }
}

