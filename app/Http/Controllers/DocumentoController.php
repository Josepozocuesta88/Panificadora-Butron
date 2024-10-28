<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Ssheduardo\Redsys\Facades\Redsys;

use App\Models\Documento;
use App\Models\DocumentoFichero;

use ZipArchive;
use File;
use Carbon\Carbon;

class DocumentoController extends Controller
{
    //
    public function getDocumentos(Request $request, $doctip = null)
    {
        if ($request->ajax()) {

            $user = Auth::user();
            if (Auth::user() && Auth::user()->usugrucod !== 'Admin' && $doctip == 'Albaranes')
                return response()->json(['data' => []]);
            $query = $user->documentos()->with(['ficheros' => function ($query) {
                $query->select('qdocumento_id', 'docfichero');
            }]);
            $columns = ['doccon', 'doctip', 'docser', 'doceje', 'docnum', 'docfec', 'docimp', 'docimptot'];

            if (!is_null($doctip)) {
                $doctip = $doctip == 'Facturas' ? "FC" : "AC";
                $query->where('doctip', $doctip);

                if ($doctip === "FC") {
                    $columns = array_merge($columns, ['docimppen', 'doccob']);
                }
            }

            $documentos = $query->orderBy('docfec', 'desc')->get($columns);

            $data = $documentos->map(function ($documento) {
                $docficheros = $documento->ficheros->pluck('docfichero');
                $response = [
                    'doccon' => $documento->doccon,
                    'doctip' => $documento->doctip,
                    'docser' => $documento->docser,
                    'doceje' => $documento->doceje,
                    'docnum' => $documento->docnum,
                    'docfec' => $documento->docfec,
                    'docimp' => $documento->docimp,
                    'docimptot' => $documento->docimptot,
                    'docfichero' => $docficheros,
                    'descarga' => $documento->ficheros->first() ? $documento->ficheros->first()->qdocumento_id : null,
                ];


                if (isset($documento->docimppen)) {
                    $response['docimppen'] = $documento->docimppen;
                }
                if (isset($documento->doccob)) {
                    $response['doccob'] = $documento->doccob;
                }

                return $response;
            });

            return response()->json(['data' => $data]);
        }
        if (Auth::user() && Auth::user()->usugrucod !== 'Admin' && $doctip == 'Albaranes')
            return back()->with('error', 'No permitivo');

        return view('pages.documentos.document', compact('doctip'));
    }

    public function descargarDocumento($docId)
    {
        // dd('a');

        $ficheros = DocumentoFichero::where('qdocumento_id', $docId)->get();
        $documento = Documento::find($docId);

        if (trim($documento->docclicod) !== trim(Auth::user()->usuclicod)) {
            abort(403, 'No tienes permiso para descargar este documento.');
        }

        if ($ficheros->count() === 1) {
            // Descarga directa para un solo archivo
            $filePath = storage_path('app/facturas/' . $ficheros->first()->docfichero);
            return $this->descargarArchivo($filePath);
        } elseif ($ficheros->count() > 1) {
            // Crear un ZIP para múltiples archivos
            return $this->crearYDescargarZip($ficheros, $docId);
        }

        abort(404, 'Documento no encontrado');
    }

    private function descargarArchivo($filePath)
    {

        Log::info('Intentando descargar el archivo en la ruta: ' . $filePath);

        if (isset($filePath) && file_exists($filePath)) {
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $contentType = $this->getContentType($fileExtension);
            return Response::download($filePath, basename($filePath), ['Content-Type' => $contentType]);
        }

        Log::error('Archivo no encontrado en la ruta: ' . $filePath);
        abort(404, 'Archivo no encontrado');
    }

