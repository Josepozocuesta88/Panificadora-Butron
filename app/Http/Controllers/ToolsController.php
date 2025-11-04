<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

use Webklex\IMAP\Facades\Client;

use App\Jobs\SendPresupuestoJob;
use App\Jobs\SendFacturaJob;

use App\Mail\PresupuestoMail;
use App\Mail\FacturaMail;

use App\Models\User;
use App\Models\AccessToken;
use App\Models\Documento;
use App\Models\DocumentoFichero;
use App\Models\Pedido;

class ToolsController extends Controller
{
    public function index()
    {
        // === DOCUMENTOS (Presupuestos y Facturas) ===

        // Presupuestos de documentos
        $budgetDocuments = Documento::where('doctip', 'PC')
            ->with(['usuario', 'ficheroIndividual'])
            ->get();

        $budgetDocumentStats = [
            'total' => $budgetDocuments->count(),
            'pendientes' => $budgetDocuments->where('docenviado', 0)->count(),
            'enviados' => $budgetDocuments->where('docenviado', 1)->count(),
            'aceptados' => $budgetDocuments->where('docestado', 'C')->count(),
            'rechazados' => $budgetDocuments->where('docestado', 'R')->count(),
            'finalizados' => $budgetDocuments->where('docestado', 'F')->count(),
            'list' => $budgetDocuments
        ];

        // Facturas de documentos  
        $invoiceDocuments = Documento::where('doctip', 'FC')
            ->with(['usuario', 'ficheroIndividual'])
            ->get();

        $invoiceDocumentStats = [
            'total' => $invoiceDocuments->count(),
            'pendientes' => $invoiceDocuments->where('docenviado', 0)->count(),
            'enviados' => $invoiceDocuments->where('docenviado', 1)->count(),
            'pagados' => $invoiceDocuments->where('doccob', 1)->count(),
            'procesando' => $invoiceDocuments->where('doccob', 2)->count(),
            'no_pagados' => $invoiceDocuments->where('doccob', 0)->count(),
            'list' => $invoiceDocuments
        ];

        // === PEDIDOS (Presupuestos y Pedidos) ===

        // Presupuestos de pedidos (espresupuesto >= 1)
        $budgetOrders = Pedido::where('espresupuesto', '>=', 1)
            ->with(['pedidos_lineas'])
            ->orderBy('fecha', 'desc')
            ->get();

        // Debug removido - datos encontrados: 20 presupuestos de 48 total


        $budgetOrderStats = [
            'total' => $budgetOrders->count(),
            'pendientes' => $budgetOrders->where('estado', 10)->count(),    // Presupuesto Pendiente
            'confirmados' => $budgetOrders->where('estado', 11)->count(),  // Presupuesto Confirmado
            'realizados' => $budgetOrders->where('estado', 2)->count(),      // Pedido Realizado
            'procesando' => $budgetOrders->where('estado', 3)->count(),  // Procesando
            'preparados' => $budgetOrders->where('estado', 4)->count(),    // Preparado
            'entregados' => $budgetOrders->where('estado', 6)->count(),   // Entregado
            'list' => $budgetOrders
        ];

        // Pedidos normales (espresupuesto = 0 o null)
        $orders = Pedido::where(function ($query) {
            $query->where('espresupuesto', 0)
                ->orWhereNull('espresupuesto');
        })
            ->with(['pedidos_lineas'])
            ->orderBy('fecha', 'desc')
            ->get();

        $orderStats = [
            'total' => $orders->count(),
            'realizados' => $orders->where('estado', 2)->count(),      // Pedido realizado
            'procesando' => $orders->where('estado', 3)->count(),  // Procesando
            'preparados' => $orders->where('estado', 4)->count(),    // Preparado
            'entregados' => $orders->where('estado', 6)->count(),   // Entregado
            'list' => $orders
        ];

        return view('pages.herramientas.index', compact(
            'budgetDocumentStats',
            'invoiceDocumentStats',
            'budgetOrderStats',
            'orderStats'
        ));
    }

    public function sendBudgetForEmail(Request $request)
    {
        $request->merge([
            'sendEmail' => filter_var($request->sendEmail, FILTER_VALIDATE_BOOLEAN),
        ]);

        $request->validate([
            'sendEmail' => 'required|boolean',
        ]);

        if ($request->sendEmail !== true) {
            return response()->json(['message' => 'No se enviará el presupuesto.'], 200);
        }

        $budget = Documento::where('doctip', 'PC')
            ->where('docenviado', 0)
            ->with('usuario')
            ->get();

        foreach ($budget as $documento) {
            $user = $documento->usuario;
            if ($user && $user->email) {
                $token = bin2hex(random_bytes(32));
                $link = route('get.documentos', ['doctip' => 'Presupuestos']) . '?token=' . $token;

                dispatch(new SendPresupuestoJob($user, $documento, $token, $link))
                    ->onQueue('emails');
            }
        }

        return response()->json(['message' => 'Los correos de presupuestos se enviarán en segundo plano, puede continuar navegando dentro del sistema.']);
    }

