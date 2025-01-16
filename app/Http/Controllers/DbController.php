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

    // Depuración: imprimir el contenido de $tables
    // dd($tables);

    foreach ($tables as $table) {
      // Obtener el nombre de la tabla sin importar el nombre de la propiedad
      $tableName = array_values((array)$table)[0];
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
    $user->usudocpen = 0;
    $user->save();

    Auth::logout();

    return redirect()->route('login');
  }
}