    private function crearYDescargarZip($ficheros, $docId)
    {

        Log::info('Entrando a la función crearYDescargarZip');
        $zip = new ZipArchive();
        $zipFileName = "documentos-{$docId}.zip";
        $zipFilePath = storage_path('app/' . $zipFileName);

        try {
            Log::info('Intentando abrir el archivo ZIP: ' . $zipFilePath);
            if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
                Log::info('Archivo ZIP abierto correctamente');
                foreach ($ficheros as $fichero) {
                    $filePath = storage_path('app/' . $fichero->docfichero);
                    Log::info('Procesando archivo: ' . $filePath);
                    if (file_exists($filePath)) {
                        Log::info('Archivo encontrado: ' . $filePath);
                        $zip->addFile($filePath, basename($filePath));
                    } else {
                        Log::warning('Archivo no encontrado: ' . $filePath);
                    }
                }
                $zip->close();
                Log::info('Archivo ZIP creado correctamente: ' . $zipFilePath);
                return response()->download($zipFilePath)->deleteFileAfterSend(true);
            } else {
                Log::error('Error al abrir el archivo ZIP');
                abort(404, 'Error al crear el archivo ZIP');
            }
        } catch (\Exception $e) {
            Log::error('Error al crear el archivo ZIP: ' . $e->getMessage());
            abort(500, 'Error al crear el archivo ZIP: ' . $e->getMessage());
        } finally {
            // Cierra la conexión a la base de datos
            DB::disconnect();
        }
    }

    public function verArchivoTemporal($path)
    {
        $filePath = Storage::disk('local')->path(base64_decode($path));
        return response()->file($filePath, [
            'Content-Disposition' => ' filename="' . basename($filePath) . '"'
        ]);
    }

    public function verDocumento($filename)
    {


        // $user = Auth::user();
        // $fichero = DocumentoFichero::where('docfichero', $filename)
        //     ->whereHas('documento', function ($query) use ($user) {
        //         $query->where('docclicod', $user->usuclicod);
        //     })
        //     ->first();

        // if (!$fichero) {
        //     abort(404, 'Archivo no encontrado o acceso no permitido.');
        // }

        // if (!Storage::disk('local')->exists($filename)) {
        //     abort(404, 'Archivo no encontrado.');
        // }

        // $url = Storage::disk('local')->temporaryUrl(
        //     base64_encode($filename),
        //     now()->addMinutes(1)
        // );
        // return response()->json(['url' => $url]);

        try {
            $user = Auth::user();
            $fichero = DocumentoFichero::where('docfichero', $filename)
                ->whereHas('documento', function ($query) use ($user) {
                    $query->where('docclicod', $user->usuclicod);
                })
                ->first();

            if (!$fichero) {
                return response()->json(['error' => 'Archivo no encontrado o acceso no permitido.'], Response::HTTP_NOT_FOUND);
            }

            $path = storage_path('app/facturas/' . $filename);

            // $path = base_path('/../../../../facturas/' . $filename);
            
            Log::info('Intentando obtener el documento en la ruta: ' . $path);

            if (!File::exists($path)) {
                return response()->json(['error' => 'Archivo no encontrado.'], Response::HTTP_NOT_FOUND);
            }

            return response()->file($path);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el documento.'], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            // Agrega más tipos de archivo si es necesario
        ];

        return $mimeTypes[$fileExtension] ?? 'application/octet-stream';
    }



    // función de pasarela de pago
    public function payment(Request $request)
    {
        // Obtener datos de la solicitud
        $id = $request->input('id'); // Número de pedido
        $order = $request->input('numero'); // Número de pedido
        $importe_completo = $request->input('importe'); // Importe total
        $isTest = $request->input('test', 1); // Modo de prueba o producción
        $order_compuesta = (string)$id . "_" . (string)$order;

        try {
            //             
            // $key = config('redsys.key');
            $key = ("sq7HjrUOBfKmC576ILgskD5srU870gJ7");
            $code = config('redsys.merchantcode');

            Redsys::setAmount($importe_completo);
            Redsys::setOrder($order_compuesta);
            Redsys::setMerchantcode($code); //Reemplazar por el código que proporciona el banco
            Redsys::setCurrency('978');
            Redsys::setTransactiontype('0');
            Redsys::setTerminal('1');
            Redsys::setMethod('T'); //Solo pago con tarjeta, no mostramos iupay
            Redsys::setNotification(config('redsys.url_notification')); //Url de notificacion
            Redsys::setUrlOk(config('redsys.url_ok')); //Url OK
            Redsys::setUrlKo(config('redsys.url_ko')); //Url KO
            Redsys::setVersion('HMAC_SHA256_V1');
            Redsys::setTradeName('Congelados Florys');
            Redsys::setTitular('Javier');
            Redsys::setProductDescription('Pago Facturas');
            Redsys::setEnviroment('test'); //Entorno test

            $signature = Redsys::generateMerchantSignature($key);
            Redsys::setMerchantSignature($signature);

            $form = Redsys::createForm();
            // Verificar la respuesta de Redsys
            return response()->json([
                'success' => true,
                'form' => $form
            ]);
        } catch (\Exception $e) {
            // Manejar excepciones
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function paymentSuccess(Request $request)
    {
        // $message = $request->all();
        // if (isset($message['Ds_MerchantParameters'])) {
        //     $decode = json_decode(base64_decode($message['Des_MerchantParameters']), true);
        //     $date = urldecode($decode['Ds_Date']);
        //     $hour = urldecode($decode['Ds_hour']);
        //     $decode['Ds_Date'] = $date;
        //     $decode['Ds_Hour'] = $hour;
        // }
        // return response()->json(['success' => true, 'message' => $message, 'decode' => $decode]);
        // return view('pages.documentos.document');
        return redirect()->route('get.documentos');
    }

    public function paymentError(Request $request)
    {
        // return response()->json(['success' => false, 'message' => $request->all()]);
        return redirect()->route('get.documentos');
    }

    public function documentUpdate(Request $request)
    {
        // Validar la solicitud para asegurarse de que el ID y el estado estén presentes
        // $request->validate([
        //     'id' => 'required|integer|exists:qdocumento,doccon', // Asegurarse de que el ID existe
        //     'status' => 'required|string' // Asegurarse de que el estado sea una cadena
        // ]);

        // Obtener el estado y el ID del documento
        $status = $request->input('status');
        $id = $request->input('id');

        // Inicializar la variable de mensaje
        $message = '';

        // Comprobar si el estado es "Pendiente"
        if ($status === "Procesando") {
            // Encontrar el documento y actualizar su estado
            $factura = Documento::findOrFail($id);
            $factura->doccob = 2;
            $factura->save();
            $message = "El documento ha sido actualizado a 'Pendiente'.";

            return response()->json(['success' => true, 'message' => $message]);
        }

        // Manejo de estado no reconocido
        $message = "El estado proporcionado no es válido.";
        return response()->json(['error' => true, 'message' => $message]);
    }
}
