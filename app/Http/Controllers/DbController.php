<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DbController extends Controller
{
  public function truncateAllTables()
  {
    // Desactivar claves foráneas    
    DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

    // Obtener todas las tablas de la base de datos
    $tables = DB::select('SHOW TABLES');
    $dbName = env('DB_DATABASE'); // Nombre de la base de datos desde el .env
    foreach ($tables as $table) {
      // El nombre de las tablas está en el primer índice del objeto
      $tableName = $table->{'Tables_in_' . $dbName};

      // Ejecutar el TRUNCATE para cada tabla        
      DB::statement("TRUNCATE TABLE `$tableName`");
    }

    // Reactivar claves foráneas
    DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

    $user = new User();
    $user->name = 'José Pozo';
    $user->email = 'josepozo@redesycomponentes.com';
    $user->email_verified_at = now();
    $user->password = bcrypt('34023511w');
    $user->usugrucod = 'SA';
    $user->save();

    Auth::logout();

    return response()->json(['status' => 'success', 'redirect' => '/login']);
  }
}
