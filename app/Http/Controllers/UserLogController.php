<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\UserLog;

class UserLogController extends Controller
{
    //
    public function downloadFile() : StreamedResponse
    {
        $fileName = 'logs.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        return response()->streamDownload(function () {
            $fileHandle = fopen('php://output', 'w');

            fputcsv($fileHandle, ['Nombre', 'Email', 'Codigo de usuario', 'Fecha de entrada', 'Fecha de salida'], ';');

            $users = UserLog::all();
            foreach ($users as $user) {
                fputcsv($fileHandle, [$user->name, $user->email, $user->usuclicod, $user->fechorentrada, $user->fechorsalida], ';');
            }

            fclose($fileHandle);
        }, $fileName, $headers);

    }
}
