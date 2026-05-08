<?php
return [
    'key'                   => env('REDSYS_KEY', ''),
    'url_notification'      => env('REDSYS_URL_NOTIFICATION', ''),
    'url_ok'                => env('REDSYS_URL_OK', ''),
    'url_ko'                => env('REDSYS_URL_KO', ''),
    'merchantcode'          => env('REDSYS_MERCHANT_CODE', ''),
    'terminal'              => env('REDSYS_TERMINAL', '1'),
    'enviroment'            => env('REDSYS_ENVIROMENT', 'test'),
    'signatured'            => env('REDSYS_SIGNATURE_VERSION', 'HMAC_SHA256_V1'),
    'currency'              => env('REDSYS_CURRENCY', '978'),
    'url' => [
        'test' => 'https://sis-t.redsys.es:25443/sis/realizarPago', // Entorno de pruebas
        'live' => 'https://sis.redsys.es/sis/realizarPago', // Entorno de producción
    ],

];
