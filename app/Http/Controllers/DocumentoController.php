<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Documento;
use App\Models\DocumentoFichero;

use ZipArchive;
use File; 
use Carbon\Carbon;

class DocumentoController extends Controller{
    //
    public function getDocumentos(Request $request, $doctip = null) {
        if ($request->ajax()) {

            $user = Auth::user();
            $query = $user->documentos()->with(['ficheros' => function($query) {
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
    
        return view('pages.documentos.document', compact('doctip'));
    }
    
    public function descargarDocumento($docId) {
        // dd('a');
        
        $ficheros = DocumentoFichero::where('qdocumento_id', $docId)->get();
        $documento = Documento::find($docId);

        if (trim($documento->docclicod) !== trim(Auth::user()->usuclicod)) {
            abort(403, 'No tienes permiso para descargar este documento.');
        }

        if ($ficheros->count() === 1) {
            // Descarga directa para un solo archivo
            $filePath = storage_path('app/' . $ficheros->first()->docfichero);
            return $this->descargarArchivo($filePath);
    
        } elseif ($ficheros->count() > 1) {
            // Crear un ZIP para múltiples archivos
            return $this->crearYDescargarZip($ficheros, $docId);
        }
    
        abort(404, 'Documento no encontrado');
    }
    
    private function descargarArchivo($filePath) {

        Log::info('Intentando descargar el archivo en la ruta: ' . $filePath);
    
        if (isset($filePath) && file_exists($filePath)) {
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $contentType = $this->getContentType($fileExtension);
            return Response::download($filePath, basename($filePath), ['Content-Type' => $contentType]);
        }
    
        Log::error('Archivo no encontrado en la ruta: ' . $filePath);
        abort(404, 'Archivo no encontrado');
    }
    
    private function crearYDescargarZip($ficheros, $docId) {

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
    

    public function verDocumento($filename)
    {
        // dd('pasa');

        $user = Auth::user();
        $fichero = DocumentoFichero::where('docfichero', $filename)
        ->join('qdocumento', 'qdocumento.doccon', '=', 'qdocumento_fichero.qdocumento_id')
        ->where('qdocumento.docclicod', $user->usuclicod) 
        ->first();
                                
        
        if (!$fichero) {
            abort(404, 'Archivo no encontrado o acceso no permitido.');
        }
        
        $path = storage_path('app/' . $filename); 
        // dd($path);
        
        if (!file_exists($path)) {
            abort(404, 'Archivo no encontrado.');
        }

        return response()->file($path); 
    }


    private function getContentType($fileExtension) {
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
    
    
}