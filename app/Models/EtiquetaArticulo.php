<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtiquetaArticulo extends Model
{
    use HasFactory;
    protected $table = 'qarticulo_etiqueta';
    protected $primaryKey = 'eticod';


    protected $fillable = [
        'etiartcod',
        'etitagcod'
    ];
    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'etiartcod');
    }

    public function etiqueta()
    {
        return $this->belongsTo(Etiqueta::class, 'etitagcod'); 
    }
}
