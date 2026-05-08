<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;
    protected $table = 'qarticulo_precio';
    protected $primaryKey = 'precod';

    protected $fillable = [
        'preartcod',
        'pretarcod',
        'preimp'
    ];  
    public function articulos()
    {
        return $this->hasMany(Articulo::class, 'artcod', 'preartcod');
    }
}
