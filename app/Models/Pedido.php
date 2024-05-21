<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    public $timestamps = false;


    protected $fillable = [
        'cliente_id',
        'accclicod',
        'acccencod',
        'estado',
        'fecha',
        'subtotal',
        'total',
    ];
    public function pedidos_lineas()
    {
        return $this->hasMany(PedidoLinea::class, 'pedido_id', 'id');
    }
}
