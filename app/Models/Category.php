<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table        = 'qcategoria';
    protected $primaryKey   = 'catcod';
    protected $keyType      = 'string';


    protected $fillable = [
        'catnom',
        'catcatcod',
        'catima',
    ];
    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'artcatcodw1', 'catcod');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'qanet_clientecategoria', 'catcod', 'clicod', 'catcod', 'usuclicod');
    }

    public function getCatcodAttribute($value)
    {
        return strval($value);
    }
}