    public function sendInvoiceForEmail(Request $request)
    {
        $request->merge([
            'sendEmail' => filter_var($request->sendEmail, FILTER_VALIDATE_BOOLEAN),
        ]);

        $request->validate([
            'sendEmail' => 'required|boolean',
        ]);

        if ($request->sendEmail !== true) {
            return response()->json(['message' => 'No se enviará el presupuesto.'], 200);
        }

        $budget = Documento::where('doctip', 'FC')
            ->where('docenviado', 0)
            ->with('usuario')
            ->get();

        foreach ($budget as $documento) {
            $user = $documento->usuario;
            if ($user && $user->email) {
                $token = bin2hex(random_bytes(32));
                $link = route('get.documentos', ['doctip' => 'Facturas']) . '?token=' . $token;

                dispatch(new SendFacturaJob($user, $documento, $token, $link))
                    ->onQueue('emails');
            }
        }

        return response()->json(['message' => 'Los correos de facturas se enviarán en segundo plano, puede continuar navegando dentro del sistema.']);
    }

    public function showBudget($filename)
    {
        try {

            // Buscar el fichero con validación de acceso del usuario
            $fichero = DocumentoFichero::where('docfichero', $filename)
                ->first();

            if (!$fichero) {
                return response()->json(['error' => 'Archivo no encontrado o acceso no permitido.'], Response::HTTP_NOT_FOUND);
            }

            $path = storage_path('app/' . $filename);

            Log::info('Intentando obtener el documento en la ruta: ' . $path);

            if (!File::exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado.'], Response::HTTP_NOT_FOUND);
            }

            return response()->file($path);
        } catch (\Exception $e) {
            Log::error('Error al obtener documento: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener el documento.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function sendSingleBudgetForEmail(Request $request)
    {

        $request->validate([
            'budgetID' => 'required|integer|exists:qdocumento,doccon',
        ]);

        $budget = Documento::where('doccon', $request->budgetID)
            ->where('doctip', 'PC')
            ->where('docenviado', 0)
            ->with('usuario')
            ->first();

        if ($budget && $budget->usuario && $budget->usuario->email) {
            $user = $budget->usuario;
            $token = bin2hex(random_bytes(32));
            $link = route('get.documentos', ['doctip' => 'Presupuestos']) . '?token=' . $token;

            // Crear token de acceso
            AccessToken::create([
                'user_id' => $user->id,
                'token' => $token,
                'expires_at' => now()->addHours(1),
            ]);

            $data = [
                'user' => $user,
                'documento' => $budget,
                'link' => $link,
            ];

            $mailable = new PresupuestoMail($data, $link);

            Mail::to($user->email)
                ->bcc($budget->docusuariocorreo)
                ->send($mailable);

            // guardar el correo enviado
            $mimeMessage = $mailable->getSymfonyMessage()->toString();
            $this->saveSendEmail($mimeMessage);

            $budget->update(['docenviado' => 1]);

            return response()->json([
                'message' => 'El correo del presupuesto se ha enviado correctamente y el registro ha sido actualizado.'
            ]);
        }

        return response()->json(['message' => 'No se pudo enviar el correo o el presupuesto ya fue enviado.'], 400);
    }

    public function sendSingleInvoiceForEmail(Request $request)
    {

        $request->validate([
            'invoiceID' => 'required|integer|exists:qdocumento,doccon',
        ]);

        $invoice = Documento::where('doccon', $request->invoiceID)
            ->where('doctip', 'FC')
            ->where('docenviado', 0)
            ->with('usuario')
            ->first();

        if ($invoice && $invoice->usuario && $invoice->usuario->email) {
            $user = $invoice->usuario;
            $token = bin2hex(random_bytes(32));
            $link = route('get.documentos', ['doctip' => 'Facturas']) . '?token=' . $token;

            // Crear token de acceso
            AccessToken::create([
                'user_id' => $user->id,
                'token' => $token,
                'expires_at' => now()->addHours(1),
            ]);

            $data = [
                'user' => $user,
                'documento' => $invoice,
                'link' => $link,
            ];

            $mailable = new FacturaMail($data, $link);

            Mail::to($user->email)
                ->bcc($invoice->docusuariocorreo)
                ->send($mailable);

            // guardar el correo enviado
            $mimeMessage = $mailable->getSymfonyMessage()->toString();
            $this->saveSendEmail($mimeMessage);

            $invoice->update(['docenviado' => 1]);

            return response()->json([
                'message' => 'El correo de la factura se ha enviado correctamente y el registro ha sido actualizado.'
            ]);
        }

        return response()->json(['message' => 'No se pudo enviar el correo o la factura ya fue enviada.'], 400);
    }

    public function updateBudget(Request $request)
    {
        $request->validate([
            "id"            => "nullable|integer",
            "observation"   => "nullable|string",
            "estado"        => "nullable|string",
        ]);

        $documento = Documento::with('usuario')->where('doccon', $request->id)->first();

        if (!$documento) {
            return response()->json([
                'success' => false,
                'message' => 'Presupuesto no encontrado en gestión documental.'
            ]);
        }

        $documento->docestado         = $request->estado;
        $documento->docobsestado      = $request->observation;
        $documento->docestadoenviado  = 0;
        $documento->save();

        $data = $documento->toArray();
        $data["estado"] = $request->estado;

        // Armamos la lista de destinatarios
        $destinatarios = [];

        if (!empty($documento->docusuariocorreo)) {
            $destinatarios[] = $documento->docusuariocorreo;
        }

        // Siempre agregamos qanet
        $destinatarios[] = 'qanet@redesycomponentes.com';

        try {
            $mailable = new \App\Mail\DocumentoNotifyMail(
                $data,
                'pages.ecommerce.pedidos.email-notify-creator', // vista
                'Confirmación de documento'                     // asunto
            );

            Mail::to($destinatarios)->send($mailable);

            // Guardar correo enviado
            $mimeMessage = $mailable->getSymfonyMessage()->toString();
            $this->saveSendEmail($mimeMessage);
        } catch (\Exception $e) {
            Log::error('Error al enviar email de confirmación: ' . $e->getMessage());
        }

        $statusMessage = $request->estado === 'F' ? 'aceptado' : 'rechazado';

        return response()->json([
            'success' => true,
            'message' => "Presupuesto {$statusMessage} correctamente."
        ]);
    }

    public function updateInvoice(Request $request)
    {
        $request->validate([
            "id"            => "nullable|integer",
            "observation"   => "nullable|string",
            "estado"        => "nullable|string",
        ]);

        $documento = Documento::with('usuario')->where('doccon', $request->id)->first();

        if (!$documento) {
            return response()->json([
                'success' => false,
                'message' => 'Factura no encontrada en gestión documental.'
            ]);
        }

        $documento->docestado         = $request->estado;
        $documento->docobsestado      = $request->observation;
        $documento->docestadoenviado  = 0;
        $documento->save();

        $data = $documento->toArray();
        $data["estado"] = $request->estado;

        // Armamos la lista de destinatarios
        $destinatarios = [];

        if (!empty($documento->docusuariocorreo)) {
            $destinatarios[] = $documento->docusuariocorreo;
        }

        // Siempre agregamos qanet
        $destinatarios[] = 'qanet@redesycomponentes.com';

        try {
            $mailable = new \App\Mail\DocumentoNotifyMail(
                $data,
                'pages.ecommerce.pedidos.email-notify-creator', // vista
                'Confirmación de documento'                     // asunto
            );

            Mail::to($destinatarios)->send($mailable);

            // Guardar correo enviado
            $mimeMessage = $mailable->getSymfonyMessage()->toString();
            $this->saveSendEmail($mimeMessage);
        } catch (\Exception $e) {
            Log::error('Error al enviar email de confirmación: ' . $e->getMessage());
        }

        $statusMessage = $request->estado === 'F' ? 'aceptada' : 'rechazada';

        return response()->json([
            'success' => true,
            'message' => "Factura {$statusMessage} correctamente."
        ]);
    }

    public function downloadDocument($docId)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            abort(401, 'No autorizado.');
        }

        // Buscar el documento
        $documento = Documento::find($docId);
        if (!$documento) {
            abort(404, 'Documento no encontrado.');
        }

        // Buscar los ficheros asociados
        $ficheros = DocumentoFichero::where('qdocumento_id', $docId)->get();
        if ($ficheros->count() === 0) {
            abort(404, 'No se encontraron archivos para este documento.');
        }

        if ($ficheros->count() === 1) {
            // Descarga directa para un solo archivo
            $filePath = storage_path('app/' . $ficheros->first()->docfichero);
            return $this->downloadFile($filePath);
        } else {
            // Crear un ZIP para múltiples archivos
            return $this->createAndDownloadZip($ficheros, $docId);
        }
    }

    private function downloadFile($filePath)
    {
        Log::info('Descargando archivo desde tools: ' . $filePath);

        if (isset($filePath) && file_exists($filePath)) {
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $contentType = $this->getContentType($fileExtension);
            return response()->download($filePath, basename($filePath), ['Content-Type' => $contentType]);
        }

        Log::error('Archivo no encontrado en tools: ' . $filePath);
        abort(404, 'Archivo no encontrado');
    }

    private function createAndDownloadZip($ficheros, $docId)
    {
        $zip = new \ZipArchive();
        $zipFileName = "documentos-{$docId}.zip";
        $zipFilePath = storage_path('app/' . $zipFileName);

        try {
            if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
                foreach ($ficheros as $fichero) {
                    $filePath = storage_path('app/' . $fichero->docfichero);
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, basename($filePath));
                    }
                }
                $zip->close();
                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            } else {
                abort(404, 'Error al crear el archivo ZIP');
            }
        } catch (\Exception $e) {
            Log::error('Error al crear el archivo ZIP: ' . $e->getMessage());
            abort(500, 'Error al crear el archivo ZIP: ' . $e->getMessage());
        }
    }

    private function getContentType($fileExtension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'zip' => 'application/zip',
        ];

        return $mimeTypes[$fileExtension] ?? 'application/octet-stream';
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

    ///gestión de usuarios
    public function manageUsers()
    {
        $users = User::all();
        $roles = ['SA', 'Admin', 'Usuario', 'Cliente', 'Representante'];

        return view('pages.herramientas.management-user', compact('users', 'roles'));
    }

    public function changeUserRole(Request $request, $id)
    {
        $request->validate([
            'usugrucod' => 'required|string|in:SA,Admin,Usuario,Cliente,Representante',
        ]);

        $user = User::findOrFail($id);
        $user->usugrucod = $request->usugrucod;
        $user->save();

        return response()->json(['message' => 'Rol de usuario actualizado correctamente.']);
    }

    public function updateUserPassword(Request $request, $id)
    {
        $request->validate([
            'password_confirmation' => 'required|string|min:8',
        ]);

        $user = User::findOrFail($id);
        $user->password = password_hash($request->password_confirmation, PASSWORD_BCRYPT, ['cost' => 10]);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente.']);
    }

    public function getUserAgenda($id)
    {
        try {
            $user = User::findOrFail($id);
            $agenda = $user->agenda()->select('id', 'agenom', 'agetelmov', 'ageema', 'agecon')->get();

            return response()->json($agenda);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudieron cargar los contactos de la agenda.'], 500);
        }
    }

    public function updateOrderStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|integer|in:2,3,4,6'
            ]);

            $order = Pedido::findOrFail($id);

            // Verificar que el estado nuevo sea válido según el estado actual
            $validTransitions = [
                2 => [3], // Realizado -> Procesando
                3 => [4], // Procesando -> Preparado  
                4 => [6], // Preparado -> Entregado
            ];

            if (
                !isset($validTransitions[$order->estado]) ||
                !in_array($request->status, $validTransitions[$order->estado])
            ) {
                return response()->json(['error' => 'Transición de estado no válida.'], 400);
            }

            $order->estado = $request->status;
            $order->save();

            $statusNames = [
                2 => 'Realizado',
                3 => 'Procesando',
                4 => 'Preparado',
                6 => 'Entregado'
            ];

            return response()->json([
                'message' => 'Estado del pedido actualizado a: ' . $statusNames[$request->status]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo actualizar el estado del pedido.'], 500);
        }
    }

    public function updatePresupuestoPedido(Request $request, $id)
    {
        try {
            $request->validate([
                'action' => 'required|string|in:confirmar,rechazar'
            ]);

            $presupuesto = Pedido::where('id', $id)
                ->where('espresupuesto', '>=', 1)
                ->firstOrFail();

            if ($request->action === 'confirmar') {
                // Cambiar estado a confirmado (11)
                $presupuesto->estado = 11;
                $presupuesto->aceptado = 1;
                $message = 'Presupuesto confirmado correctamente.';
            } else {
                // Rechazar presupuesto - podemos usar un estado personalizado o mantener registro
                $presupuesto->aceptado = 0;
                $message = 'Presupuesto rechazado correctamente.';
            }

            $presupuesto->save();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar el presupuesto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function convertirPresupuestoAPedido(Request $request, $id)
    {
        try {
            $presupuesto = Pedido::where('id', $id)
                ->where('espresupuesto', '>=', 1)
                ->where('estado', 11) // Solo presupuestos confirmados
                ->firstOrFail();

            // Convertir a pedido cambiando estado a "Realizado" (2)
            $presupuesto->estado = 2;
            $presupuesto->save();

            return response()->json([
                'success' => true,
                'message' => 'Presupuesto convertido a pedido correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo convertir el presupuesto: ' . $e->getMessage()
            ], 500);
        }
    }
}
