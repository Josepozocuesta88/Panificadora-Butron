<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido_linea extends Model
{
    use HasFactory;
    protected $table = 'pedidos_lineas';
    public $timestamps = false;

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'producto_ref',
        'cantidad_unidades',
        'precio',
        'impuesto',
        'aclcajcod',
        'aclcancaj',
    ];
    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'producto_id', 'artcod');
    }
    
}
