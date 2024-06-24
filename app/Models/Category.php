<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'cat_categorias';
    protected $primaryKey = 'id';
    protected $keyType = 'string';


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

    public function usuarios() {
        return $this->belongsToMany(User::class, 'qanet_clientecategoria', 'catcod', 'clicod', 'id', 'usuclicod');

    }

    public function getCatcodAttribute($value)
    {
        return strval($value);
    }

}