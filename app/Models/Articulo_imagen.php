<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo_imagen extends Model
{
    use HasFactory;
    protected $table = 'qarticulo_imagen';

    protected $fillable = [
        'imanom'
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'imaartcod', 'artcod');
    }
    
}
