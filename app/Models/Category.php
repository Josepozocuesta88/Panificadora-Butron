<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'cat_categorias';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre_es',
        'imagen', 
        'catsolcli',
    ];  
    public function articulos()
    {
        // return $this->hasMany(Articulo::class, 'cat', 'id');
        // return $this->hasMany(Articulo::class, 'artcatcod3', 'id');
        return $this->hasMany(Articulo::class, 'artcatcodw1', 'id');
    }
    // Definimos un accesor siguiendo la convención de nomenclatura de laravel para accesores y conmutadores
    // con ello laravel sabe con que campo de la tabla lo va a usar
    // Convierte el valor de artcod a una cadena antes de devolverlo
    // esto lo hago porque se estaba interpretando la primary key como un valor de tipo entero a pesar de ser un string, 
    // esto podria estar ocurriendo o bien por un bug de laravel o bien por un bug en el driver de la base de datos.

    public function getCatcodAttribute($value)
    {
        return strval($value);
    }

    public function esCliente($esCliente)
    {
        if ($esCliente) {
            return Category::all();
        }

        return Category::where('catsolcli', 0)->get();
    }

}