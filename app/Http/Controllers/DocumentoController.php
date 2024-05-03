<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
    
        return view('sections.document', compact('doctip'));
    }

    public function descargarDocumento($docId) {
        $ficheros = DocumentoFichero::where('qdocumento_id', $docId)->get();
    
        if ($ficheros->count() === 1) {
            // Descarga directa para un solo archivo
            $filePath = public_path('images/files/' . $ficheros->first()->docfichero);
            return $this->descargarArchivo($filePath);
        } elseif ($ficheros->count() > 1) {
            // Crear un ZIP para múltiples archivos
            return $this->crearYDescargarZip($ficheros, $docId);
        }
    
        abort(404, 'Documento no encontrado');
    }
    
    private function descargarArchivo($filePath) {
        if (file_exists($filePath)) {
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $contentType = $this->getContentType($fileExtension);
            return Response::download($filePath, basename($filePath), ['Content-Type' => $contentType]);
        }
    
        abort(404, 'Archivo no encontrado');
    }
    
    private function crearYDescargarZip($ficheros, $docId) {
        $zip = new ZipArchive();
        $zipFileName = "documentos-{$docId}.zip";
    
        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE) === TRUE) {
            foreach ($ficheros as $fichero) {
                $filePath = public_path('images/files/' . $fichero->docfichero);
                if(file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }
            $zip->close();
            return Response::download(public_path($zipFileName));
        }
    
        abort(404, 'Error al crear el archivo ZIP');
    }
    private function getContentType($fileExtension) {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            // Agrega más tipos de archivo si es necesario
        ];
    
        return $mimeTypes[$fileExtension] ?? 'application/octet-stream';
    }
    
    
}